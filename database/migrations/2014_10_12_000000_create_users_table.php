<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            //手札IDと山札ID
            //$table->integer('deck_id')->unsigned();
            //$table->index('deck_id');
            //$table->integer('hand_id')->unsigned();
            //$table->index('hand_id');
            //他のプレイヤへの公開情報
            //
            $table->integer('coin')->default(0);
            $table->boolean('updated')->default(false);
            $table->boolean('is_turn')->default(false);
            $table->integer('deck_top')->nullable(); //山札の一番上
            $table->boolean('is_up')->default(false);           //山札が表かどうか
            $table->integer('hand_top')->nullable(); //手札の一番上
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

//手札と山札のテーブル。使わないことにしました。
//Schema::create('decks', function (Blueprint $table) {
//    $table->increments('id');
//    $table->string('session_id');
//    $table->integer('card_id');

//    $table->foreign('session_id')
//        ->references('id')
//        ->on('players')
//        ->onDelete('cascade');
//});
//Schema::create('hands', function (Blueprint $table) {
//    $table->increments('id');
//    $table->string('session_id');
//    $table->integer('card_id');

//    $table->foreign('session_id')
//        ->references('id')
//        ->on('players')
//        ->onDelete('cascade');
//});
