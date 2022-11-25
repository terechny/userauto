<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutouserController;
use App\Http\Controllers\AutoController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('autouser/setauto', [AutouserController::class, 'setUserAuto'], )->name('autouser.set_auto');
Route::post('autouser/destroyauto', [AutouserController::class, 'destroyUserAuto'], )->name('autouser.destroy_auto');
Route::get('autouser/{id}/showauto', [AutouserController::class, 'showUserAuto'], )->where('id', '[0-9]+')->name('autouser.show_auto');

Route::resource('autouser', AutouserController::class);
Route::resource('auto', AutoController::class);