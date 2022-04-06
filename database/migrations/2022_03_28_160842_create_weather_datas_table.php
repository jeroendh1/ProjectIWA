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
        Schema::create('weatherData', function (Blueprint $table) {
            $table->id("data_id");
            $table->string('STN')->index();
            $table->date('DATE');
            $table->time('TIME');
            $table->float('TEMP', 2,1);
            $table->float('DEWP', 1,1);
            $table->float('STP', 3,1);
            $table->float('SLP', 4,1);
            $table->float('VISIB', 2,1);
            $table->float('WDSP', 2,1);
            $table->float('PRCP', 2,2);
            $table->float('SNDP', 1,1);
            $table->string('FRSHTT');
            $table->float('CLDC', 2,1);
            $table->tinyInteger('WNDDIR');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weatherData');
    }
};
