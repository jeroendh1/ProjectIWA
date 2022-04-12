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
        Schema::create('nearestlocations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('station_id');
            $table->string('name')->nullable();
            $table->string('administrative_region1')->nullable();
            $table->string('administrative_region2')->nullable();
            $table->string('country_code');
            $table->float('longitude');
            $table->float('latitude');
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
        Schema::dropIfExists('nearestlocations');
    }
};
