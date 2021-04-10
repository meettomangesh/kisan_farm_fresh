DELIMITER $$
DROP PROCEDURE IF EXISTS storeDeviceToken$$
CREATE PROCEDURE storeDeviceToken(IN inputData JSON)
storeDeviceToken:BEGIN
    DECLARE userId INTEGER(10) DEFAULT 0;
    DECLARE deviceToken VARCHAR(255) DEFAULT NULL;

    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeDeviceToken;
    END IF;
    SET userId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.user_id'));
    SET deviceToken = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.device_token'));

    IF userId = 0 AND (deviceToken != '' OR deviceToken IS NULL) THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeDeviceToken;
    END IF;
   
    IF EXISTS(SELECT id FROM customer_device_tokens WHERE user_id = userId) THEN
        UPDATE customer_device_tokens SET device_token = deviceToken, updated_by = 1 WHERE user_id = userId;
    ELSEIF EXISTS(SELECT id FROM users WHERE id = userId) THEN
        INSERT INTO customer_device_tokens (user_id,device_token,created_by)
        VALUES (userId,deviceToken,1);
    ELSE
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Failed to store device token.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE storeDeviceToken;
    END IF;

    SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Device token stored successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    LEAVE storeDeviceToken;
END$$
DELIMITER ;