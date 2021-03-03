DELIMITER $$
DROP PROCEDURE IF EXISTS validateProduct$$
CREATE PROCEDURE validateProduct(IN inputData JSON)
validateProduct:BEGIN
    DECLARE productsId,productUnitId,quantity INTEGER(10) DEFAULT 0;
    DECLARE sellingPrice,specialPrice DECIMAL(14,4) DEFAULT 0.00;
    DECLARE specialPriceStartDate,specialPriceEndDate,expiryDate DATE DEFAULT NULL;

    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE validateProduct;
    END IF;
    SET productsId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.id'));
    SET productUnitId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.product_unit_id'));
    SET quantity = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.quantity'));
    SET sellingPrice = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.selling_price'));
    SET specialPrice = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price'));

    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date')) != "null" THEN
        SET specialPriceStartDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_start_date'));
    END IF;
    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date')) != "null" THEN
        SET specialPriceEndDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.special_price_end_date'));
    END IF;
    IF JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date')) != "" AND JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date')) != "null" THEN
        SET expiryDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.expiry_date'));
    END IF;
    
    IF productsId = 0 OR productUnitId = 0 OR quantity = 0 OR sellingPrice = 0 OR sellingPrice = 0.00 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE validateProduct;
    END IF;

    IF NOT EXISTS(SELECT id FROM products WHERE id = productsId AND status = 1 AND deleted_at IS NULL) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Product id is not valid.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE validateProduct;
    END IF;

    IF NOT EXISTS(SELECT id FROM product_units
                    WHERE id = productUnitId AND products_id = productsId AND min_quantity <= quantity AND max_quantity >= quantity AND status = 1 AND deleted_at IS NULL
                    AND IF(specialPrice > 0, CURDATE() >= specialPriceStartDate AND CURDATE() <= specialPriceEndDate, 1=1)) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Product unit data is not valid.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE validateProduct;
    END IF;

    IF NOT EXISTS(SELECT id FROM product_location_inventory WHERE product_units_id = productUnitId AND current_quantity >= quantity) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Quantity not available.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE validateProduct;
    END IF;

    SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Product data is valid.','data',JSON_OBJECT(),'statusCode',200) AS response;
    LEAVE validateProduct;
END$$
DELIMITER ;