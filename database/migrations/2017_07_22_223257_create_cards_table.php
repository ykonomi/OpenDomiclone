<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_jp', 100);
            $table->string('name_en', 100);
            $table->string('card_set', 100);
            $table->integer('coin_cost');
            $table->integer('coin_potion');
            $table->integer('coin_debt');
            $table->string('class', 10);
            $table->string('card_type', 100);
            $table->integer('coin');
            $table->integer('point');
            $table->integer('plus_card');
            $table->integer('plus_action');
            $table->integer('plus_buy');
            $table->integer('plus_coin');
            $table->integer('plus_point');
            $table->string('description', 200);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
