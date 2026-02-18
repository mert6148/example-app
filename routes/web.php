<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Serve language demo pages (static HTML wrapped in blade)
Route::get('/lang/{locale}', function ($locale) {
    $allowed = ['en', 'tr'];
    if (! in_array($locale, $allowed)) {
        abort(404);
    }

    return view('lang.' . $locale);
});

// Direct PHP pages that use standalone LangClass
Route::get('/lang/demo/{locale}', function ($locale) {
    $file = base_path("lang/{$locale}/index.php");
    if (! file_exists($file)) {
        abort(404);
    }

    // let web server execute it
    return response()->file($file);
});
