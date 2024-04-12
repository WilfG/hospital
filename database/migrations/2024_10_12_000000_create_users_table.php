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
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
           $table->id();
            $table->string('firstname', 45);
            $table->string('lastname', 45);
            $table->string('middlename', 45)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 6)->nullable();
            $table->string('title', 6)->nullable();
            $table->string('email', 45);
            $table->string('phoneNumber', 15)->nullable();
            $table->string('password');
            $table->string('photo', 255)->nullable();
            $table->index('role_id')->nullable();
            $table->foreignId('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->boolean('prod')->nullable();
            $table->rememberToken();
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
