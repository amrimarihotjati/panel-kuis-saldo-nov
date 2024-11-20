<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

use Dedoc\Scramble\Scramble;

// player reset password
Route::get('/reset-password/{token}', [App\Http\Controllers\PlayerResetPasswordController::class, 'showResetForm']);
Route::post('/reset-password', [App\Http\Controllers\PlayerResetPasswordController::class, 'resetPassword']);

// general
Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    // SCRAMBLE
    // Scramble::registerUiRoute(path: 'tools/api/v2', api: 'v2');

    // home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/base-application', [App\Http\Controllers\HomeController::class, 'goBaseApplication'])->name('goBaseApplication');
    Route::get('/banner', [App\Http\Controllers\HomeController::class, 'goBanner'])->name('goBanner');
    Route::get('/avatar', [App\Http\Controllers\HomeController::class, 'goAvatar'])->name('goAvatar');
    Route::get('/badge', [App\Http\Controllers\HomeController::class, 'goBadge'])->name('goBadge');
    Route::get('/category-quiz', [App\Http\Controllers\HomeController::class, 'goCategoryQuiz'])->name('goCategoryQuiz');
    Route::get('/rewards-ad-points', [App\Http\Controllers\HomeController::class, 'goRewardsAdPoints'])->name('goRewardsAdPoints');
    Route::get('/dana-kaget', [App\Http\Controllers\HomeController::class, 'goDanaKaget'])->name('goDanaKaget');
    Route::get('/payment-method', [App\Http\Controllers\HomeController::class, 'goPaymentMethod'])->name('goPaymentMethod');
    // home ANALYTICS
    Route::get('/analytics/collected-points', [App\Http\Controllers\HomeController::class, 'goAnalyticsCollectedPoint'])->name('goAnalyticsCollectedPoint');
    Route::get('/analytics-data/collected-points/{app_pkg}/{startDate}/{endDate}', [App\Http\Controllers\HistoryCollectedPointController::class, 'getDTCollectedPointRange'])->name('loadAnalyticsCollectedPoints');

    Route::get('/analytics/history-quiz', [App\Http\Controllers\HomeController::class, 'goAnalyticsHistoryQuiz'])->name('goAnalyticsHistoryQuiz');
    Route::get('/analytics-data/history-quiz/{app_pkg}/{startDate}/{endDate}', [App\Http\Controllers\HistoryQuizController::class, 'getDTHistoryQuizRange'])->name('loadAnalyticsHistoryQuiz');

    Route::get('/analytics/withdrawals', [App\Http\Controllers\HomeController::class, 'goAnalyticsWithdrawals'])->name('goAnalyticsWithdrawals');
    Route::get('/analytics-data/withdrawals/{app_pkg}/{startDate}/{endDate}', [App\Http\Controllers\WithdrawalController::class, 'getDTWithdrawalRange'])->name('getDTWithdrawalRange');

    Route::get('/analytics/player-activity', [App\Http\Controllers\HomeController::class, 'goAnalyticsPlayerActivity'])->name('goAnalyticsPlayerActivity');
    Route::get('/analytics-data/player-activity/{app_pkg}/{startDate}/{endDate}', [App\Http\Controllers\HistoryQuizController::class, 'getDTHistoryQuizRangeActivity'])->name('getDTHistoryQuizRangeActivity');

    // BASEAPPLICATION
    Route::post('/create-base-application', [App\Http\Controllers\BaseApplicationController::class, 'createBaseApplication'])->name('createBaseApplication');
    Route::get('/list-baseapplication', [App\Http\Controllers\BaseApplicationController::class, 'getDTBaseApplication'])->name('list-baseapplication');
    Route::get('/list-baseapplication-count', [App\Http\Controllers\BaseApplicationController::class, 'getCountBaseApplication'])->name('list-count-baseapplication');
    Route::get('/base-application-delete/{id}', [App\Http\Controllers\BaseApplicationController::class, 'deleteBaseApplication'])->name('deleteBaseApplication');
    // INNERVIEW BASE APPLICATION
    Route::get('/base-application/goEditData/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goEditData'])->name('goEditData');
    Route::get('/base-application/goEditConfigAd/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goEditConfigAd'])->name('goEditConfigAd');
    Route::get('/base-application/goCollectedPoint/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goCollectedPoint'])->name('goCollectedPoint');
    Route::get('/base-application/goCompletedQuiz/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goCompletedQuiz'])->name('goCompletedQuiz');
    Route::get('/base-application/goHistoryQuiz/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goHistoryQuiz'])->name('goHistoryQuiz');
    Route::get('/base-application/goHistoryRefferal/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goHistoryRefferal'])->name('goHistoryRefferal');
    Route::get('/base-application/goHistoryWithdraw/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goHistoryWithdraw'])->name('goHistoryWithdraw');
    Route::get('/base-application/goListPlayer/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goListPlayer'])->name('goListPlayer');
    Route::get('/base-application/goPantauPlayer/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goPantauPlayer'])->name('goPantauPlayer');
    Route::get('/base-application/goWatchListPlayer/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goWatchListPlayer'])->name('goWatchListPlayer');
    Route::get('/base-application/goHistoryExchangeBadgePlayer/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goHistoryExchangeBadgePlayer'])->name('goHistoryExchangeBadgePlayer');
    Route::get('/base-application/goHistoryCollectedRewardsAdPoint/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goHistoryCollectedRewardsAdPoint'])->name('goHistoryCollectedRewardsAdPoint');
    Route::get('/base-application/goCompletedArticlePoint/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goCompletedArticlePoint'])->name('goCompletedArticlePoint');
    Route::get('/base-application/goCompletedPointKaget/{id}', [App\Http\Controllers\BaseApplicationController::class, 'goCompletedPointKaget'])->name('goCompletedPointKaget');
    // SETTING BASE APPLICATION DATA
    Route::post('/BaseApplication-saveMainSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveMainSettings'])->name('saveMainSettings');
    Route::post('/BaseApplication-saveSecondarySettings', [App\Http\Controllers\BaseApplicationController::class, 'saveSecondarySettings'])->name('saveSecondarySettings');
    Route::post('/BaseApplication-saveExternalSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveExternalSettings'])->name('saveExternalSettings');
    Route::post('/BaseApplication-saveMaintananceSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveMaintananceSettings'])->name('saveMaintananceSettings');
    Route::post('/BaseApplication-saveAddDagetSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveAddDagetSettings'])->name('saveAddDagetSettings');
    Route::post('/BaseApplication-saveAddRewardsAdPointsSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveAddRewardsAdPointsSettings'])->name('saveAddRewardsAdPointsSettings');
    Route::post('/BaseApplication-saveAddCategoryQuizSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveAddCategoryQuizSettings'])->name('saveAddCategoryQuizSettings');
    Route::post('/BaseApplication-saveAddBannerSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveAddBannerSettings'])->name('saveAddBannerSettings');
    Route::post('/BaseApplication-saveAddBadgeSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveAddBadgeSettings'])->name('saveAddBadgeSettings');
    Route::post('/BaseApplication-saveMenuSettings', [App\Http\Controllers\BaseApplicationController::class, 'saveMenuSettings'])->name('saveMenuSettings');
    
    // CONFIGAD SAVE
    Route::post('/BaseApplication-saveConfigAdsFlow', [App\Http\Controllers\BaseApplicationController::class, 'saveConfigAdsFlow'])->name('saveConfigAdsFlow');
    Route::post('/BaseApplication-saveConfigAdsVungle', [App\Http\Controllers\BaseApplicationController::class, 'saveConfigAdsVungle'])->name('saveConfigAdsVungle');
    Route::post('/BaseApplication-saveConfigAdsApplovinmax', [App\Http\Controllers\BaseApplicationController::class, 'saveConfigAdsApplovinmax'])->name('saveConfigAdsApplovinmax');
    Route::post('/BaseApplication-saveConfigAdsNewApplovinmax', [App\Http\Controllers\BaseApplicationController::class, 'saveConfigAdsNewApplovinmax'])->name('saveConfigAdsNewApplovinmax');
    Route::post('/BaseApplication-saveConfigAdsYandex', [App\Http\Controllers\BaseApplicationController::class, 'saveConfigAdsYandex'])->name('saveConfigAdsYandex');

    // BANNER
    Route::post('/create-banner', [App\Http\Controllers\BannerController::class, 'createBanner'])->name('createBanner');
    Route::get('/list-banner', [App\Http\Controllers\BannerController::class, 'getDTBanner'])->name('list-banner');
    Route::get('/list-banner-count', [App\Http\Controllers\BannerController::class, 'getCountBanner'])->name('list-count-banner');
    Route::get('/detail-banner/{id}', [App\Http\Controllers\BannerController::class, 'detailBanner'])->name('detailBanner');
    Route::post('/edit-banner', [App\Http\Controllers\BannerController::class, 'editBanner'])->name('editBanner');
    Route::get('/banner-delete/{id}', [App\Http\Controllers\BannerController::class, 'deleteBanner'])->name('deleteBanner');

    // AVATAR
    Route::post('/create-avatar', [App\Http\Controllers\AvatarController::class, 'createAvatar'])->name('createAvatar');
    Route::get('/list-avatar', [App\Http\Controllers\AvatarController::class, 'getDTAvatar'])->name('list-avatar');
    Route::get('/list-avatar-count', [App\Http\Controllers\AvatarController::class, 'getCountAvatar'])->name('list-count-avatar');
    Route::get('/detail-avatar/{id}', [App\Http\Controllers\AvatarController::class, 'detailAvatar'])->name('detailAvatar');
    Route::post('/edit-avatar', [App\Http\Controllers\AvatarController::class, 'editAvatar'])->name('editAvatar');
    Route::get('/avatar-delete/{id}', [App\Http\Controllers\AvatarController::class, 'deleteAvatar'])->name('deleteAvatar');

    // BADGE
    Route::post('/create-badge', [App\Http\Controllers\BadgeController::class, 'createBadge'])->name('createBadge');
    Route::get('/list-badge', [App\Http\Controllers\BadgeController::class, 'getDTBadge'])->name('list-badge');
    Route::get('/list-badge-count', [App\Http\Controllers\BadgeController::class, 'getCountBadge'])->name('list-count-badge');
    Route::get('/detail-badge/{id}', [App\Http\Controllers\BadgeController::class, 'detailBadge'])->name('detailBadge');
    Route::post('/edit-badge', [App\Http\Controllers\BadgeController::class, 'editBadge'])->name('editBadge');
    Route::get('/badge-delete/{id}', [App\Http\Controllers\BadgeController::class, 'deleteBadge'])->name('deleteBadge');

    // CATEGORYQUIZ
    Route::post('/create-category-quiz', [App\Http\Controllers\CategoryQuizController::class, 'createCategoryQuiz'])->name('createCategoryQuiz');
    Route::get('/list-category-quiz', [App\Http\Controllers\CategoryQuizController::class, 'getDTCategoryQuiz'])->name('list-category-quiz');
    Route::get('/list-category-quiz-count', [App\Http\Controllers\CategoryQuizController::class, 'getCountCategoryQuiz'])->name('list-count-category-quiz');
    Route::get('/detail-category-quiz/{id}', [App\Http\Controllers\CategoryQuizController::class, 'detailCategoryQuiz'])->name('detailCategoryQuiz');
    Route::post('/edit-category-quiz', [App\Http\Controllers\CategoryQuizController::class, 'editCategoryQuiz'])->name('editCategoryQuiz');
    Route::get('/category-quiz-delete/{id}', [App\Http\Controllers\CategoryQuizController::class, 'deleteCategoryQuiz'])->name('deleteCategoryQuiz');

    // QUESTION
    Route::get('/list-question-from-category/{category_quiz_id}', [App\Http\Controllers\QuestionController::class, 'getDTQuestion'])->name('list-question-quiz');
    Route::post('/create-question', [App\Http\Controllers\QuestionController::class, 'createQuestion'])->name('createQuestion');
    Route::post('/import-question', 'App\Http\Controllers\QuestionFileImport@import')->name('import-question');
    Route::post('/delete-multiple-questions', [App\Http\Controllers\QuestionController::class, 'deleteMultiple'])->name('delete-multiple-questions');

    // DAGET
    Route::post('/create-daget', [App\Http\Controllers\DagetController::class, 'createDaget'])->name('createDaget');
    Route::get('/list-daget', [App\Http\Controllers\DagetController::class, 'getDTDaget'])->name('list-daget');
    Route::get('/list-daget-count', [App\Http\Controllers\DagetController::class, 'getCountDaget'])->name('list-count-daget');
    Route::get('/detail-daget/{id}', [App\Http\Controllers\DagetController::class, 'detailDaget'])->name('detailDaget');
    Route::post('/edit-daget', [App\Http\Controllers\DagetController::class, 'editDaget'])->name('editDaget');
    Route::get('/daget-delete/{id}', [App\Http\Controllers\DagetController::class, 'deleteDaget'])->name('deleteDaget');

    // REWARDSADPOINT
    Route::get('/list-rewardsadpoint', [App\Http\Controllers\RewardsAdPointsController::class, 'getDTRewardsAdPoints'])->name('list-rewardsadpoint');
    Route::get('/list-rewardsadpoint-count', [App\Http\Controllers\RewardsAdPointsController::class, 'getCountRewardsAdPoints'])->name('list-count-rewardsadpoint');
    Route::get('/detail-rewards-ad-points/{id}', [App\Http\Controllers\RewardsAdPointsController::class, 'detailRewardsAdPoints'])->name('detailRewardsAdPoints');
    Route::post('/create-rewardsadpoint', [App\Http\Controllers\RewardsAdPointsController::class, 'createRewardsAdPoints'])->name('createRewardsAdPoints');
    Route::post('/edit-rewardsadpoint', [App\Http\Controllers\RewardsAdPointsController::class, 'editRewardsAdPoints'])->name('editRewardsAdPoints');
    Route::get('/rewardsadpoint-delete/{id}', [App\Http\Controllers\RewardsAdPointsController::class, 'deleteRewardsAdPoints'])->name('deleteRewardsAdPoints');

    // PAYMENTMETHOD
    Route::post('/create-payment-method', [App\Http\Controllers\PaymentMethodController::class, 'createPaymentMethod'])->name('createPaymentMethod');
    Route::get('/list-payment-method', [App\Http\Controllers\PaymentMethodController::class, 'getDTPaymentMethod'])->name('list-payment-method');
    Route::get('/list-payment-method-count', [App\Http\Controllers\PaymentMethodController::class, 'getCountPaymentMethod'])->name('list-count-payment-method');
    Route::get('/delete-payment-method/{id}', [App\Http\Controllers\PaymentMethodController::class, 'deletePaymentMethod'])->name('deletePaymentMethod');

    // PLAYER
    Route::post('/create-new-player', [App\Http\Controllers\PlayerController::class, 'createPlayer'])->name('createPlayer');
    Route::get('/list-player/{app_pkg}', [App\Http\Controllers\PlayerController::class, 'getDTPlayer'])->name('list-player');
    Route::get('/list-pantau-player/{app_pkg}', [App\Http\Controllers\PlayerController::class, 'getDTPantauPlayer'])->name('list-pantau-player');
    Route::get('/list-player-count', [App\Http\Controllers\PlayerController::class, 'getCountPlayer'])->name('list-count-player');
    Route::get('/detail-player/{id}', [App\Http\Controllers\PlayerController::class, 'detailPlayer'])->name('detailPlayer');
    Route::post('/edit-player', [App\Http\Controllers\PlayerController::class, 'editPlayer'])->name('editPlayer');
    Route::post('/force-player-password', [App\Http\Controllers\PlayerController::class, 'forceEditPasswordPlayer'])->name('forceEditPasswordPlayer');
    Route::get('/delete-player/{id}', [App\Http\Controllers\PlayerController::class, 'deletePlayer'])->name('deletePlayer');
    Route::post('/gift-player-points', [App\Http\Controllers\PlayerController::class, 'giftPoint'])->name('giftPoint');
    Route::post('/gift-player-badge', [App\Http\Controllers\PlayerController::class, 'giftBadge'])->name('giftBadge');

    // PANTAU PLAYER PRIVATE
    Route::get('/pantau-player-collected-points/{player_id}', [App\Http\Controllers\PlayerController::class, 'goPantauPrivateCollectedPointPlayer'])->name('goPantauPrivateCollectedPointPlayer');
    Route::get('/dt-pantau-player-collected-points/{player_id}', [App\Http\Controllers\PlayerController::class, 'getDTPantauPrivateCollectedPointPlayer'])->name('getDTPantauPrivateCollectedPointPlayer');
    Route::get('/statistic-player/{player_id}', [App\Http\Controllers\PlayerController::class, 'getDataStatisticPlayer'])->name('getDataStatisticPlayer');
    Route::get('/pantau-history-quiz-player/{player_id}', [App\Http\Controllers\PlayerController::class, 'getDtPantauHistoryQuiz'])->name('getDtPantauHistoryQuiz');
    
    // WATCHED ADS
    Route::get('/dt-pantau-player-watched-ads/{player_id}', [App\Http\Controllers\AdsCounterTemporaryController::class, 'getDTAdsCounterTemporary'])->name('getDTAdsCounterTemporary');
    Route::get('/ads-statistic-player/{player_id}', [App\Http\Controllers\AdsCounterTemporaryController::class, 'getDataStatisticWatchedAds'])->name('getDataStatisticWatchedAds');
    Route::post('/resetAllDataTemporaryAds', [App\Http\Controllers\AdsCounterTemporaryController::class, 'resetAllDataTemporaryAds'])->name('resetAllDataTemporaryAds');
    Route::get('/getDataQuizCompletedStatistic/{player_id}', [App\Http\Controllers\PlayerController::class, 'getDataQuizCompletedStatistic'])->name('getDataQuizCompletedStatistic');
    
    Route::post('/resetAllCompletedQuizFromPlayer', [App\Http\Controllers\PlayerController::class, 'resetAllCompletedQuizFromPlayer'])->name('resetAllCompletedQuizFromPlayer');

    // REFFERAL PLAYER
    Route::get('/list-refferal-player/{app_pkg}', [App\Http\Controllers\RefferalPlayerController::class, 'getDTRefferalPlayer'])->name('list-refferal-player');
    Route::get('/list-refferal-player-count', [App\Http\Controllers\RefferalPlayerController::class, 'getCountRefferalPlayer'])->name('list-count-refferal-player');

    //WITHDRAWAL
    Route::get('/list-withdrawal-all-pkg-pending', [App\Http\Controllers\WithdrawalController::class, 'getDTWithdrawalAllPkg'])->name('list-withdrawal-all-pkg-pending');
    Route::get('/list-withdrawal/{app_pkg}', [App\Http\Controllers\WithdrawalController::class, 'getDTWithdrawal'])->name('list-withdrawal-player');
    Route::get('/list-withdrawal-count', [App\Http\Controllers\WithdrawalController::class, 'getCountWithdrawal'])->name('list-count-withdrawal-player');
    Route::post('/updateStatusWithdrawalRequest', [App\Http\Controllers\WithdrawalController::class, 'updateStatusWithdrawalRequest'])->name('updateStatusWithdrawalRequest');

    // HISTORY COLLECTED POINT
    Route::get('/list-history-collected-point/{app_pkg}', [App\Http\Controllers\HistoryCollectedPointController::class, 'getDTCollectedPoint'])->name('list-history-collected-point-player');
    Route::get('/list-history-collected-point-count', [App\Http\Controllers\HistoryCollectedPointController::class, 'getCountHistoryCollectedPoint'])->name('list-count-history-collected-point-player');

    // HISTORY QUIZ
    Route::get('/list-history-quiz/{app_pkg}', [App\Http\Controllers\HistoryQuizController::class, 'getDTHistoryQuiz'])->name('list-history-quiz-player');
    Route::get('/list-history-quiz-count', [App\Http\Controllers\HistoryQuizController::class, 'getCountHistoryQuiz'])->name('list-count-history-quiz-player');

    // QUIZ COMPLETED
    Route::get('/list-quiz-completed/{app_pkg}', [App\Http\Controllers\QuizCompletedController::class, 'getDTQuizCompleted'])->name('list-quiz-completed-player');
    Route::get('/list-quiz-completed-count', [App\Http\Controllers\QuizCompletedController::class, 'getCountQuizCompleted'])->name('list-count-quiz-completed-player');
    Route::post('/resetAllCompletedFromPackage', [App\Http\Controllers\QuizCompletedController::class, 'resetAllCompletedFromPackage'])->name('resetAllCompletedFromPackage');
    Route::get('/get-category-quiz/{app_pkg}', [App\Http\Controllers\QuizCompletedController::class, 'getDTCategoryQuiz'])->name('getDTCategoryQuiz');
    Route::get('/reset-completed-quiz-selected/{app_pkg}/{category_id}', [App\Http\Controllers\QuizCompletedController::class, 'resetSelectedCategoryCompletedQuizFromPackage'])->name('resetSelectedCategoryCompletedQuizFromPackage');
    
    // ARTICLE POINT COMPLETED
    Route::get('/list-article-point-completed/{app_pkg}', [App\Http\Controllers\CompletedArticlePointController::class, 'getDTCompletedArticlePoint'])->name('getDTCompletedArticlePoint');
    Route::get('/list-article-point-count', [App\Http\Controllers\CompletedArticlePointController::class, 'getCountCompletedArticlePoint'])->name('getCountCompletedArticlePoint');
    Route::post('/resetAllCompletedArticlePointFromPackage', [App\Http\Controllers\CompletedArticlePointController::class, 'resetAllCompletedArticlePointFromPackage'])->name('resetAllCompletedArticlePointFromPackage');

    // POINT KAGET COMPLETED
    Route::get('/list-point-kaget-completed/{app_pkg}', [App\Http\Controllers\CompletedPointKagetController::class, 'getDTCompletedPointKaget'])->name('getDTCompletedPointKaget');
    Route::get('/list-point-kaget-count', [App\Http\Controllers\CompletedPointKagetController::class, 'getCountCompletedPointKaget'])->name('getCountCompletedPointKaget');
    Route::post('/resetAllCompletedPointKagetFromPackage', [App\Http\Controllers\CompletedPointKagetController::class, 'resetAllCompletedPointKagetFromPackage'])->name('resetAllCompletedPointKagetFromPackage');

    // HistoryCollectedRewardsAdPointController
    Route::get('/list-history-collected-rewardsadpoint/{app_pkg}', [App\Http\Controllers\HistoryCollectedRewardsAdPointController::class, 'getDTHistoryCollectedRewardsAdPoint'])->name('list-history-collected-rewardsadpoint');
    Route::get('/list-history-collected-rewardsadpoint', [App\Http\Controllers\HistoryCollectedRewardsAdPointController::class, 'getCountHistoryCollectedRewardsAdPoint'])->name('list-count-history-rewardsadpoint');

    // HistoryExchangeBadgePlayer
    Route::get('/list-history-exchange-badge/{app_pkg}', [App\Http\Controllers\HistoryExchangeBadgePlayerController::class, 'getDTHistoryExchangeBadge'])->name('list-history-exchange-badge');
    Route::get('/list-history-collected-point-count', [App\Http\Controllers\HistoryExchangeBadgePlayerController::class, 'getCountHistoryExchangeBadge'])->name('list-count-history-exchange-badge');

    // WatchListPlayer
    Route::get('/watchlist-player/{app_pkg}', [App\Http\Controllers\WatchListPlayerController::class, 'getDTWatchListPlayer'])->name('watchlist-player');
    Route::get('/remove-player-from-watch-list/{player_id}', [App\Http\Controllers\WatchListPlayerController::class, 'removePlayerFromWatchList'])->name('removePlayerFromWatchList');

    //JOBSERVICES
    Route::get('/jobservices/panel-setting', [App\Http\Controllers\PanelSettingController::class, 'getSettingList'])->name('getSettingList');
    Route::post('/jobservices/panel-setting/updateSettingList', [App\Http\Controllers\PanelSettingController::class, 'updateSettingList'])->name('updateSettingList');

    //auth
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::get('/blank-page', [App\Http\Controllers\HomeController::class, 'blank'])->name('blank');
    Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])
        ->name('hakakses.index')
        ->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])
        ->name('hakakses.edit')
        ->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])
        ->name('hakakses.update')
        ->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])
        ->name('hakakses.delete')
        ->middleware('superadmin');
});
