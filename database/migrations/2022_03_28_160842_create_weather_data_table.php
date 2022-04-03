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
            $table->increments('data_id');
            $table->integer('station_id')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->float('temperatuur', 2,1)->nullable();
            $table->float('dauwpunt_temperatuur', 1,1)->nullable();
            $table->float('station_luchtdruk', 3,1)->nullable();
            $table->float('zeeniveau_luchtdruk', 4,1)->nullable();
            $table->float('zicht', 2,1)->nullable();
            $table->float('windsnelheid', 2,1)->nullable();
            $table->float('neerslag', 2,2)->nullable();
            $table->float('sneeuwdiepte', 1,1)->nullable();
            $table->string('vorst_regen_sneeuw_hagel_onweer_tornado')->nullable();
            $table->float('bewolking', 2,1)->nullable();
            $table->tinyInteger('windrichting')->nullable();
            $table->tinyInteger('gecorrigeerde_data');
            $table->foreign('station_id')->references('station_id')->on('stations');
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
