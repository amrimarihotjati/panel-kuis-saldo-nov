<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('category_quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category_name');
            $table->string('category_caption');
            $table->longText('category_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_quizzes');
    }
};
