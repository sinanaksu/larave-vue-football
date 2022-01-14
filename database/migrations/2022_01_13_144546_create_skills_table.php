<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id');
            $table->float('home',4,2);
            $table->float('away',4,2);
            $table->float('goalkeeper',4,2);
            $table->float('defense',4,2);
            $table->float('attack',4,2);
            $table->float('weather_clear',4,2);
            $table->float('weather_rain',4,2);
            $table->float('weather_snow',4,2);
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
        Schema::dropIfExists('skills');
    }
}
