<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_actions', function(Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('action_id');
            $table->unsignedInteger('offer_id')->nullable();
            $table->integer('points');
            $table->integer('price')->nullable();
            $table->double('action_x')->nullable();
            $table->double('action_y')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('action_id')->references('id')->on('actions');
            $table->foreign('offer_id')->references('id')->on('offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_actions');
    }
}
