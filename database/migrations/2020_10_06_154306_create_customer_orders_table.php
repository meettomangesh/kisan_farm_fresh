<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_orders', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('customer_id')->default(0)->unsigned()->index();
            $table->decimal('amount', 10, 4)->comment = "Total points redeemed against this order.";
            $table->decimal('discounted_amount', 14, 4)->nullable();
            $table->string('payment_id', 255)->index();
            $table->integer('total_items')->default(0)->unsigned()->index();
            $table->string('reject_cancel_reason', 255)->index()->nullable();
            $table->tinyInteger('purchased_from')->default(1)->unsigned()->index();
            $table->tinyInteger('is_coupon_applied')->default(1)->unsigned()->index()->comment = "1: Yes, 2:No";
            $table->string('coupon_applied', 20)->nullable();
            $table->tinyInteger('order_status')->default(1)->unsigned()->index()->comment = "1: Pending, 2: Ordered, 3: In Process, 4: Completed";
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->default(0)->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('null ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_orders');
    }
}
