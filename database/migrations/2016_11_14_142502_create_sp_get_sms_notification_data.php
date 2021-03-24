<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpGetSmsNotificationData extends Migration {
 /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::unprepared("DROP PROCEDURE IF EXISTS getSmsNotificationData;
                        CREATE PROCEDURE getSmsNotificationData(IN conferenceId INT)
                        BEGIN
                            IF conferenceId = 0 THEN
                                SELECT distinct mobile_no FROM participants WHERE status = 1  ORDER BY id DESC;
                            ELSE
                                SELECT distinct mobile_no FROM participants WHERE status = 1 ORDER BY id DESC;
                            END IF;
                        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::unprepared('DROP PROCEDURE IF EXISTS getSmsNotificationData;');
    }


}
