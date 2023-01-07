<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhaSanXuatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nha_san_xuat', function (Blueprint $table) {
            $table->increments('nsx_id');
            $table->string('nsx_name', 255)->nullable();
            $table->text('nsx_address')->nullable();
            $table->string('nsx_phone',255)->nullable();
            $table->string('nsx_email',255)->nullable();
            $table->dateTime('nsx_create_time')->nullable();
            $table->integer('nsx_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nha_san_xuat');
    }
}
