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
<<<<<<<< HEAD:database/migrations/2022_03_26_160632_create_abonnement_types_table.php
        Schema::create('abonnement_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('omschrijving');
========
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();;
            $table->timestamp('regDate');
            $table->string('city');
            $table->dateTime('last_login');
            $table->boolean('admin');
//            $table->integer('user_type_id')->unsigned();
//            $table->foreign('user_type_id')->references('id')->on('user_types');

>>>>>>>> main:database/migrations/2022_03_21_231531_create_users_table.php
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
