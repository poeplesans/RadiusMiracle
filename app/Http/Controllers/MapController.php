<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Role;
use App\Models\User;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    public function map(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        // return $user['office_id'];
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];
        // $subMenus = $arraymenus['subMenus'];
        
        DatabaseHelper::setDynamicConnection();
        $users = User::all();
        $roles = Role::withCount('userrole')->get();

        // return $roles;
        return view('content.map.map', ['menuArray' => $menus, 'users' => $users, 'roles' => $roles]);
    }
    public function index()
    {
        $user = Auth::hasUser();
        // $user = Auth::user();
        if (!$user) {
            return '';
        }
        return $user;

        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];
        
        // Set dynamic connection
        DatabaseHelper::setDynamicConnection();
        $users = User::all();
        $roles = Role::withCount('userrole')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        $usercek->makeHidden(['password']);

        // Titik asal dan tujuan
        $startPoint = ['lat' => -8.068, 'lng' => 111.92581];
        $endPoint = ['lat' => -8.06736, 'lng' => 111.93138];

        // Ambil semua line dari database
        $lines = Line::all();

        // Inisialisasi variabel untuk menyimpan Line terdekat
        $closestLineA = null;
        $closestLineB = null;
        $minDistanceA = PHP_INT_MAX;
        $minDistanceB = PHP_INT_MAX;

        // Cari Line terdekat dengan titik asal (Line A)
        foreach ($lines as $line) {
            // Periksa apakah data sudah berupa array atau string JSON
            $coordinates = is_array($line->data) ? $line->data : json_decode($line->data, true);

            if (is_array($coordinates)) {
                foreach ($coordinates as $coord) {
                    $distance = $this->haversine($startPoint['lat'], $startPoint['lng'], $coord['lat'], $coord['lng']);
                    // $distance = $this->haversine($startPoint['lat'], $startPoint['lng'], $coord['lng'], $coord['lat']);
                    if ($distance < $minDistanceA) {
                        $minDistanceA = $distance;
                        $closestLineA = $line;
                    }
                }
            }
        }

        // Cari Line terdekat dengan titik tujuan (Line B)
        foreach ($lines as $line) {
            // Periksa apakah data sudah berupa array atau string JSON
            $coordinates = is_array($line->data) ? $line->data : json_decode($line->data, true);

            if (is_array($coordinates)) {
                foreach ($coordinates as $coord) {
                    $distance = $this->haversine($endPoint['lat'], $endPoint['lng'], $coord['lat'], $coord['lng']);
                    // $distance = $this->haversine($endPoint['lat'], $endPoint['lng'], $coord['lng'], $coord['lat']);
                    if ($distance < $minDistanceB) {
                        $minDistanceB = $distance;
                        $closestLineB = $line;
                    }
                }
            }
        }

        // Format data Line A dan Line B untuk Leaflet
        $lineA = $closestLineA ? (is_array($closestLineA->data) ? $closestLineA->data : json_decode($closestLineA->data, true)) : [];
        $lineB = $closestLineB ? (is_array($closestLineB->data) ? $closestLineB->data : json_decode($closestLineB->data, true)) : [];
        
        // return dd($lineA[0], $lineB[0], $startPoint, $endPoint);

        // Kirim data ke view untuk ditampilkan di Leaflet
        return view('content.map.backbone', [
            'menuArray' => $menus,
            'users' => $users,
            'roles' => $roles,
            'lineA' => $lineA,
            'lineB' => $lineB,
            'startPoint' => $startPoint,
            'endPoint' => $endPoint,
            'usercek' => $usercek,
        ]);
    }

    // Fungsi Haversine untuk menghitung jarak antar koordinat
    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371;  // radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earth_radius * $c;  // hasil dalam kilometer
    }

    public function backboneGroupAdd(Request $request)
    {
        return dd($request->all());
    }
}
