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
            $table->id('abonnement_id');
            $table->integer('customer_id')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamp('last_update');
            $table->string('token')->unique();
            $table->integer('abonnement_type_id')->unsigned();
            $table->foreign('abonnement_type_id')->references('id')->on('abonnement_types');
            $table->foreign('customer_id')->references('customer_id')->on('customers');

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
