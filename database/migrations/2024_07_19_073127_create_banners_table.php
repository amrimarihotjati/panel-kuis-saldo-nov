<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('banner_title');
            $table->string('banner_image');
            $table->string('banner_url');
            $table->longText('banner_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

 
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
