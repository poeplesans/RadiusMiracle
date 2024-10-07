<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HrController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LineController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\utilities\VpnController;

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


Route::post('/import-data', [ExportController::class, 'import'])->name('import.data');
Route::get('/qr-scanner', [QRCodeController::class, 'index']);
Route::get('/pushmenu', [ExportController::class, 'pushmenu']);
Route::get('/index', [ExportController::class, 'index']);
Route::get('/generate-qr', [QRCodeController::class, 'generate']);
Route::get('export/combined', [ExportController::class, 'exportCombined']);
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
    // API CALENDAR


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
        // ----------------------------------------- //
        // Route Header & Menu Controller
        // ----------------------------------------- //

        // ----------------------------------------- Menu Route
        Route::get('/header-menu', [MenuController::class, 'headermenu'])->name('header-menu');
        Route::post('/header-menu/menu/add', [MenuController::class, 'menuadd'])->name('menu.add');
        Route::post('/header-menu/menu/edit', [MenuController::class, 'menuedit'])->name('menu.edit');
        Route::delete('/header-menu/menu/delete/{id}', [MenuController::class, 'menudelete'])->name('menu.delete');
        // ----------------------------------------- Member Route
        Route::post('/header-menu/header/add', [MenuController::class, 'headeradd'])->name('header.add');
        Route::post('/header-menu/header/edit', [MenuController::class, 'headeredit'])->name('header.edit');
        Route::delete('/header-menu/header/delete/{id}', [MenuController::class, 'headerdelete'])->name('header.delete');
        // ----------------------------------------- Sub Menu Route
        Route::get('/sub-menu', [SubMenuController::class, 'submenu'])->name('sub-menu');
        Route::post('/sub-menu/add', [SubMenuController::class, 'submenuadd'])->name('sub-menu.add');
        Route::post('/sub-menu/edit', [SubMenuController::class, 'submenuedit'])->name('sub-menu.edit');
        Route::delete('/sub-menu/delete/{id}', [SubMenuController::class, 'submenudelete'])->name('sub-menu.destroy');

        // ----------------------------------------- //
        // ----------------  Utilities  ----------- //
        // ----------------------------------------- //
        Route::get('/vpn', [VpnController::class, 'index'])->name('vpn');
        Route::get('/nas', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/olt', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ip-pool', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/prifle-ppp', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Administration  ----------- //
        // ----------------------------------------- //
        Route::get('/ticket/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ticket/active', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ticket/closed', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ticket/pending', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ticket/check', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/payment/pay', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/payment/check', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/payment/upgrade', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/wh/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/wh/out', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/wh/check', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Human Resource  ----------- //
        // ----------------------------------------- //
        // Route::get('/absensi', [CalendarController::class, 'absensi'])->name('absensi');

        Route::get('/hr/absensi', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/hr/jadwal', [HrController::class, 'jadwal'])->name('jadwal');
        Route::get('/hr/payroll', [HrController::class, 'payroll'])->name('payroll');
        Route::get('/hr/calendar', [HrController::class, 'calendar'])->name('calendar');
        Route::get('/hr/calendar/api', [CalendarController::class, 'getevent'])->name('getevent');
        Route::post('/hr/calendar/api', [CalendarController::class, 'update'])->name('event.update');
        Route::get('/absensi/api', [CalendarController::class, 'getevent'])->name('getevent');
        Route::post('/absensi/api', [CalendarController::class, 'update'])->name('event.update');

        
        // ----------------------------------------- Member Route
        Route::get('/members', [MemberController::class, 'index'])->name('members');
        Route::post('/members/users/add', [MemberController::class, 'store'])->name('members.users.add');
        Route::post('/members/users/edit', [MemberController::class, 'usersedit'])->name('members.users.edit');
        Route::delete('/members/users/delete/{id}', [MemberController::class, 'usersdelete'])->name('members.users.delete');
        Route::get('/members/api', [MemberController::class, 'apiUsersGet'])->name('members.user.api'); // API GET

        // ----------------------------------------- Role Route
        Route::post('/members/role/add', [MemberController::class, 'roleadd'])->name('members.role.add');
        Route::post('/members/role/edit', [MemberController::class, 'roleedit'])->name('members.role.edit');
        Route::delete('/members/role/delete/{id}', [MemberController::class, 'roledelete'])->name('members.role.delete');
        

        Route::get('/session', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/employe', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Operasional  ----------- //
        // ----------------------------------------- //
        Route::get('/sales/new', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/sales/report', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/sales/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/sales/approval', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/sales/all/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/sales/proggres', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/psb/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/psb/pending', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/psb/done', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/psb/cencel', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ass/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ass/done', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ass/kendala', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/ass/pending', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/pda/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/pda/pending', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/mtc/netwatch', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/mtc/open-ticket', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/mtc/olt', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/daman/device', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/daman/odc', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/daman/odp', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/daman/link', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/daman/qrcode', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Subscription Area  ----------- //
        // ----------------------------------------- //
        Route::get('/subs/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/subs/online', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/subs/offline', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/subs/expired', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/package/list', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/package/tax', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/package/policy', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/billing/paycol', [HrController::class, 'absensi'])->name('absensi');
        Route::get('/billing/expired', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Report  ----------- //
        // ----------------------------------------- //
        Route::get('', [HrController::class, 'absensi'])->name('absensi');

        // ----------------------------------------- //
        // ----------------  Accounting  ----------- //
        // ----------------------------------------- //
        Route::get('', [HrController::class, 'absensi'])->name('absensi');


        Route::get('/absensi/abs', [CalendarController::class, 'abs'])->name('absensi');

        // Route Members & Role



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
