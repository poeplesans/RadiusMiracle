<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Header;
use App\Models\SubMenu;
use App\Models\RoleSubMenu;
use App\Imports\LinesImport;
use Illuminate\Http\Request;
use App\Exports\CombinedExport;
use App\Helpers\DatabaseHelper;
use App\Imports\CombinedImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class ExportController extends Controller
{
    public function index()
    {
        return view('importmenu');
    }
    public function pushmenu()
    {
        Artisan::call('db:seed', [
            '--class' => 'ImportMenuSeeder',
        ]);
    }

    // Export dengan Multiple Sheets
    public function exportCombined()
    {
        return Excel::download(new CombinedExport, 'menu.xlsx');
    }

    public function import(Request $request)
    {
        // Validasi file Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        // Proses import
        $file = $request->file('file');
        $data = Excel::toArray(new LinesImport, $file);
        DatabaseHelper::setDynamicConnection();
        // Hapus semua entri dari role_sub_menu
        DB::table('role_sub_menu')->delete();

        // Hapus semua entri dari sub_menus
        DB::table('sub_menus')->delete();

        // Hapus semua entri dari menus
        DB::table('menus')->delete();

        // Hapus semua entri dari headers
        DB::table('headers')->delete();

        DB::commit(); // Jika semua operasi berhasil
        foreach ($data as $key => $value) {
            if ($key == 0) {
                // Lewatkan header row pertama
                foreach ($value as $row) {
                    Header::create([
                        // 'id'   => $row[0],
                        'name' => $row[1],
                    ]);
                    // dd($row[0]);
                }
            }
            if ($key == 1) {
                foreach ($value as $row) {
                    $header = Header::where('name', $row[1])->first();
                    Menu::create([
                        // 'id'        => $row[0],
                        'header_id' => $header->id, // Foreign key yang sesuai
                        'name'      => $row[2],
                        'icon'      => $row[3],
                    ]);
                    // dd($row[0]);
                }
            }
            if ($key == 2) {
                foreach ($value as $row) {
                    // dd($row);
                    $menu = Menu::where('name', $row[1])->first();
                    SubMenu::create([
                        // 'id'      => $row[0],
                        'menu_id' => $menu->id, // Foreign key yang sesuai
                        'name'    => $row[2],
                        'url'     => $row[3],
                    ]);
                    
                }
            }
        }
    }
}
