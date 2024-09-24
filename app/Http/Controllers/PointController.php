<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PointController extends Controller
{
    public function index()
    {
        // return dd($request);
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        // return $user['office_id'];
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];

        // return $roles;
        return view('content.map.map-upload', ['menuArray' => $menus]);
        // return view("content.map.point-upload");
    }
    public function store(Request $request)
    {
        DatabaseHelper::setDynamicConnection();

        // Validasi incoming request
        $validated = $request->validate([
            'line_id' => 'required',
            'points' => 'required|array',
        ]);

        try {
            // // Simpan titik ke database
            foreach ($validated['points'] as $pointData) {
                Point::create([
                    'line_id' => $validated['line_id'],
                    'latitude' => $pointData['latitude'],
                    'longitude' => $pointData['longitude'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Points saved successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save points.', 'error' => $e->getMessage()], 500);
        }
    }
    public function getPoints()
    {
        try {
            DatabaseHelper::setDynamicConnection();
            // Mengambil semua data titik
            $points = Point::all();

            // Memformat titik untuk dikirim sebagai JSON
            $formattedPoints = $points->map(function ($point) {
                return [
                    'id' => $point->id,
                    'line_id' => $point->line_id,
                    'latitude' => $point->latitude,
                    'longitude' => $point->longitude
                ];
            });

            return response()->json($formattedPoints, 200); // Pastikan response adalah JSON
        } catch (\Exception $e) {
            // \Log::error('Error fetching points: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch points.'], 500); // Menangani error dengan JSON
        }
    }
    public function import(Request $request)
    {
        set_time_limit(500);
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        // Load Excel file
        DatabaseHelper::setDynamicConnection();
        $path = $request->file('file')->getRealPath();
        $data = Excel::toArray([], $path)[0]; // Mengambil sheet pertama

        // Iterasi setiap baris setelah header
        foreach ($data as $key => $row) {
            // Lewati baris pertama (header)
            if ($key == 0) {
                continue;
            }

            $map_id = $row[0]; // 'map_id' di kolom pertama

            // Cek apakah map_id sudah ada di database
            $existingPoint = Point::where('map_id', $map_id)->first();
            if ($existingPoint) {
                // Jika map_id sudah ada, skip baris ini
                continue;
            }

            // Mengubah koma menjadi titik untuk latitude dan longitude
            $latitude = str_replace(',', '.', $row[1]); // 'lat' di kolom ke-2
            $longitude = str_replace(',', '.', $row[2]); // 'long' di kolom ke-3

            // Buat atau simpan data ke database
            Point::create([
                'line_id' => 0,
                'map_id' => $map_id,   // Menggunakan map_id yang diambil dari Excel
                'latitude' => $latitude,
                'longitude' => $longitude,
                'village' => $row[3],      // village ada di kolom ke-4
                'county' => $row[4],       // county ada di kolom ke-5
                'state' => $row[5],        // state ada di kolom ke-6
                'region' => $row[6],       // region ada di kolom ke-7
                'display_name' => $row[10], // display_name ada di kolom ke-11
            ]);
        }

        return back()->with('success', 'Data berhasil di-import!');
    }
}
