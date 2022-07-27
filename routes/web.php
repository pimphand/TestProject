<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\LaraTrustController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
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
    return redirect(route('member.index'));
})->name('dashboard');

Route::group(["middleware" => "auth"], function () {
    // member
    Route::resource('member', MemberController::class);
    Route::get('member-data', [MemberController::class, 'data'])->name('member.data');
    Route::post('member-import', [MemberController::class, 'import'])->name('member.import');
    // laratrust
    Route::get('user-management', [LaraTrustController::class, 'index'])->name('user_manajemen');
    // group
    Route::resource('group', GroupController::class);
    Route::get('group-data', [GroupController::class, 'data'])->name('group.data');
    // group
    Route::resource('user', UserController::class);
    Route::get('user-data', [UserController::class, 'data'])->name('user.data');
});
require __DIR__ . '/auth.php';
