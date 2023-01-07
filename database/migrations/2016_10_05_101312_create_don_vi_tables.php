<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonViTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('don_vi', function (Blueprint $table) {
            $table->increments('dv_id');
            $table->string('dv_name',255)->nullable;
            $table->integer('dv_parent_id')->nullable;
            $table->text('dv_desc')->nullable;
            $table->integer('dv_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('don_vi');
    }
}
