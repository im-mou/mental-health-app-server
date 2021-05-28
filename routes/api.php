<?php

use App\Http\Controllers\InitController;
use App\Http\Controllers\InterestController;
use Illuminate\Http\Request;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function(){

    Route::get('app/populate', [InitController::class, 'index']);

    Route::post('user/register', [UserController::class, 'store']);
    Route::post('user/info', [UserController::class, 'getUser']);
    Route::post('user/togglenotifications', [UserController::class, 'toggleNotifications']);
    Route::post('user/update', [UserController::class, 'updateUserData']);

    Route::get('interests', [InterestController::class, 'getAllInterests']);
    Route::post('interests', [InterestController::class, 'getInterests']);
    Route::post('interests/update', [InterestController::class, 'updateInterests']);

    Route::post('journal', [JournalController::class, 'index']);
    Route::post('journal/month', [JournalController::class, 'getMonthJournal']);
    Route::post('journal/today', [JournalController::class, 'getTodayJournal']);
    Route::post('journal/insert', [JournalController::class, 'addJournalEntry']);
    Route::post('journal/sentimentupdate', [JournalController::class, 'updateCurrentSentiment']);

});
