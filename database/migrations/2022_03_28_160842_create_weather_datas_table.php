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
        Schema::create('weather_data', function (Blueprint $table) {
            $table->string('stn_name');
            $table->date('date');
            $table->time('time');
            $table->float('temp', 2,1);
            $table->float('dewp', 1,1);
            $table->float('stp', 3,1);
            $table->float('slp', 4,1);
            $table->float('visib', 2,1);
            $table->float('wdsp', 2,1);
            $table->float('prcp', 2,2);
            $table->float('sndp', 1,1);
            $table->string('frshtt');
            $table->float('cldc', 2,1);
            $table->tinyInteger('wnddir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_datas');
    }
};
