<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiControllerV2;
use App\Http\Controllers\ApiControllerV3;
use App\Http\Controllers\NewApiController;
use App\Http\Controllers\API\DansoApiController;

use App\Http\Controllers\ProfileController;

    Route::post('/danso/v1/send-reset-link', [App\Http\Controllers\PlayerResetPasswordController::class, 'sendResetLink']);

    Route::post('/danso/v1/initializeMainApplication', [DansoApiController::class, 'initializeMainApplication']);

    Route::post('/danso/v1/registerPlayer', [DansoApiController::class, 'registerPlayer']);
    Route::post('/danso/v1/loginPlayer', [DansoApiController::class, 'loginPlayer']);

    Route::post('/danso/v1/getQuestionLevelOnCategory', [DansoApiController::class, 'getQuestionLevelOnCategory']);
    Route::post('/danso/v1/getQuestionOnLevelFromCategory', [DansoApiController::class, 'getQuestionOnLevelFromCategory']);
    Route::post('/danso/v1/getListHistoryQuizPlayer', [DansoApiController::class, 'getListHistoryQuizPlayer']);

    Route::post('/danso/v1/getListHistoryWithdrawPlayer', [DansoApiController::class, 'getListHistoryWithdrawPlayer']);
    Route::post('/danso/v1/getListHistoryCollectedPointPlayer', [DansoApiController::class, 'getListHistoryCollectedPointPlayer']);

    Route::post('/danso/v1/addRefferalledFromPlayer', [DansoApiController::class, 'addRefferalledFromPlayer']);
    Route::post('/danso/v1/getListHistoryRefferal', [DansoApiController::class, 'getListHistoryRefferal']);

    Route::post('/danso/v1/setCompletedQuizPlayer', [DansoApiController::class, 'setCompletedQuizPlayer']);

    Route::post('/danso/v1/collectRewardsAdPoint', [DansoApiController::class, 'collectRewardsAdPoint']);
    Route::post('/danso/v1/setCompletedNewPointKaget', [DansoApiController::class, 'setCompletedNewPointKaget']);
    Route::post('/danso/v1/getCurrentCompletedNewPointKaget', [DansoApiController::class, 'getCurrentCompletedNewPointKaget']);

    Route::post('/danso/v1/getPlayerListRanksByScores', [DansoApiController::class, 'getPlayerListRanksByScores']);

    Route::post('/danso/v1/requestExchangeBadge', [DansoApiController::class, 'requestExchangeBadge']);
    Route::post('/danso/v1/getListCollectedBadgeOnPlayer', [DansoApiController::class, 'getListCollectedBadgeOnPlayer']);

    Route::post('/danso/v1/refreshDataPlayer', [DansoApiController::class, 'refreshDataPlayer']);
    Route::post('/danso/v1/changePasswordPlayer', [DansoApiController::class, 'changePasswordPlayer']);
    Route::post('/danso/v1/editDataPlayer', [DansoApiController::class, 'editDataPlayer']);
    Route::post('/danso/v1/editAvatarPlayer', [DansoApiController::class, 'editAvatarPlayer']);
    Route::post('/danso/v1/logoutPlayer', [DansoApiController::class, 'logoutPlayer']);
    Route::post('/danso/v1/requestWithdrawPlayer', [DansoApiController::class, 'requestWithdrawPlayer']);

    Route::post('/danso/v1/ext/collectPointExternal', [DansoApiController::class, 'collectPointExternal']);
    Route::post('/danso/v1/ext/validationPlayer', [DansoApiController::class, 'validationPlayer']);
    Route::post('/danso/v1/ext/getCountdownTimeCollectPointExternal', [DansoApiController::class, 'getCountdownTimeCollectPointExternal']);


//reset-password
Route::post('/v3/send-reset-link', [App\Http\Controllers\PlayerResetPasswordController::class, 'sendResetLink']);

Route::post('/v3/initializeMainApplication', [ApiControllerV3::class, 'initializeMainApplication']);

Route::post('/v3/registerPlayer', [ApiControllerV3::class, 'registerPlayer']);
Route::post('/v3/loginPlayer', [ApiControllerV3::class, 'loginPlayer']);

Route::post('/v3/getQuestionLevelOnCategory', [ApiControllerV3::class, 'getQuestionLevelOnCategory']);
Route::post('/v3/getQuestionOnLevelFromCategory', [ApiControllerV3::class, 'getQuestionOnLevelFromCategory']);
Route::post('/v3/getListHistoryQuizPlayer', [ApiControllerV3::class, 'getListHistoryQuizPlayer']);

Route::post('/v3/getListHistoryWithdrawPlayer', [ApiControllerV3::class, 'getListHistoryWithdrawPlayer']);
Route::post('/v3/getListHistoryCollectedPointPlayer', [ApiControllerV3::class, 'getListHistoryCollectedPointPlayer']);

Route::post('/v3/addRefferalledFromPlayer', [ApiControllerV3::class, 'addRefferalledFromPlayer']);
Route::post('/v3/getListHistoryRefferal', [ApiControllerV3::class, 'getListHistoryRefferal']);

Route::post('/v3/setCompletedQuizPlayer', [ApiControllerV3::class, 'setCompletedQuizPlayer']);

Route::post('/v3/collectRewardsAdPoint', [ApiControllerV3::class, 'collectRewardsAdPoint']);
Route::post('/v3/setCompletedNewPointKaget', [ApiControllerV3::class, 'setCompletedNewPointKaget']);
Route::post('/v3/getCurrentCompletedNewPointKaget', [ApiControllerV3::class, 'getCurrentCompletedNewPointKaget']);

Route::post('/v3/getPlayerListRanksByScores', [ApiControllerV3::class, 'getPlayerListRanksByScores']);

Route::post('/v3/requestExchangeBadge', [ApiControllerV3::class, 'requestExchangeBadge']);
Route::post('/v3/getListCollectedBadgeOnPlayer', [ApiControllerV3::class, 'getListCollectedBadgeOnPlayer']);

Route::post('/v3/refreshDataPlayer', [ApiControllerV3::class, 'refreshDataPlayer']);
Route::post('/v3/changePasswordPlayer', [ApiControllerV3::class, 'changePasswordPlayer']);
Route::post('/v3/editDataPlayer', [ApiControllerV3::class, 'editDataPlayer']);
Route::post('/v3/editAvatarPlayer', [ApiControllerV3::class, 'editAvatarPlayer']);
Route::post('/v3/logoutPlayer', [ApiControllerV3::class, 'logoutPlayer']);
Route::post('/v3/requestWithdrawPlayer', [ApiControllerV3::class, 'requestWithdrawPlayer']);

Route::post('/v3/ext/collectPointExternal', [ApiControllerV3::class, 'collectPointExternal']);
Route::post('/v3/ext/validationPlayer', [ApiControllerV3::class, 'validationPlayer']);
Route::post('/v3/ext/getCountdownTimeCollectPointExternal', [ApiControllerV3::class, 'getCountdownTimeCollectPointExternal']);

// v2 deleted soon
Route::post('/v2/send-reset-link', [App\Http\Controllers\PlayerResetPasswordController::class, 'sendResetLink']);

Route::post('/v2/initializeMainApplication', [ApiControllerV2::class, 'initializeMainApplication']);

Route::post('/v2/registerPlayer', [ApiControllerV2::class, 'registerPlayer']);
Route::post('/v2/loginPlayer', [ApiControllerV2::class, 'loginPlayer']);

Route::post('/v2/getQuestionLevelOnCategory', [ApiControllerV2::class, 'getQuestionLevelOnCategory']);
Route::post('/v2/getQuestionOnLevelFromCategory', [ApiControllerV2::class, 'getQuestionOnLevelFromCategory']);
Route::post('/v2/getListHistoryQuizPlayer', [ApiControllerV2::class, 'getListHistoryQuizPlayer']);

Route::post('/v2/getListHistoryWithdrawPlayer', [ApiControllerV2::class, 'getListHistoryWithdrawPlayer']);
Route::post('/v2/getListHistoryCollectedPointPlayer', [ApiControllerV2::class, 'getListHistoryCollectedPointPlayer']);

Route::post('/v2/addRefferalledFromPlayer', [ApiControllerV2::class, 'addRefferalledFromPlayer']);
Route::post('/v2/getListHistoryRefferal', [ApiControllerV2::class, 'getListHistoryRefferal']);

Route::post('/v2/setCompletedQuizPlayer', [ApiControllerV2::class, 'setCompletedQuizPlayer']);

Route::post('/v2/collectRewardsAdPoint', [ApiControllerV2::class, 'collectRewardsAdPoint']);

Route::post('/v2/getPlayerListRanksByScores', [ApiControllerV2::class, 'getPlayerListRanksByScores']);

Route::post('/v2/requestExchangeBadge', [ApiControllerV2::class, 'requestExchangeBadge']);
Route::post('/v2/getListCollectedBadgeOnPlayer', [ApiControllerV2::class, 'getListCollectedBadgeOnPlayer']);

Route::post('/v2/refreshDataPlayer', [ApiControllerV2::class, 'refreshDataPlayer']);
Route::post('/v2/changePasswordPlayer', [ApiControllerV2::class, 'changePasswordPlayer']);
Route::post('/v2/editDataPlayer', [ApiControllerV2::class, 'editDataPlayer']);
Route::post('/v2/editAvatarPlayer', [ApiControllerV2::class, 'editAvatarPlayer']);
Route::post('/v2/logoutPlayer', [ApiControllerV2::class, 'logoutPlayer']);
Route::post('/v2/requestWithdrawPlayer', [ApiControllerV2::class, 'requestWithdrawPlayer']);

Route::post('/v2/ext/collectPointExternal', [ApiControllerV2::class, 'collectPointExternal']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
