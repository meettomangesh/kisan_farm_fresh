<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpCancelOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS cancelOrder$$
        CREATE PROCEDURE cancelOrder(IN inputData JSON)
        cancelOrder:BEGIN
            DECLARE orderId,codId,productUnitsId,itemQuantity,notFound INTEGER(10) DEFAULT 0;
            DECLARE actionType,orderStatusCancelled TINYINT(1) DEFAULT 0;
        
            IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
                SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
                LEAVE cancelOrder;
            END IF;
            SET orderId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.order_id'));
            SET actionType = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.type'));
            SET orderStatusCancelled = 5;
        
            IF orderId = 0 AND actionType = 0 THEN
                SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
                LEAVE cancelOrder;
            END IF;
        
            block1:BEGIN
                DECLARE orderCursor CURSOR FOR
                SELECT id,product_units_id,item_quantity
                FROM customer_order_details
                WHERE order_id = orderId;
        
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET notFound = 1;
                OPEN orderCursor;
                orderLoop: LOOP
                    FETCH orderCursor INTO codId,productUnitsId,itemQuantity;
                    IF(notFound = 1) THEN
                        LEAVE orderLoop;
                    END IF;
        
                    IF actionType = 1 THEN
                        DELETE FROM customer_order_status_track WHERE order_details_id = codId;
                        DELETE FROM customer_order_details WHERE id = codId;
                    ELSEIF actionType = 2 THEN
                        UPDATE customer_order_details SET order_status = orderStatusCancelled WHERE id = codId;
                        INSERT INTO customer_order_status_track (order_details_id,created_by)
                        VALUES (codId,orderStatusCancelled);
                    END IF;
                    UPDATE product_location_inventory SET current_quantity = current_quantity + itemQuantity WHERE product_units_id = productUnitsId;
        
                END LOOP orderLoop;
                CLOSE orderCursor;
            END block1;
        
            IF actionType = 1 THEN
                DELETE FROM customer_orders WHERE id = orderId;
            ELSEIF actionType = 2 THEN
                UPDATE customer_orders SET order_status = orderStatusCancelled WHERE id = orderId;
            END IF;
        
            SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Order cancelled successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
            LEAVE cancelOrder;
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS cancelOrder');
    }
}
