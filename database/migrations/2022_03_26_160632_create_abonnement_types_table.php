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
        Schema::create('abonnement_types', function (Blueprint $table) {
<<<<<<< HEAD:database/migrations/2022_03_26_160632_create_abonnement_types_table.php
            $table->increments('id');
            $table->string('omschrijving');
=======
            $table->increments('abonnement_id');
            $table->string('naam');
>>>>>>> db:database/migrations/2022_03_28_160612_create_abonnement_types_table.php
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
        Schema::dropIfExists('abonnement_types');
    }
};
