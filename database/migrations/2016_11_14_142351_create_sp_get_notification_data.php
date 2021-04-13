<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpGetNotificationData extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::unprepared("DROP PROCEDURE IF EXISTS getNotificationData;
                    CREATE PROCEDURE getNotificationData(IN notificationId INT)
                    BEGIN      
                        SELECT id, message_type, offer_id, push_text, deep_link_screen, sms_text, notify_users_by, 
                               email_tags, email_from_name, email_from_email, email_subject, email_body, message_send_time, status
                        FROM user_communication_messages 
                        WHERE IF(notificationId != 0, id = notificationId,DATE_FORMAT(message_send_time,'%y-%m-%d') = CURDATE()) AND processed = 0;        
                    END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP PROCEDURE IF EXISTS getNotificationData');
    }

}