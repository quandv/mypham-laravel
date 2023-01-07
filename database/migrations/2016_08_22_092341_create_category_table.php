<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function($table)
        {
            $table->increments('category_id');
            $table->string('category_name', 50);
            $table->string('category_image')->nullable();
            $table->string('category_image_hover')->nullable();
            $table->text('category_desc')->nullable();
            $table->integer('category_id_parent')->default(0);
            $table->integer('category_status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category');
    }
}
