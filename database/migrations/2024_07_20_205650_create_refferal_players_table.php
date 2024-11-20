<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('refferal_players', function (Blueprint $table) {
            $table->id()->primary();
            $table->integer('refferaled_registered_player');
            $table->integer('refferaled_from_player');
            $table->integer('refferaled_coins_added_to_player');
            $table->string('player_pkg')->default("com.kuis.ovo");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('refferal_players');
    }
};
