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
        Schema::create('abonnement_stations', function (Blueprint $table) {        
            $table->string('station_id');
            $table->bigInteger('abonnement_id')->unsigned();
        
            $table->foreign('abonnement_id')->references('abonnement_id')->on('abonnements');
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
        Schema::dropIfExists('abonnement_stations');
    }
};
