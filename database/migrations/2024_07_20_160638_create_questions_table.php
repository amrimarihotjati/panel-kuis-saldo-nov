<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('question');
            $table->string('true_answer');
            $table->string('false_answer1');
            $table->string('false_answer2');
            $table->string('false_answer3');
            $table->integer('level')->default(1);
            $table->integer('points')->default(2);
            $table->string('category_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
