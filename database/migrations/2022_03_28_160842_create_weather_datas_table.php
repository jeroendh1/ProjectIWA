<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weatherdata', function (Blueprint $table) {
            $table->increments('data_id');
            $table->string('STN')->nullable();
            $table->date('DATE')->nullable();
            $table->time('TIME')->nullable();
            $table->float('TEMP')->nullable();
            $table->float('DEWP')->nullable();
            $table->float('STP')->nullable();
            $table->float('SLP')->nullable();
            $table->float('VISIB')->nullable();
            $table->float('WDSP')->nullable();
            $table->float('PRCP')->nullable();
            $table->float('SNDP')->nullable();
            $table->string('FRSHTT')->nullable();
            $table->float('CLDC')->nullable();
            $table->Integer('WNDDIR')->nullable();
            $table->Integer('original_data_id')->nullable();
//            $table->foreign('STN')->references('station_id')->on('stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('weather_data');
    }
};
