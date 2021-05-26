<?php

use Illuminate\Http\Request;
use App\Http\Controllers\JournalController;
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
    Route::post('journal', [JournalController::class, 'index']);
    Route::get('journal/{user_id}/{month}/{year}', [JournalController::class, 'getMonthJournal']);
    Route::get('journal/{user_id}/today', [JournalController::class, 'getTodayJournal']);
    Route::post('journal/{journal_id}/{user_id}/insert', [JournalController::class, 'addJournalEntry']);
});
