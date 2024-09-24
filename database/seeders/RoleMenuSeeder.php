<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class RoleMenuSeeder extends Seeder
{
    public function run()
    {
        // Nama schema/database yang akan digunakan
        $dbName = Config::get('seeder.db_name');

        // Tambahkan koneksi database dinamis
        if (!config()->has('database.connections.' . $dbName)) {
            config([
                'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                    'database' => $dbName,
                ]),
            ]);
        }

        // Menggunakan koneksi ke schema users_miracle_data_techonolgy
        $connection = DB::connection($dbName);

        // Tambahkan role SuperAdmin
        $roleId = $connection->table('roles')->insertGetId([
            'name' => 'SuperAdmin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Tambahkan header menu
        $headerId = $connection->table('headers')->insertGetId([
            'name' => 'Main Navigation',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Tambahkan menu sampel
        $menuDashboardId = $connection->table('menus')->insertGetId([
            'header_id' => $headerId,
            'name' => 'Dashboard',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $menuUserId = $connection->table('menus')->insertGetId([
            'header_id' => $headerId,
            'name' => 'User Management',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Tambahkan sub-menu untuk Dashboard
        $connection->table('sub_menus')->insert([
            [
                'menu_id' => $menuDashboardId,
                'name' => 'Overview',
                'url' => '/dashboard/overview',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'menu_id' => $menuDashboardId,
                'name' => 'Analytics',
                'url' => '/dashboard/analytics',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tambahkan sub-menu untuk User Management
        $connection->table('sub_menus')->insert([
            [
                'menu_id' => $menuUserId,
                'name' => 'Users List',
                'url' => '/user/list',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'menu_id' => $menuUserId,
                'name' => 'Roles & Permissions',
                'url' => '/user/roles',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        // Tambahkan relasi role dan sub-menu untuk SuperAdmin
        $subMenuIds = $connection->table('sub_menus')->pluck('id')->toArray();
        foreach ($subMenuIds as $subMenuId) {
            $connection->table('role_sub_menu')->insert([
                'role_id' => $roleId,
                'sub_menu_id' => $subMenuId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
