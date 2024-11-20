<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name')->nullable(false);
            $table->string('email');
            $table->longText('image_url')->nullable();
            $table->integer('points')->default(0);
            $table->integer('points_collected')->default(0);
            $table->integer('score')->default(0);
            $table->string('referral_code')->default("XXXXXXXXXXXXXXXX");
            $table->string('password');
            $table->string('player_pkg')->default("com.kuis.ovo");
            $table->integer('status')->default(0);
            $table->integer('real_player')->default(1);
            $table->json('badge_player');
            $table->string('badge_primary')->default("93ced448-732b-4008-a17f-b8a89a294097");
            $table->longText('device_name')->nullable();
            $table->longText('device_id')->nullable();
            $table->longText('token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
