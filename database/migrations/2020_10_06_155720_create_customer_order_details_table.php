<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_order_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('customer_loyalty_id')->default(0)->unsigned()->index();
            $table->integer('order_id')->default(0)->unsigned()->index();
            $table->integer('products_id')->unsigned()->index();
            $table->integer('product_units_id')->unsigned()->index();
            $table->integer('item_quantity')->unsigned();
            $table->date('expiry_date')->nullable()->index()->comment = "The product will not be visible beyond this date.";
            $table->decimal('selling_price', 14, 4);
            $table->decimal('special_price', 14, 4)->nullable()->comment = "This is the discounted price";
            $table->date('special_price_start_date')->nullable()->index();
            $table->date('special_price_end_date')->nullable()->index();
            $table->string('reject_cancel_reason', 255)->index()->nullable();
            $table->tinyInteger('order_status')->default(1)->unsigned()->index()->comment = "1: Pending, 2: Ordered, 3: In Process, 4: Completed";
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->default(0)->unsigned();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('null ON UPDATE CURRENT_TIMESTAMP'))->nullable();
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
        Schema::dropIfExists('customer_order_details');
    }
}
