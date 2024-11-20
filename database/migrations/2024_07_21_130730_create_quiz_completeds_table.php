<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('quiz_completeds', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('player_id');
            $table->string('category_id');
            $table->integer('category_level');
            $table->integer('is_use_completed')->default(1);
            $table->string('player_pkg');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('quiz_completeds');
    }
};
