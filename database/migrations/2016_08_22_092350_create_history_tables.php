<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_types', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('history', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('email');
            $table->string('name');
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('icon')->nullable();
			$table->string('class')->nullable();
            $table->text('text');
            $table->string('assets')->nullable();
            $table->text('details_order_id');
            $table->float('time_process');
            $table->integer('qty_order')->unsigned();
            $table->tinyInteger('order_status');
            $table->timestamps();
			$table->foreign('type_id')
				->references('id')
				->on('history_types')
				->onDelete('cascade');

			$table->foreign('user_id')
				->references('id')
				->on(config('access.users_table'))
				->onDelete('cascade');
        });
        Schema::create('history_details', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('history_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->tinyInteger('order_status');
            $table->tinyInteger('room_id');
            $table->tinyInteger('status_changed');
            $table->integer('timestamp_process');
            $table->timestamps();
            $table->foreign('history_id')
                ->references('id')
                ->on('history')
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
		Schema::table('history', function (Blueprint $table) {
			$table->dropForeign('history_type_id_foreign');
			$table->dropForeign('history_user_id_foreign');
		});

        Schema::drop('history_types');
        Schema::drop('history');
    }
}
