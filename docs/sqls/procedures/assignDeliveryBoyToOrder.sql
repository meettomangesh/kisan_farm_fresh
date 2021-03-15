DELIMITER $$
DROP PROCEDURE IF EXISTS assignDeliveryBoyToOrder$$
CREATE PROCEDURE assignDeliveryBoyToOrder(IN inputData JSON)
assignDeliveryBoyToOrder:BEGIN
    DECLARE orderId,userId,maxOrderCount INTEGER(10) DEFAULT 0;

    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE assignDeliveryBoyToOrder;
    END IF;
    SET orderId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.order_id'));

    IF orderId = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE assignDeliveryBoyToOrder;
    END IF;

    SELECT ru.user_id,rm.max_order_count INTO userId,maxOrderCount
    FROM customer_orders AS co
    JOIN user_address AS ua ON ua.id = co.shipping_address_id
    JOIN pin_codes AS pc ON pc.pin_code = ua.pin_code
    JOIN pin_code_region AS pcr ON pcr.pin_code_id = pc.id
    JOIN region_user AS ru ON ru.region_id = pcr.region_id
    JOIN region_master AS rm ON rm.id = ru.region_id
    WHERE co.id = orderId AND co.order_status NOT IN (4,5) AND ua.status = 1 AND pc.status = 1 AND pcr.status = 1 AND ru.status = 1 AND rm.status = 1;

    IF userId > 0 AND maxOrderCount > 0 AND (SELECT COUNT(id) FROM customer_orders WHERE order_status NOT IN (4,5) AND delivery_boy_id = userId) < maxOrderCount THEN
        UPDATE customer_orders SET delivery_boy_id = userId WHERE id = orderId;
    ELSE
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Failed to assign delivery boy.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE assignDeliveryBoyToOrder;
    END IF;

    SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Delivery boy assigned successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    LEAVE assignDeliveryBoyToOrder;
END$$
DELIMITER ;