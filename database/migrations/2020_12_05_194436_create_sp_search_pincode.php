<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpSearchPincode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS searchPincode; 
        CREATE PROCEDURE `searchPincode`(IN pinCode VARCHAR(100))
        searchPincode:BEGIN 
            IF pinCode IS NULL OR pinCode = '' THEN 
                SELECT
                id,
                    pin_code AS pc
                FROM
                    pin_codes
                WHERE
                    status = 1 
                ORDER BY id;
            ELSE 
                SELECT
                id,
                    pin_code AS pc
                FROM
                    pin_codes
                WHERE
                    status = 1 
                AND
                    pin_code LIKE CONCAT(pinCode, '%')
                ORDER BY id;
            END IF;

    END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS searchPincode');
    }
}
