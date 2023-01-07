<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('order_details', function($table)
        {
            $table->increments('order_details_id');
            $table->integer('order_id')->unsigned();
            $table->integer('product_id');
            $table->string('product_name',50)->nullable();
            $table->float('product_price')->nullable();
            $table->integer('product_quantity')->default(1);
            $table->text('product_option')->nullable();
            $table->foreign('order_id')->references('order_id')->on('order');
            $table->integer('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order_details');
                      
    }
}
