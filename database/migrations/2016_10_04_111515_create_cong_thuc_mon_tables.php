<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCongThucMonTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cong_thuc_mon', function (Blueprint $table) {
            $table->increments('ctm_id');
            $table->string('ctm_name', 255)->nullable();
            $table->json('ctm_details')->nullable();
            $table->json('ctm_details_name')->nullable();
            $table->text('ctm_desc')->nullable();
            $table->integer('ctm_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cong_thuc_mon');
    }
}
