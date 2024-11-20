<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('rewards_ad_points', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('title');
            $table->string('time_claimed')->default("10");
            
            $table->integer('status')->default(1);
            $table->integer('point_value')->default(5);
            $table->integer('point_number')->default(1);
            $table->json('claimed')->nullable();

            $table->integer('watch_ads_value')->default(5);
            $table->timestamps();
            $table->softDeletes();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('rewards_ad_points');
    }
};
