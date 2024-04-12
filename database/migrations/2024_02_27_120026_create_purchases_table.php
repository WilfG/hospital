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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['product', 'material']); // Distinguish between product and material purchases
            $table->unsignedBigInteger('drug_id')->nullable();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->integer('quantity');
            $table->decimal('cost', 8, 2);
            $table->date('purchase_date');
            
            $table->foreign('drug_id')->references('id')->on('drugs')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
