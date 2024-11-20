<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('watch_list_players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('player_id')->unique();
            $table->json('reason')->nullable();
            $table->string('player_pkg')->default("com.kuis.ovo");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watch_list_players');
    }
};
