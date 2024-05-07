<?php

namespace Database\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'patients';

    /**
     * Run the migrations.
     * @table patients
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('firstname', 45)->nullable();
            $table->string('lastname', 45)->nullable();
            $table->string('middlename', 45)->nullable();
            $table->string('gender', 6)->nullable();
            $table->integer('city')->nullable();
            $table->integer('country')->nullable();
            $table->integer('region')->nullable();
            $table->string('occupation', 45)->nullable();
            $table->string('birthdate', 45)->nullable();
            $table->string('phoneNumber', 45)->nullable();
            $table->string('maritalStatus', 45)->nullable();
            $table->string('height', 3)->nullable();
            $table->string('weight', 3)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
};
