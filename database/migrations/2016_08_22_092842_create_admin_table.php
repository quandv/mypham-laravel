<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function($table)
        {
            $table->increments('admin_id');
            $table->string('admin_name', 50);
            $table->integer('admin_cmt')->unique();
            $table->string('admin_image')->nullable();
            $table->tinyInteger('admin_level')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin');
    }
}
