<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoaDonNhapTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoa_don_nhap', function (Blueprint $table) {
            $table->increments('hdn_id');
            $table->string('hdn_code', 255)->nullable();
            $table->dateTime('hdn_create_time')->nullable();
            $table->dateTime('hdn_update_time')->nullable();            
            $table->integer('hdn_id_employee')->nullable();
            $table->string('hdn_name_employee',255)->nullable();
            $table->integer('hdn_nxs_id')->nullable();
            $table->string('hdn_nxs_name',255)->nullable();
            $table->integer('hdn_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hoa_don_nhap');
    }
}
