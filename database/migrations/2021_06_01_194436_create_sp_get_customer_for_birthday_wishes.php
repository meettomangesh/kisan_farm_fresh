<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpGetCustomerForBirthdayWishes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS getCustomerForBirthdayWishes;
        CREATE PROCEDURE getCustomerForBirthdayWishes()
        getCustomerForBirthdayWishes:BEGIN
            
            SELECT u.id, u.first_name, u.mobile_number, u.date_of_birth, ru.role_id
            FROM users AS u
            JOIN role_user AS ru ON ru.user_id = u.id
            WHERE ru.role_id = 4 AND MONTH(date_of_birth) = MONTH(CURDATE());
            -- AND DAY(date_of_birth) = DAY(CURDATE());
        
        END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS getCustomerForBirthdayWishes');
    }
}
