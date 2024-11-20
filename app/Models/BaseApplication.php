<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseApplication extends Model
{
   use HasFactory, SoftDeletes;

   protected $fillable = [
    'app_pkg',
    'app_code',
    'app_access_key',
    'app_is_maintanance',
    'app_msg_maintanance',
    'app_pkg_secondary',
    'app_secondary_code',
    'app_secondary_access_key',
    'app_is_redirect',
    'app_url_redirect',
    'app_ext_pkg_allow_access',
    'app_ext_pkg_name',
    'app_ext_pkg_access_key',
    // EXTERNAL LIMIT
    'settings_menu_limit_time_claim_external',
    'settings_menu_limit_count_claim_external',
    'dana_kaget',
    'category_quiz',
    'banner',
    'rewards_ad_points',
    'badge',
    'app_title_info',
    'app_msg_info',
    'app_url_info',
    'settings_validation_device_api',
    'settings_currency',
    'settings_min_to_withdraw',
    'settings_conversion_rate',
    'settings_question_time',
    'settings_referral_register_points',
    'settings_completed_option',
    'settings_fifty_fifty',
    'settings_video_reward',
    'settings_email_verification_option',
    'settings_with_double_option_value',
    'settings_commission_withdraw_player_value',
    'settings_checking_emulator',
    'settings_difference_ms_quiz',
    'settings_menu_dana_kaget',
    'settings_menu_badge_player',
    'settings_menu_rewards_point',
    // WD SETTING
    'settings_menu_wd_pending',
    'settings_menu_message_wd_pending',
    'settings_minimum_ad_withdraw',
    // ADS MODULE
    'settings_module_ads_first',
    'settings_module_ads_secondary',
    'settings_module_ads_third',
    // VUNGLE
    'vungle_app_id_or_sdk_key',
    'vungle_placement_banner',
    'vungle_placement_native',
    'vungle_placement_interstitial',
    'vungle_placement_rewards',
    // APPLOVINMAX
    'applovinmax_app_id_or_sdk_key',
    'applovinmax_placement_banner',
    'applovinmax_placement_native',
    'applovinmax_placement_interstitial',
    'applovinmax_placement_rewards',
    // APPLOVINMAX WITH SETTINGS
    'applovinmax_placement_banner_no_ecpm',
    'applovinmax_placement_native_no_ecpm',
    'applovinmax_placement_interstitial_no_ecpm',
    'applovinmax_placement_rewards_no_ecpm',
    // APPLOVIN NEW CONFIG
    'applovinmax_placement_new_banner_1',
    'applovinmax_placement_new_banner_2',
    'applovinmax_placement_new_banner_3',
    'applovinmax_placement_new_banner_4',
    'applovinmax_placement_new_banner_5',

    'applovinmax_placement_new_native_1',
    'applovinmax_placement_new_native_2',
    'applovinmax_placement_new_native_3',
    'applovinmax_placement_new_native_4',
    'applovinmax_placement_new_native_5',

    'applovinmax_placement_new_interstitial_1',
    'applovinmax_placement_new_interstitial_2',
    'applovinmax_placement_new_interstitial_3',
    'applovinmax_placement_new_interstitial_4',
    'applovinmax_placement_new_interstitial_5',

    'applovinmax_placement_new_rewards_1',
    'applovinmax_placement_new_rewards_2',
    'applovinmax_placement_new_rewards_3',
    'applovinmax_placement_new_rewards_4',
    'applovinmax_placement_new_rewards_5',
    // YANDEX
    'yandex_app_id_or_sdk_key',
    'yandex_placement_banner',
    'yandex_placement_native',
    'yandex_placement_interstitial',
    'yandex_placement_rewards',
    // config enabled date completed
    'settings_date_all_completed'
];


protected static function boot() {
    parent::boot();
    static::creating(function ($model) {
        if (!$model->getKey()) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        }
    });
}

public function getIncrementing()
{
    return false;
}

public function getKeyType()
{
    return 'string';
}

public function count()
{
    return count($this->items);
}

protected $hidden = [
    'dana_kaget',
    'category_quiz',
    'banner',
    'rewards_ad_points',
    'badge'
];

protected $casts = [
    'dana_kaget' => 'json',
    'category_quiz' => 'json',
    'banner' => 'json',
    'rewards_ad_points' => 'json',
    'badge' => 'json'
];

public function getCreatedAtAttribute($date) {
    $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
    $elapsed = $date->diffForHumans();
    return $elapsed;
}

public function getUpdatedAtAttribute($date) {
    $date = \Carbon\Carbon::parse($date)->timezone('Asia/Jakarta');
    $elapsed = $date->diffForHumans();
    return $elapsed;
}
}
