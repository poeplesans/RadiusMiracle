<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        // Data dummy
        $dummyData = [
            ['team_name' => 'Tim A', 'start_time' => '2023-10-2 09:00:00', 'end_time' => '2023-10-2 12:00:00'],
            ['team_name' => 'Tim B', 'start_time' => '2023-10-2 10:00:00', 'end_time' => '2023-10-2 12:00:00'],
        ];

        return view('content.job.job', compact('dummyData'));
    }
}
