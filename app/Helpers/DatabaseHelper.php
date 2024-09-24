<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DatabaseHelper
{
    public static function setDynamicConnection()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        if (!$user) {
            return;
        }

        // Ambil database koneksi dinamis dari session
        $dbName = session('db_connection');
        if (!$dbName) {
            return;
        }

        // Set koneksi database dinamis
        config(['database.connections.mysql.database' => $dbName]);
        DB::reconnect('mysql');
    }
}
