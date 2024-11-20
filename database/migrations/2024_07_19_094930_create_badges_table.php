<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('badge_name');
            $table->longText('badge_icon');
            $table->integer('badge_price')->nullable()->default(0);
            $table->integer('badge_usage')->nullable()->default(0);
            $table->integer('badge_level')->unique()->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
