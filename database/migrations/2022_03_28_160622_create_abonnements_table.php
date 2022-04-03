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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->integer('user_id')->primary();
            $table->integer('abonnement_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('active');
            $table->timestamp('last_update');
            $table->string('api_key');
            $table->foreign('abonnement_id')->references('abonnement_id')->on('abonnement_types');

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
        Schema::dropIfExists('abonnements');
    }
};
