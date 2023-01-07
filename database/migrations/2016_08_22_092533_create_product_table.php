<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function($table)
        {
            $table->increments('product_id');
            $table->string('product_name', 50);
            $table->string('product_image')->nullable();
            $table->text('product_desc')->nullable();
            $table->integer('product_price')->default(0);
            $table->integer('product_saleoff')->default(0);
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('category_id')->on('category');
            $table->integer('type')->default(0); // 0: thường || 1: mới || 2: hot(bán chạy) || 3: sale-off
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product');
    }
}
