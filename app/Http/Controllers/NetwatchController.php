<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NetwatchLog;

class NetwatchController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'host' => 'required',
            'status' => 'required|in:up,down',
        ]);

        // Simpan data ke database
        NetwatchLog::create([
            'host' => $request->input('host'),
            'status' => $request->input('status'),
            'time' => $request->input('time'),
            'date' => $request->input('date'),
        ]);

        return response()->json(['message' => 'Log saved successfully'], 200);
    }
}
