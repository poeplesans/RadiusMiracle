<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ShortLinkController;

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



Route::get('/qr-scanner', [QRCodeController::class, 'index']);
Route::get('/generate-qr', [QRCodeController::class, 'generate']);

Route::get('/scan', function () {
    return view('content.qrcode.scan');
});
Route::get('/short', [ShortLinkController::class, 'index'])->name('shorten.index');
Route::post('/shorten', [ShortLinkController::class, 'store'])->name('shorten.store');
Route::get('/p/{shortenedUrl}', [ShortLinkController::class, 'redirect'])->name('shorten.redirect');

Route::get('/import-lines', function () {
    return view('import-lines');
});

Route::post('/import-lines', [LineController::class, 'import']);
Route::get('/lines', [LineController::class, 'getLines']);
Route::get('/select', function () {
    return view('layouts.auth.select');
});


Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('layouts.auth.register');
    })->name('register');
    Route::get('/forgot', function () {
        return view('layouts.auth.forgot');
    })->name('forgot');
    Route::get('/login', function () {
        return view('layouts.auth.login');
    })->name('login');
    Route::get('/', function () {
        return view('layouts.auth.login');
    })->name('login');
    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/select-login', [AuthController::class, 'selectlogin']);
});


Route::middleware('auth')->group(function () {
    Route::get('/absensi/get', [CalendarController::class, 'getevent'])->name('getevent');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/', [MenuController::class, 'home'])->name('home');
    Route::get('/tes', [MenuController::class, 'show'])->name('tes');
    Route::get('/notauth', [AuthController::class, 'notauth']);
    
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    // Route Midtrans
    Route::get('/owner/package', [OwnerController::class, 'package']);
    Route::get('/owner/setting', [OwnerController::class, 'index']);
    Route::post('/owner/pay', [OrderController::class, 'pay'])->name('pay');
    
    Route::middleware(['check.members'])->group(function () {

        // Route Header & Menu Controller
        Route::get('/header-menu', [MenuController::class, 'headermenu'])->name('header-menu');
        Route::post('/header-menu/menu/add', [MenuController::class, 'menuadd'])->name('menu.add');
        Route::post('/header-menu/menu/edit', [MenuController::class, 'menuedit'])->name('menu.edit');
        Route::delete('/header-menu/menu/delete/{id}', [MenuController::class, 'menudelete'])->name('menu.delete');
        // ----------------------------------------- //
        Route::post('/header-menu/header/add', [MenuController::class, 'headeradd'])->name('header.add');
        Route::post('/header-menu/header/edit', [MenuController::class, 'headeredit'])->name('header.edit');
        Route::delete('/header-menu/header/delete/{id}', [MenuController::class, 'headerdelete'])->name('header.delete');

        // Route Sub menu Controller
        Route::get('/sub-menu', [SubMenuController::class, 'submenu'])->name('sub-menu');
        Route::post('/sub-menu/add', [SubMenuController::class, 'submenuadd'])->name('sub-menu.add');
        Route::post('/sub-menu/edit', [SubMenuController::class, 'submenuedit'])->name('sub-menu.edit');
        Route::delete('/sub-menu/delete/{id}', [SubMenuController::class, 'submenudelete'])->name('sub-menu.destroy');

        Route::get('/absensi', [CalendarController::class, 'absensi'])->name('absensi');
        Route::get('/absensi/abs', [CalendarController::class, 'abs'])->name('absensi');
        
        // Route Members & Role
        Route::get('/members', [MemberController::class, 'index'])->name('members');
        Route::post('/members/users/add', [MemberController::class, 'store'])->name('members.users.add');
        Route::post('/members/users/edit', [MemberController::class, 'usersedit'])->name('members.users.edit');
        Route::delete('/members/users/delete/{id}', [MemberController::class, 'usersdelete'])->name('members.users.delete');

        Route::post('/members/role/add', [MemberController::class, 'roleadd'])->name('members.role.add');
        Route::post('/members/role/edit', [MemberController::class, 'roleedit'])->name('members.role.edit');
        Route::delete('/members/role/delete/{id}', [MemberController::class, 'roledelete'])->name('members.role.delete');

        Route::get('/map', [MapController::class, 'map'])->name('map');
        Route::get('/map/upload', [PointController::class, 'index']);

        // Ruoute MAP Line
        Route::get('/lines', [LineController::class, 'getLines']);
        Route::post('/map/lines/import', [LineController::class, 'lines.import']);
        Route::get('/map/lines', [LineController::class, 'getLines']);

        // Route MAP Point
        Route::post('/map/points', [PointController::class, 'store']);
        Route::get('/map/point', [PointController::class, 'getPoints']);
        Route::post('/map/point/import', [PointController::class, 'import'])->name('points.import');

        // Ruoute MAP LINE Backbone
        Route::get('/backbone', [MapController::class, 'index']);
        Route::post('/backbone/group/add', [MapController::class, 'backboneGroupAdd']);

        
    });
});
