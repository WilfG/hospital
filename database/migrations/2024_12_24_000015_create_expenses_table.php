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
    public $tableName = 'expenses';

    /**
     * Run the migrations.
     * @table expenses
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->string('justificatif')->nullable();
            $table->index("expenses_category_id");
            $table->index("request_id");
           
            $table->foreignId('expenses_category_id')
                ->references('id')->on('expenses_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('request_id')
                ->references('id')->on('expense_requests')
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
