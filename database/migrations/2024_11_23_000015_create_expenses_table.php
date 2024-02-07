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
            $table->float('amount');
            $table->string('reason', 100);
            $table->string('note')->nullable();
            $table->date('expense_date');
            $table->index("expenses_category_id");
            $table->index("user_id");

            $table->foreignId('expenses_category_id')
                ->references('id')->on('expenses_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreignId('user_id')
            ->references('id')->on('users')
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
