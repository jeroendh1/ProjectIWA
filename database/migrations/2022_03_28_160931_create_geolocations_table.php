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
        Schema::create('geolocations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('station_id');
            $table->string('country_code')->unsigned();
            $table->string('island')->nullable();
            $table->string('county')->nullable();
            $table->string('place')->nullable();
            $table->string('hamlet')->nullable();
            $table->string('town')->nullable();
            $table->string('municipality')->nullable();
            $table->string('state_district')->nullable();
            $table->string('administrative')->nullable();
            $table->string('state')->nullable();
            $table->string('village')->nullable();
            $table->string('region')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('locality')->nullable();
            $table->string('postcode')->nullable();
            $table->string('country')->nullable();
            $table->foreign('station_id')->references('station_id')->on('stations');
            $table->foreign('country_code')->references('country_code')->on('countries');
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
        Schema::dropIfExists('geolocations');
    }
};
