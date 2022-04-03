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
        Schema::create('gecorrigeerde_data', function (Blueprint $table) {
            $table->integer('originele_data_id')->unsigned();
            $table->integer('gecorrigeerde_data_id')->unsigned();
            $table->foreign('originele_data_id')->references('data_id')->on('weather_data');
            $table->foreign('gecorrigeerde_data_id')->references('data_id')->on('weather_data');
            
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
        Schema::dropIfExists('gecorrigeerde_data');
    }
};
