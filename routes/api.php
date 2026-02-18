<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Translation API Routes
 */
Route::prefix('translations')->group(function () {
    // Tüm çeviriler
    Route::get('/', [TranslationController::class, 'index']);

    // İstatistikler
    Route::get('/stats', [TranslationController::class, 'stats']);

    // Mevcut diller
    Route::get('/locales', [TranslationController::class, 'locales']);

    // Belirli locale için çeviriler
    Route::get('/locale/{locale}', [TranslationController::class, 'byLocale']);

    // Grup çevirilerini al
    Route::get('/group/{group}', [TranslationController::class, 'group']);

    // Tek çeviri al
    Route::get('/key/{key}', [TranslationController::class, 'show']);

    // Çeviri oluştur
    Route::post('/', [TranslationController::class, 'store']);

    // Toplu çeviri oluştur
    Route::post('/bulk/store', [TranslationController::class, 'storeBulk']);

    // Çeviri güncelle
    Route::put('/{translation}', [TranslationController::class, 'update']);

    // Çeviri sil
    Route::delete('/{translation}', [TranslationController::class, 'destroy']);

    // Çeviri tarihçesi
    Route::get('/{translation}/history', [TranslationController::class, 'history']);

    // Dil dosyalarını sync et (admin only)
    Route::post('/sync-files', [TranslationController::class, 'syncFiles']);

    // Cache'i temizle (admin only)
    Route::post('/clear-cache', [TranslationController::class, 'clearCache']);
});
