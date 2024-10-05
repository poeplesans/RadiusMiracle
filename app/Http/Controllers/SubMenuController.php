<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SubMenu;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;

class SubMenuController extends Controller
{
    public function submenu()
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }
        // return $user;
        DatabaseHelper::setDynamicConnection();
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];
        $subMenus = $arraymenus['subMenus'];
        // Mengambil semua data user
        // $users = User::with('role_id')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        if ($usercek) {
            $usercek =  $usercek;
        } else {
            $usercek =  $user;
        }
        
        // $usercek->makeHidden(['password']);

        // dd($usercek);
        // return dd($menus);
        return view('content.management.submenu', ['menuArray' => $menus, 'subMenuData' => $subMenus,'usercek' => $usercek]);
    }

    public function submenuadd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'icon' => 'required|string|max:255',
            'url' => 'required',
            'menu_id' => 'required',
        ], [
            // Custom error messages (opsional)
            'name.required' => 'The SubMenu name is required.',
            // 'icon.required' => 'The icon is required.',
            'url.required' => 'The URL is required.',
            'menu_id.required' => 'The Menu is required.',
        ]);

        // Set koneksi database dinamis sebelum menyimpan data
        DatabaseHelper::setDynamicConnection();

        // Ambil data dari request
        $data = $request->only(['name', 'url', 'menu_id']);

        // Menyimpan data ke database
        SubMenu::create($data);

        // return $data;
        return response()->json([
            'status' => 'success',
            'message' => 'Submenu added successfully!',
            'redirect' => '/menu-nav' // URL untuk pengalihan
        ]);
    }

    public function submenuedit(Request $request)
    {
        DatabaseHelper::setDynamicConnection();
        $request->validate([
            'id' => 'required|exists:sub_menus,id',
            'name' => 'required|string|max:255',
            'menu_id' => 'required|exists:menus,id',
            'url' => 'required|string|max:255'
        ]);

        // Cari sub-menu berdasarkan ID
        $subMenu = SubMenu::findOrFail($request->input('id'));

        // Update data sub-menu
        $subMenu->name = $request->input('name');
        $subMenu->menu_id = $request->input('menu_id');
        $subMenu->url = $request->input('url');

        // Simpan perubahan
        $subMenu->save();

        // Redirect atau response dengan pesan sukses
        return redirect('/sub-menu')->with('success', 'Sub Menu updated successfully!');
    }
    
    public function submenudelete($id)
    {
        // Cari data berdasarkan ID
        try {
            DatabaseHelper::setDynamicConnection();
            $menu = SubMenu::findOrFail($id);

            // Hapus data
            $menu->delete();

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Header created successfully!'
            ]);
        } catch (\Exception $e) {

            return $e;
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create header!'
            ]);
        }
    }
}
