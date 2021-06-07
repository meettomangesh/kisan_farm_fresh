DELIMITER $$
DROP PROCEDURE IF EXISTS storeProductInWishlist$$
CREATE PROCEDURE storeProductInWishlist(IN inputData JSON)
storeProductInWishlist:BEGIN
    DECLARE userId,productUnitsId INTEGER(10) DEFAULT 0;
    DECLARE isBasket TINYINT(1) DEFAULT 0;
    
    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeProductInWishlist;
    END IF;
    SET userId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.user_id'));
    SET productUnitsId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.product_units_id'));
    SET isBasket = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.is_basket'));

    IF userId = 0 OR productUnitsId = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeProductInWishlist;
    END IF;
   
    IF NOT EXISTS(SELECT id FROM users WHERE id = userId) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Invalid user.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeProductInWishlist;
    END IF;

    IF isBasket = 0 AND NOT EXISTS(SELECT id FROM product_units WHERE id = productUnitsId) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Invalid product unit.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeProductInWishlist;
    ELSEIF isBasket = 1 AND NOT EXISTS(SELECT id FROM products WHERE id = productUnitsId AND is_basket = 1) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Invalid basket.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeProductInWishlist;
    ELSE
        INSERT INTO customer_wishlist (user_id,product_units_id,is_basket,created_by)
        VALUES (userId,productUnitsId,isBasket,userId);
    END IF;

    SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Product/Basket stored successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    LEAVE storeProductInWishlist;
END$$
DELIMITER ;