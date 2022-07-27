<?php

use App\Http\Controllers\LaraTrustController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::group(["middleware" => "auth"], function () {
    // member
    Route::resource('member', MemberController::class);
    Route::get('member-data', [MemberController::class, 'data'])->name('member.data');
    Route::get('user-management', [LaraTrustController::class, 'index'])->name('user_manajemen');
});
require __DIR__ . '/auth.php';
