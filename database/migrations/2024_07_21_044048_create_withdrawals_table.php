<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


return new class extends Migration
{

    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('player_id');
            $table->integer('amount');
            $table->integer('points');
            $table->string('currency')->default('IDR');
            $table->integer('status')->default(0);
            $table->string('payment_method');
            $table->string('payment_account');
            $table->longText('payment_message')->nullable();
            $table->string('player_pkg')->default("com.kuis.ovo");
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
