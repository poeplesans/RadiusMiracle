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
        $users = User::get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        // $usercek->makeHidden(['password']);
        if ($usercek) {
            $usercek =  $usercek;
        } else {
            $usercek =  $user;
        }

        // Mengambil semua role beserta sub_menu_id dari role_sub_menu
        $roles = Role::with(['roleSubMenus' => function ($query) {
            $query->select('role_id', 'sub_menu_id');
        }])->withCount('userrole')->get();

        //  return dd($roles);

        // Return ke view dengan data menu, users, roles, dan role_sub_menus
        return view('content.job.job', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'roles' => $roles,

        ]);
        // return view('content.job.job', compact('dummyData'));
    }
}
