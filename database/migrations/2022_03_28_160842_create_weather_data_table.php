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
            $table->string('station_id')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->float('temperatuur', 3,1)->nullable();
            $table->float('dauwpunt_temperatuur', 2,1)->nullable();
            $table->float('station_luchtdruk', 4,1)->nullable();
            $table->float('zeeniveau_luchtdruk', 5,1)->nullable();
            $table->float('zicht', 3,1)->nullable();
            $table->float('windsnelheid', 3,1)->nullable();
            $table->float('neerslag', 3,2)->nullable();
            $table->float('sneeuwdiepte', 2,1)->nullable();
            $table->string('vorst_regen_sneeuw_hagel_onweer_tornado')->nullable();
            $table->float('bewolking', 3,1)->nullable();
            $table->Integer('windrichting')->nullable();
            $table->Integer('gecorrigeerde_data_id')->nullable();
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
