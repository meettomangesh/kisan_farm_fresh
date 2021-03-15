<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpGetProductList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getProductList;
        CREATE PROCEDURE getProductList(IN inputData JSON)
        getProductList:BEGIN
            DECLARE searchValue,sortType,sortOn VARCHAR(100) DEFAULT '';
            DECLARE categoryId,noOfRecords,pageNumber INTEGER(10) DEFAULT 0;
        
            IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
                SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
                LEAVE getProductList;
            ELSE
                SET categoryId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.category_id'));
                SET noOfRecords = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.no_of_records'));
                SET pageNumber = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.page_number'));
                SET searchValue = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.search_value'));
                SET sortType = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.sort_type'));
                SET sortOn = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.sort_on'));
                IF noOfRecords IS NULL OR pageNumber IS NULL THEN
                    SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Something missing in input.','data',JSON_OBJECT(),'statusCode',520) AS response;
                    LEAVE getProductList;
                END IF;
            END IF;
        
            IF pageNumber > 0 THEN
                SET pageNumber = pageNumber * noOfRecords;
            END IF;
        
            SET @whrCategory = ' 1=1 ';
            IF categoryId > 0 AND categoryId IS NOT NULL THEN
                SET @whrCategory = CONCAT(' p.category_id = ', categoryId, ' ');
            END IF;
            SET @orderBy = ' p.product_name ASC ';
            SET @whrSearch = ' 1=1 ';
            IF searchValue != '' AND searchValue != 'null' THEN
              SET @whrSearch = CONCAT(' p.product_name LIKE '%', searchValue, '%');
            END IF;
        
            SET @sqlStmt = CONCAT('SELECT p.id,p.product_name,p.short_description,p.expiry_date,TRUNCATE(p.selling_price, 2) AS selling_price,TRUNCATE(p.special_price, 2) AS special_price,p.special_price_start_date,p.special_price_end_date,p.is_basket,p.min_quantity,p.max_quantity
            FROM products AS p
            LEFT JOIN categories_master AS c ON c.id = p.category_id AND c.status = 1
            WHERE p.deleted_at IS NULL AND p.status = 1 AND p.stock_availability = 1 AND IF(p.expiry_date IS NOT NULL, p.expiry_date >= CURDATE(), 1=1) AND '
            , @whrCategory, ' AND ', @whrSearch, ' ORDER BY ', @orderBy, ' LIMIT ', noOfRecords, ' OFFSET ', pageNumber);
        
            PREPARE stmt from @sqlStmt;
            EXECUTE stmt;
            DEALLOCATE PREPARE stmt;
            END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getProductList');
    }
}
