<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BaseApplication;

use App\Models\HistoryCollectedPoint;
use App\Models\HistoryQuiz;
use App\Models\Player;
use App\Models\QuizCompleted;
use App\Models\RefferalPlayer;
use App\Models\Withdrawal;
use App\Models\PaymentMethod;
use App\Models\Badge;

use App\Models\PanelSetting;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        // HistoryCollectedPoint::factory()->count(50)->create();
        // HistoryQuiz::factory()->count(50)->create();
        // Player::factory()->count(20)->create();
        // QuizCompleted::factory()->count(50)->create();
        // RefferalPlayer::factory()->count(50)->create();
        Withdrawal::factory()->count(1)->create();

        // $category_quiz = [];
        // $dana_kaget = [];
        // $banner = [];
        // $rewardsAdPoint = [];
        // $badge = [];

        // BaseApplication::create([
        //     'app_pkg' => "com.kuis.saldo",
        //     'app_access_key' => "7debc9f2-f7f8-4a52-80c7-45dc64f28d06",
        //     'app_secondary_access_key' => "aMJxA6oZ1KIQa19JiEkmQd4nsorM45KV0qtOuIe7v6sg6oiY4cW60xgjU3jgFB9SLP3nfKOpDl3hi3NZ68DHuSRx8FLfjMY0Ftyq",
        //     'app_ext_pkg_access_key' => "rvjKXV6x6nJolY43ZzCu3LY3YvBIcAuKTU4inOLAymTZLhL90c7gwDEX1duP1ovKj6h3fV6LIlb5ZJKgu8SxR6XlxJyMuhL34b1Y",
        //     'category_quiz' => $category_quiz,
        //     'dana_kaget' => $dana_kaget,
        //     'banner' => $banner,
        //     'rewards_ad_points' => $rewardsAdPoint,
        //     'badge' => $badge
        // ]);

        // BaseApplication::create([
        //     'app_pkg' => "com.kuis.ovo",
        //     'app_access_key' => "2debc9f2-f7f8-4a52-80c7-45dc64f28csd",
        //     'app_secondary_access_key' => "vMJxA6oZ1KIQa19JiEkmQd4nsorM45KV0qtOuIe7v6sg6oiY4cW60xgjU3jgFB9SLP3nfKOpDl3hi3NZ68DHuSRx8FLfjMY0Ftyq",
        //     'app_ext_pkg_access_key' => "rvjKXV6x6nJolY43ZzCu3LY3YvBIcAuKTU4inOLAymTZLhL90c7gwDEX1duP1ovKj6h3fV6LIlb5ZJKgu8SxR6XlxJyMuhL34b1Y",
        //     'category_quiz' => $category_quiz,
        //     'dana_kaget' => $dana_kaget,
        //     'banner' => $banner,
        //     'rewards_ad_points' => $rewardsAdPoint,
        //     'badge' => $badge
        // ]);

        // PanelSetting::create([
        //     'name' => 'Reset Harian CompletedQuiz',
        //     'description' => 'Reset otomatis data harian completed quiz',
        //     'key' => 'quiz_completed_reset',
        //     'status' => 0
        // ]);

        // PaymentMethod::create([
        //     'id' => '577f9647-ec22-435e-8c0a-6f11f5b93012',
        //     'method' => 'shoopepay',
        //     'method_image' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/payment_method/Shoopepay.png'
        // ]);

        // PaymentMethod::create([
        //     'id' => '62d3b0bc-a56e-4225-97df-91798724e2ec',
        //     'method' => 'Dana',
        //     'method_image' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/payment_method/Dana.png'
        // ]);

        // PaymentMethod::create([
        //     'id' => '90428716-d3ae-4e44-8faa-98215566108e',
        //     'method' => 'Ovo',
        //     'method_image' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/payment_method/Ovo.png'
        // ]);

        // PaymentMethod::create([
        //     'id' => 'dee2b2f5-8c25-4f40-a330-bf78c2ccb664',
        //     'method' => 'Gopay',
        //     'method_image' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/payment_method/Gopay.png'
        // ]);


        // Badge::create([
        //     'id' => '01ea3c95-4dae-4ed5-a73f-4610d2f166ca',
        //     'badge_name' => 'Master Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/3Fk1svaVjUf85DXjNC2iOaAwuNjjTP.png',
        //     'badge_price' => 117000,
        //     'badge_usage' => 0,
        //     'badge_level' => 6,
        //     'created_at' => '2024-07-28 07:09:25',
        //     'updated_at' => '2024-07-28 07:09:25',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => '8125f6f0-6126-491c-abd3-f2ccb0a894e1',
        //     'badge_name' => 'Raja Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/vAOl0QzekNDsIWzqWPfk6M29sqcjfw.png',
        //     'badge_price' => 130000,
        //     'badge_usage' => 0,
        //     'badge_level' => 7,
        //     'created_at' => '2024-07-28 07:10:22',
        //     'updated_at' => '2024-07-28 07:10:22',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => '8630dff6-9aa7-4e6a-ba4a-dce26b48dcc5',
        //     'badge_name' => 'Ahli Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/qS2DMxSMJNevfcTBhyGDejN24U7UK9.png',
        //     'badge_price' => 104000,
        //     'badge_usage' => 0,
        //     'badge_level' => 5,
        //     'created_at' => '2024-07-28 07:08:39',
        //     'updated_at' => '2024-07-28 07:08:39',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => '8cc4d19c-400b-49cd-bf81-f9897f8f3023',
        //     'badge_name' => 'Penggila Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/OG2h4yrUmvq6MA8FRDV6zaXJg7AAaG.png',
        //     'badge_price' => 78000,
        //     'badge_usage' => 0,
        //     'badge_level' => 3,
        //     'created_at' => '2024-07-28 07:00:59',
        //     'updated_at' => '2024-07-28 07:00:59',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => '93ced448-732b-4008-a17f-b8a89a294097',
        //     'badge_name' => 'Pemula Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/9vqwrsMYx5y8AgHBu0HOGIMFWRRHZu.png',
        //     'badge_price' => 0,
        //     'badge_usage' => 0,
        //     'badge_level' => 1,
        //     'created_at' => '2024-07-21 02:23:53',
        //     'updated_at' => '2024-07-28 06:59:39',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => 'a2935c29-00d2-43c7-94dd-6714bea1bd36',
        //     'badge_name' => 'Pecinta Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/hKI9iYqkNlDKmfTVYVV6LA8BOUuVEu.png',
        //     'badge_price' => 65000,
        //     'badge_usage' => 0,
        //     'badge_level' => 2,
        //     'created_at' => '2024-07-28 06:57:12',
        //     'updated_at' => '2024-07-28 07:00:00',
        //     'deleted_at' => null,
        // ]);

        // Badge::create([
        //     'id' => 'df26b1c3-1286-461a-aaa9-8ed57d215a76',
        //     'badge_name' => 'Maniak Kuis',
        //     'badge_icon' => 'https://kuissaldo.amrimarihotjati.my.id/uploads/player_badge/b5e7ZUuN3s1r16gQ2bM8omasZlsde3.png',
        //     'badge_price' => 91000,
        //     'badge_usage' => 0,
        //     'badge_level' => 4,
        //     'created_at' => '2024-07-28 07:01:50',
        //     'updated_at' => '2024-07-28 07:02:11',
        //     'deleted_at' => null,
        // ]);

        // User::factory()->create([
        //     'name' => 'SuperAdmin',
        //     'email' => 'baseadmin@mail.com',
        //     'password' => 'admin123A',
        // ]);
        
    }
}
