<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MenuHelper
{
    public static function getDynamicMenu()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        if (!$user) {
            return '';
        }
        // return dd($user);
        // Ambil database koneksi dinamis dari session
        $dbName = session('db_connection');
        if (!$dbName) {
            return '';
        }

        if (!config()->has('database.connections.' . $dbName)) {
            config([
                'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                    'database' => $dbName, // Nama database dinamis
                ]),
            ]);
        }

        if (in_array($user->user_type, ['Owner', 'Creator'])) {
            $role = 1;
            $usercek = User::where('email', $user->email)->first();
            $usercek['role_id'] = [
                'name' => 'SuperAdmin',
                'nip' => 1
            ];
            $usercek->makeHidden(['password']);
        } else {
            DatabaseHelper::setDynamicConnection();
            $usercek = User::where('email', $user->email)->with('role_id')->first();
            $usercek->makeHidden(['password']);
            // Pastikan role tidak null
            if ($usercek) {
                $role = $usercek->role;
            } else {
                $role = null; // Atau set ke default jika tidak ditemukan
            }
        }
        // Cek apakah role adalah 'owner'
        if ($role == 1) {
            // Jika role adalah 'owner', tampilkan semua menu, sub-menu, dan header
            $menus = DB::connection($dbName)->table('headers')
                ->leftJoin('menus', 'headers.id', '=', 'menus.header_id') // Gunakan leftJoin
                ->leftJoin('sub_menus', 'menus.id', '=', 'sub_menus.menu_id') // Gunakan leftJoin
                ->select(
                    'headers.id as header_id',
                    'headers.name as header_name',
                    'headers.created_at as header_created_at',
                    'headers.updated_at as header_updated_at',
                    'menus.id as menu_id',
                    'menus.name as menu_name',
                    'menus.icon as menu_icon',
                    'menus.url as menu_url',
                    'menus.created_at as menus_created_at',
                    'menus.updated_at as menus_updated_at',
                    'sub_menus.id as sub_menu_id',
                    'sub_menus.name as sub_menu_name',
                    'sub_menus.url as sub_menu_url',
                    'sub_menus.icon as sub_menu_icon',
                    'sub_menus.created_at as sub_menus_created_at', // Tambahkan ini
                    'sub_menus.updated_at as sub_menus_updated_at', // Tambahkan ini
                )
                ->get();

            // return dd($menus);
        } else {
            // Jika bukan owner, filter berdasarkan role user
            $menus = DB::connection($dbName)->table('headers')
                ->join('menus', 'headers.id', '=', 'menus.header_id')
                ->join('sub_menus', 'menus.id', '=', 'sub_menus.menu_id')
                ->join('role_sub_menu', 'sub_menus.id', '=', 'role_sub_menu.sub_menu_id')
                ->join('roles', 'role_sub_menu.role_id', '=', 'roles.id')
                ->where('roles.id', $role->role) // Sesuaikan filter berdasarkan peran
                ->select(
                    'headers.id as header_id',
                    'headers.name as header_name',
                    'headers.created_at as header_created_at', // Tambahkan ini
                    'headers.updated_at as header_updated_at', // Tambahkan ini
                    'menus.id as menu_id',
                    'menus.name as menu_name',
                    'menus.icon as menu_icon', // Tambahkan ini untuk ikon di menu
                    'menus.url as menu_url', // Tambahkan ini untuk URL di menu
                    'menus.created_at as menus_created_at', // Tambahkan ini
                    'menus.updated_at as menus_updated_at', // Tambahkan ini
                    'sub_menus.id as sub_menu_id',
                    'sub_menus.name as sub_menu_name',
                    'sub_menus.url as sub_menu_url',
                    'sub_menus.icon as sub_menu_icon', // Tambahkan ini untuk ikon di sub menu
                    'sub_menus.created_at as sub_menus_created_at', // Tambahkan ini
                    'sub_menus.updated_at as sub_menus_updated_at', // Tambahkan ini
                )
                ->get();
        }
        //  return dd($menus);
        // Mengatur menu dan sub-menu
        $menuStructure = [];
        foreach ($menus as $menu) {
            // Cek apakah header_name sudah ada di $menuStructure
            if (!isset($menuStructure[$menu->header_name])) {
                $menuStructure[$menu->header_name] = [
                    'menus' => [], // Ini untuk menyimpan menu dan sub-menus
                    'header_id' => $menu->header_id, // Tambahkan created_at
                    'created_at' => $menu->header_created_at, // Tambahkan created_at
                    'updated_at' => $menu->header_updated_at, // Tambahkan updated_at
                ];
            }
            // Cek apakah menu_name sudah ada di dalam header_name
            if (!isset($menuStructure[$menu->header_name]['menus'][$menu->menu_name])) {
                // Tambahkan icon untuk menu di sini
                $menuStructure[$menu->header_name]['menus'][$menu->menu_name] = [
                    'icon' => $menu->menu_icon, // Ikon untuk menu
                    'url' => $menu->menu_url, // Ikon untuk menu
                    'menu_id' => $menu->menu_id, // Ikon untuk menu
                    'created_at' => $menu->menus_created_at, // Tambahkan created_at
                    'updated_at' => $menu->menus_updated_at, // Tambahkan updated_at
                    'sub_menus' => [], // Menyimpan sub-menus
                ];
            }
            // Tambahkan sub-menu
            $menuStructure[$menu->header_name]['menus'][$menu->menu_name][] = [
                'sub_menu_id' => $menu->sub_menu_id,
                'name' => $menu->sub_menu_name,
                'url' => $menu->sub_menu_url,
                'created_at' => $menu->sub_menus_created_at, // Tambahkan created_at
                'updated_at' => $menu->sub_menus_updated_at, // Tambahkan updated_at
            ];
        }
        // return dd($menuStructure);
        $subMenuData = [];
        foreach ($menus as $menu) {
            $subMenuData[] = [
                'sub_menu_id' => $menu->sub_menu_id,
                'sub_menu_name' => $menu->sub_menu_name,
                'menu_id' => $menu->menu_id,
                'menu_name' => $menu->menu_name,
                'header_id' => $menu->header_id,
                'header_name' => $menu->header_name,
                'sub_menu_icon' => $menu->sub_menu_icon,
                'sub_menu_url' => $menu->sub_menu_url,
                'created_at' => $menu->sub_menus_created_at,
                'updated_at' => $menu->sub_menus_updated_at,
            ];
        }
        $listlink = [];
        foreach ($menus as $menu) {
            $listlink[] = [
                $menu->sub_menu_url,
            ];
        }
        // return dd($listlink);
        return [
            'menus' => $menuStructure,
            'subMenus' => $subMenuData,
            'accesslist' => $listlink,
            'profile' => $usercek
        ];
    }
}
