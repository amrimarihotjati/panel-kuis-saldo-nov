<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('avatars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('avatar_name');
            $table->longText('avatar_icon');
            $table->integer('avatar_price')->nullable()->default(0);
            $table->integer('avatar_usage')->nullable()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
