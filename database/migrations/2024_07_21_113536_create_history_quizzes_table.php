<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('history_quizzes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('player_id');
            $table->integer('score');
            $table->integer('points');
            $table->integer('ads_watched_inters')->default(0);
            $table->integer('ads_watched_rewards')->default(0);
            $table->string('category_id');
            $table->integer('category_level');
            $table->integer('total_quiz_points');
            $table->integer('completed_option')->default(1);
            $table->integer('with_double_option')->default(0);
            $table->string('description')->nullable();
            $table->string('player_pkg')->default("com.kuis.ovo");
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('history_quizzes');
    }
};
