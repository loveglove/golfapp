<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('matchups', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('id_tour');
            $table->integer('id_team1');
            $table->integer('id_team2');
            $table->integer('active');
            $table->timestamps();        
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matchups');
    }
}
