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
            $table->id();
            $table->string('station_name');
            $table->string('name');
            $table->string('administrative_region1');
            $table->string('administrative_region2');
            $table->string('country_code');
            $table->float('longitude', 4,4);
            $table->float('latitude', 4,4);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nearestlocations');
    }
};
