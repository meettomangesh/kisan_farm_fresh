<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderStatusTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_order_status_track', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('order_details_id')->default(0)->unsigned()->index();
            $table->tinyInteger('order_status')->default(1)->unsigned()->index()->comment = "1: Pending, 2: Ordered, 3: In Process, 4: Completed";
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->default(0)->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_order_status_track');
    }
}
