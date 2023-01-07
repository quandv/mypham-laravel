<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListoptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listoption', function($table)
        {
            $table->increments('id');
            $table->string('name', 50);
            $table->integer('price')->default(0);
            $table->integer('ctm_id');
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
        Schema::drop('listoption');
    }
}
