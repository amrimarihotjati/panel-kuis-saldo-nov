<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('history_collected_rewards_ad_points', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('player_id');
            $table->string('rewardsadpoint_id');
            $table->string('player_pkg');
            $table->timestamps();
            $table->softDeletes();
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('history_collected_rewards_ad_points');
    }
};
