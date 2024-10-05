<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\NetwatchController;
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
Route::middleware(['auth:sanctum'])->group(function () {
    // Users atau Members
});

// Route::get('/member/api', [MemberController::class, 'apiUsersGet'])->name('members.user.api'); // API GET


Route::post('/mikrotik/netwatch-log', [NetwatchController::class, 'store']);
Route::post('/owner/callback', [OrderController::class, 'callback'])->name('callback');