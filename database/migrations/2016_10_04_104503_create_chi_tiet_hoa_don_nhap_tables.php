<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChiTietHoaDonNhapTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chi_tiet_hoa_don_nhap', function (Blueprint $table) {
            $table->increments('hn_id');
            $table->string('hn_name', 255)->nullable();
            $table->float('hn_price')->nullable();
            $table->float('hn_quantyti')->nullable();
            $table->date('hn_create_time')->nullable();
            $table->date('hn_create_time')->nullable();
            $table->integer('hn_hdn_id')->nullable;
            $table->integer('hn_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chi_tiet_hoa_don_nhap');
    }
}
