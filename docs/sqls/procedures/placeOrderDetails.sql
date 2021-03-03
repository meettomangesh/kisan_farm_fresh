DELIMITER $$
DROP PROCEDURE IF EXISTS placeOrderDetails$$
CREATE PROCEDURE placeOrderDetails(IN inputData JSON)
placeOrderDetails:BEGIN
    DECLARE productsId,productUnitId,quantity,orderId,lastInsertId,customerId INTEGER(10) DEFAULT 0;
    DECLARE sellingPrice,specialPrice DECIMAL(14,4) DEFAULT 0.00;
    DECLARE specialPriceStartDate,specialPriceEndDate,expiryDate DATE DEFAULT NULL;

    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE placeOrderDetails;
    END IF;
    SET productsId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.id'));
    SET productUnitId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.product_unit_id'));
    SET quantity = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.quantity'));
    SET sellingPrice = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.selling_price'));
    SET specialPrice = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price'));
    SET orderId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.order_id'));
    SET customerId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.customer_id'));

    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date')) != "null" THEN
        SET specialPriceStartDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date'));
    END IF;
    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date')) != "null" THEN
        SET specialPriceEndDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date'));
    END IF;
    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date')) != "null" THEN
        SET expiryDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date'));
    END IF;
    
    
    INSERT INTO customer_order_details (customer_id,order_id,products_id,product_units_id,item_quantity,expiry_date,selling_price,special_price,special_price_start_date,special_price_end_date,created_by)
    VALUES (customerId,orderId,productsId,productUnitId,quantity,expiryDate,sellingPrice,specialPrice,specialPriceStartDate,specialPriceEndDate,1);

    IF LAST_INSERT_ID() > 0 THEN
        SET lastInsertId = LAST_INSERT_ID();
        INSERT INTO customer_order_status_track (order_details_id,created_by)
        VALUES (lastInsertId,1);

        UPDATE product_location_inventory SET current_quantity = current_quantity - quantity WHERE product_units_id = productUnitId;

        IF (SELECT current_quantity FROM product_location_inventory WHERE product_units_id = productUnitId) = 0 THEN
            UPDATE product_units SET status = 0, updated_by = 1 WHERE id = productUnitId;
        END IF;
    ELSE
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Failed to add.','data',JSON_OBJECT(),'statusCode',101) AS response;
        LEAVE placeOrderDetails;
    END IF;

    SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Order details added successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    LEAVE placeOrderDetails;
END$$
DELIMITER ;