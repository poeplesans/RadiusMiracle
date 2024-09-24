<?php

// app/Http/Controllers/LineController.php

namespace App\Http\Controllers;

use Log;
use App\Models\Line;
use App\Models\Point;
use App\Imports\LinesImport;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Maatwebsite\Excel\Facades\Excel;

class LineController extends Controller
{
    public function import(Request $request)
    {
        set_time_limit(300);
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls',
        ]);
        DatabaseHelper::setDynamicConnection();
        $file = $request->file('excel_file');
        $data = Excel::toArray(new LinesImport, $file);

        return dd($data[0][1][0]);
        // foreach ($data[0] as $row) {
        //     Line::create([
        //         'name' => $row[0],
        //         'data' => $this->formatCoordinates($row[1]),
        //     ]);
        // }

        // return redirect()->back()->with('success', 'Lines imported successfully!');
    }

    private function formatCoordinates($data)
    {
        // Remove extra whitespace and split by newlines
        $lines = array_filter(array_map('trim', explode("\n", $data)));

        // Convert each line into an array of coordinates
        $coordinates = array_map(function ($line) {
            // Check if the line contains a comma
            if (strpos($line, ',') !== false) {
                $parts = explode(',', $line);

                // Ensure there are exactly two parts
                if (count($parts) === 2) {
                    $lat = trim($parts[0]);
                    $lng = trim($parts[1]);

                    // Check if latitude and longitude are valid numbers
                    if (is_numeric($lat) && is_numeric($lng)) {
                        return ['lat' => (float)$lat, 'lng' => (float)$lng];
                    }
                }
            }

            // Return null or handle invalid lines
            return null;
        }, $lines);

        // Filter out any null values
        $coordinates = array_filter($coordinates);

        // Convert the array to JSON or another suitable format
        return json_encode($coordinates);
    }

    

    public function getLines()
    {
        try {
            DatabaseHelper::setDynamicConnection();
            // Mengambil semua data garis
            $lines = Line::all();

            // Memformat data garis dan mengkonversi kolom 'data' menjadi koordinat
            $formattedLines = $lines->map(function ($line) {
                $coordinates = json_decode($line->data, true);

                // Memastikan koordinat valid
                if (!is_array($coordinates)) {
                    throw new \Exception('Invalid coordinates data for line ID: ' . $line->id);
                }

                return [
                    'id' => $line->id,
                    'name' => $line->name,
                    'coordinates' => $coordinates
                ];
            });

            return response()->json($formattedLines, 200); // Pastikan response adalah JSON
        } catch (\Exception $e) {
            // \Log::error('Error fetching lines: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch lines.'], 500); // Menangani error dengan JSON
        }
    }

    
}
