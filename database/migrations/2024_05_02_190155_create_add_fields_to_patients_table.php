<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('civility', 4)->nullable();
            $table->string('photo', 100)->nullable();
            $table->string('bloodgroup')->nullable();
            $table->integer('childnumber')->nullable();
            $table->text('address')->nullable();
            $table->text('postalcode')->nullable();
            $table->string('familydeseases')->nullable();
            $table->string('owndeseases')->nullable();
            $table->string('allergies')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_fields_to_patients');
    }
};
