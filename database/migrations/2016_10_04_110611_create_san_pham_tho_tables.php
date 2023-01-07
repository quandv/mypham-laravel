<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanPhamThoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('san_pham_tho', function (Blueprint $table) {
            $table->increments('spt_id');
            $table->string('spt_name', 255)->nullable();
            $table->text('spt_image')->nullable();
            $table->text('spt_desc')->nullable();
            $table->float('spt_quantity')->nullable;
            $table->integer('spt_category_id')->nullable;
            $table->integer('spt_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('san_pham_tho');
    }
}
