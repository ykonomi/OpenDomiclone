<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrashsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trashes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('card_id');
            $table->string('name_jp', 100);
            $table->integer('coin_cost');
            $table->string('card_type', 100);
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
        Schema::dropIfExists('trashes');
    }
}
