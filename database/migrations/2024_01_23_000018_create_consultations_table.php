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
    public $tableName = 'consultations';

    /**
     * Run the migrations.
     * @table consultations
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_cons')->nullable();
            $table->string('motifs_cons', 45)->nullable();
            $table->string('diagnostic')->nullable();
            $table->float('price')->nullable();
            $table->text('ordonnance')->nullable();

            $table->index(["patient_id"]);


            $table->foreignId('patient_id')
                ->references('id')->on('patients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
