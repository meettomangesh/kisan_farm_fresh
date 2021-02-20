DELIMITER $$
DROP PROCEDURE IF EXISTS getProductList$$
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

    SELECT p.id,p.product_name,p.short_description,p.expiry_date,p.selling_price,p.special_price,p.special_price_start_date,p.special_price_end_date,p.min_quantity,p.max_quantity
    FROM products AS p
    WHERE p.deleted_at IS NULL AND p.status = 1 AND p.stock_availability = 1 AND IF(categoryId = 0 OR categoryId IS NULL, 1=1, p.category_id = categoryId)
    -- AND (searchValue IS NULL, 1=1, p.product_name LIKE "%searchValue%")
    ORDER BY p.selling_price ASC
    LIMIT noOfRecords
    OFFSET pageNumber;
    -- SELECT JSON_OBJECT('status','SUCCESS', 'message','No record found.','data',JSON_OBJECT('statusCode',104),'statusCode',104) AS response;
    -- LEAVE getProductList;
    END$$
DELIMITER ;
