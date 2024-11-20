<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('base_applications', function (Blueprint $table) {
            //app id
            $table->uuid('id')->primary();
            // utama
            $table->string("app_pkg")->unique();
            $table->integer("app_code")->default(1);
            $table->longText("app_access_key");
            $table->integer("app_is_maintanance")->default(0);
            $table->longText("app_msg_maintanance")->nullable();
            //redirect
            $table->string("app_pkg_secondary")->nullable();
            $table->integer("app_secondary_code")->nullable();
            $table->longText("app_secondary_access_key");
            $table->integer("app_is_redirect")->default(0);
            $table->string("app_url_redirect")->default("https://");
            //access
            $table->integer("app_ext_pkg_allow_access")->default(0);
            $table->string("app_ext_pkg_name")->nullable();
            $table->longText("app_ext_pkg_access_key")->nullable();
            //multiselect
            $table->json('dana_kaget')->nullable();
            $table->json('category_quiz')->nullable();
            $table->json('banner')->nullable();
            $table->json('rewards_ad_points')->nullable();
            $table->json('badge')->nullable();
            //info
            $table->longText('app_title_info')->nullable();
            $table->longText('app_msg_info')->nullable();
            $table->longText('app_url_info')->nullable();
            // enable validation device
            $table->integer('settings_validation_device_api')->default(1);
            // setting quiz
            $table->string("settings_currency")->default("Rp");
            $table->integer("settings_min_to_withdraw")->default(13000);
            $table->integer("settings_conversion_rate")->default(10000);
            $table->integer("settings_question_time")->default(10);
            $table->integer("settings_referral_register_points")->default(20);
            $table->integer("settings_completed_option")->default(1);
            $table->integer("settings_fifty_fifty")->default(1);
            $table->integer("settings_video_reward")->default(1);
            $table->integer("settings_email_verification_option")->default(0);
            $table->integer("settings_with_double_option_value")->default(5);
            $table->integer("settings_commission_withdraw_player_value")->default(10);
            // menu settings emulator & spam completed quiz
            $table->integer("settings_checking_emulator")->default(0);
            $table->integer("settings_difference_ms_quiz")->default(60);
            // menu setting
            $table->integer("settings_menu_dana_kaget")->default(1);
            $table->integer("settings_menu_badge_player")->default(1);
            $table->integer("settings_menu_rewards_point")->default(1);

            

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('base_applications');
    }
};
