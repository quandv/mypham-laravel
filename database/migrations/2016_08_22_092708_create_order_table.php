<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function($table)
        {
            $table->increments('order_id');
            $table->string('order_name', 50)->nullable();
            $table->text('order_notice')->nullable();
            $table->time('order_create_time')->nullable();
            $table->integer('order_price')->default(0);
            $table->string('client_name', 50)->nullable();
            $table->string('client_ip', 50)->nullable();
            $table->string('room', 50)->nullable();
            $table->integer('room_id')->nullable();
            $table->text('message_destroy')->nullable();
            $table->tinyInteger('order_status')->default(1);
            $table->text('order_stock')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('order');
    }
}
