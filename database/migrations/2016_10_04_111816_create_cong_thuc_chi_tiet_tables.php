<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongThucChiTietTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cong_thuc_chi_tiet', function (Blueprint $table) {
            $table->increments('ctct_id');
            $table->integer('ctct_spt_id')->nullable;
            $table->float('ctct_quantity')->nullable;
            $table->integer('ctct_ctm_id')->nullable;
            $table->integer('ctct_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cong_thuc_chi_tiet');
    }
}
