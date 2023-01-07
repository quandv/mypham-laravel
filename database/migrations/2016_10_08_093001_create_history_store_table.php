<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('history_store_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('history_store', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned(); 
            $table->string('email');
            $table->string('name');
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->text('text');
            $table->text('content');
            $table->string('assets')->nullable();
            $table->timestamps();
            $table->foreign('type_id')
                ->references('id')
                ->on('history_store_types')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on(config('access.users_table'))
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('history_store', function (Blueprint $table) {
            $table->dropForeign('history_store_type_id_foreign');
            $table->dropForeign('history_store_user_id_foreign');
        });

        Schema::drop('history_store_types');
        Schema::drop('history_store');
    }
}
