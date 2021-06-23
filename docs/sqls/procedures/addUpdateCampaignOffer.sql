DELIMITER $$
DROP PROCEDURE IF EXISTS addUpdateCampaignOffer$$
CREATE PROCEDURE addUpdateCampaignOffer(IN inputData JSON)
addUpdateCampaignOffer:BEGIN
    DECLARE campaignCategoryId,campaignMasterId,codeType,rewardTypeXValue,codeLength,isForInsert,lastInsertedId INTEGER(10) DEFAULT 0;
    DECLARE rewardType,campaignUse,campaignUseValue INTEGER(10) DEFAULT 1;
    DECLARE title,campaignStartDate,campaignEndDate VARCHAR(255) DEFAULT '';
    DECLARE codePrefix,codeSuffix VARCHAR(5) DEFAULT '';
    DECLARE campaignDescription,platforms VARCHAR(255) DEFAULT '';
    DECLARE ipStatus,targetCustomer TINYINT(3) DEFAULT 1;
    DECLARE targetCustomerValue JSON ;
    DECLARE targetCustomerValueStr TEXT DEFAULT '';

    IF inputData IS NOT NULL AND JSON_VALID(inputData) = 0 THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE addUpdateCampaignOffer;
    END IF;
    SET campaignCategoryId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.campaign_category_id'));
    SET campaignMasterId = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.campaign_master_id'));
    SET title = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.title'));
    SET campaignDescription = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.description'));
    SET codeType = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.code_type'));
    SET rewardTypeXValue = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.reward_value'));
    SET campaignStartDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.start_date'));
    SET campaignEndDate = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.end_date'));
    SET codePrefix = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.code_prefix'));
    SET codeSuffix = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.code_suffix'));
    SET codeLength = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.code_length'));
    SET ipStatus = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.status'));
    SET targetCustomer = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.target_customer'));
    SET targetCustomerValue = JSON_UNQUOTE(JSON_EXTRACT(inputData,'$.target_customer_value'));

    SET targetCustomerValueStr = implode(JSON_OBJECT(
        'paramObjectArr',(JSON_EXTRACT(targetCustomerValue,'$'))
    ));

    SET platforms = "1,2";
    SET rewardType = 3;
    SET campaignUse = 2;
    IF campaignCategoryId = 0 OR campaignCategoryId IS NULL OR campaignMasterId = 0 OR campaignMasterId IS NULL OR title IS NULL OR title = '' THEN
        SELECT JSON_OBJECT('status', 'FAILURE', 'message', 'Please provide valid data.','data',JSON_OBJECT(),'statusCode',520) AS response;
        LEAVE addUpdateCampaignOffer;
    END IF;
    START TRANSACTION;

    IF NOT EXISTS(SELECT id FROM promo_code_master WHERE promo_code_master.title = title AND deleted_at IS NULL) THEN
        INSERT INTO promo_code_master (`campaign_category_id`,`campaign_master_id`,`title`,`description`,`start_date`,`end_date`,`platforms`,`target_customer`,`target_customer_value`,`reward_type`,`reward_type_x_value`,`campaign_use`,`campaign_use_value`,`code_type`,`status`,`created_by`) VALUES
            (campaignCategoryId,campaignMasterId,title,campaignDescription,campaignStartDate,campaignEndDate,platforms,targetCustomer,targetCustomerValueStr,rewardType,rewardTypeXValue,campaignUse,campaignUseValue,codeType,ipStatus,1);
        
            IF LAST_INSERT_ID() = 0 THEN
                ROLLBACK;
                SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'There is problem to add campaign offers.','data',JSON_OBJECT(),'statusCode',500) AS response;
                LEAVE addUpdateCampaignOfferOut;
            
            ELSE
                SET lastInsertedId = LAST_INSERT_ID();
                SET isForInsert = 1;
                IF codeType = 1 THEN
                    INSERT INTO promo_code_format_master () VALUES
                        ();
                END IF;

            END IF;
    ELSE
        SET isForInsert = 0;
        SELECT 'ABC';
    END IF;

    IF isForInsert = 1 THEN
        SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Campaign/Offer created successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    ELSE
        SELECT JSON_OBJECT('status', 'SUCCESS', 'message', 'Campaign/Offer updated successfully.','data',JSON_OBJECT(),'statusCode',200) AS response;
    END IF;
    LEAVE addUpdateCampaignOffer;
END$$
DELIMITER ;