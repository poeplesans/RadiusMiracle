<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Event;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function absensi()
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        // Mengambil dynamic menu
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];

        // Set dynamic connection
        DatabaseHelper::setDynamicConnection();

        // Mengambil semua data user
        $users = User::with('role_id')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        $usercek->makeHidden(['password']);

        // Mengambil semua role beserta sub_menu_id dari role_sub_menu
        $roles = Role::with(['roleSubMenus' => function ($query) {
            $query->select('role_id', 'sub_menu_id');
        }])->withCount('userrole')->get();

        //  return dd($roles);

        // Return ke view dengan data menu, users, roles, dan role_sub_menus
        return view('content.management.absensi', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'roles' => $roles,

        ]);
    }
    public function abs()
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        // Mengambil dynamic menu
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];

        // Set dynamic connection
        DatabaseHelper::setDynamicConnection();

        // Mengambil semua data user
        $users = User::with('role_id')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        $usercek->makeHidden(['password']);

        // Mengambil semua role beserta sub_menu_id dari role_sub_menu
        $roles = Role::with(['roleSubMenus' => function ($query) {
            $query->select('role_id', 'sub_menu_id');
        }])->withCount('userrole')->get();

        //  return dd($roles);

        // Return ke view dengan data menu, users, roles, dan role_sub_menus
        return view('content.management.abs', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'roles' => $roles,

        ]);
    }

    public function getevent()
    {
        DatabaseHelper::setDynamicConnection();
        $events = Event::all(); // Mengambil semua event dari database

        // Kirim data event ke view dalam bentuk JSON untuk FullCalendar
        $eventData = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start,
                'end' => $event->end,
                'allDay' => $event->all_day,
                'extendedProps' => [
                    'calendar' => $event->calendar
                ]
            ];
        });

        // return view('calendar', ['events' => $eventData]);
        return response()->json($eventData);
    }

    public function update(Request $request)
    {
        DatabaseHelper::setDynamicConnection();
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:events,id', // Asumsikan ID event
            'start' => 'required|date',
            'end' => 'nullable|date',
        ]);

        $start = Carbon::parse($validatedData['start'])->format('Y-m-d H:i:s');
        $end = Carbon::parse($validatedData['end'])->format('Y-m-d H:i:s');
        // Cari event berdasarkan ID yang diterima
        $event = Event::findOrFail($validatedData['id']);

        // Perbarui tanggal mulai dan tanggal akhir event
        $event->start = $start;
        $event->end = $end; // Bisa nullable, tergantung apakah event punya tanggal akhir

        // Simpan perubahan ke database
        $event->save();

        // Kembalikan respon JSON
        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui',
        ]);
    }
}
