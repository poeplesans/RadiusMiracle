<?php

namespace App\Http\Controllers\utilities;

use App\Models\Role;
use App\Models\User;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VpnController extends Controller
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
        $users = User::with('role_id')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        if ($usercek) {
            $usercek->makeHidden(['password']);
            $usercek =  $usercek;
        } else {
            $usercek =  $user;
        }

        // Mengambil semua role beserta sub_menu_id dari role_sub_menu
        $roles = Role::with(['roleSubMenus' => function ($query) {
            $query->select('role_id', 'sub_menu_id');
        }])->withCount('userrole')->get();

        //  return dd($menus);

        // Return ke view dengan data menu, users, roles, dan role_sub_menus
        return view('content.utilities.vpn', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'roles' => $roles,

        ]);
    }
}
