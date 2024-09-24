<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\User;
use App\Models\Header;
use App\Models\SubMenu;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    private function auth()
    {
        $user = Auth::user();
        if (!$user) {
            return '';
        }
        DatabaseHelper::setDynamicConnection();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        $usercek->makeHidden(['password']);

        return $usercek;
    }
    public function home(Request $request)
    {
        // return dd($request);
        // return dd($request->server('HTTP_SEC_CH_UA_PLATFORM'));
        $user = Auth::user();
        if (!$user) {
            return '';
        }
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];
        $usercek = $arraymenus['profile'];
        
        // DatabaseHelper::setDynamicConnection();
        // return $usercek;

        // $usercek = User::where('email', $user->email)->with('role_id')->first();
        // $usercek->makeHidden(['password']);

        return view('content.dashboard', ['menuArray' => $menus, 'usercek' => $usercek,]);
    }

    public function show(Request $request)
    {
        return dd($request);
    }

    // View Header & Menu
    public function headermenu()
    {
        $usercek = $this->auth();
        $arraymenus = MenuHelper::getDynamicMenu();
        // return dd($arraymenus);

        $menus = $arraymenus['menus'];
        $subMenus = $arraymenus['subMenus'];
        // return $usercek;

        return view('content.management.header-menu', ['menuArray' => $menus, 'subMenuData' => $subMenus, 'usercek' => $usercek,]);
    }

    // ============================== //
    // = Header Controller Handler == //
    // ============================== //

    public function headeradd(Request $request)
    {
        // Validation
        $request->validate([
            'modalPermissionName' => 'required|string|max:255',
        ]);

        try {
            DatabaseHelper::setDynamicConnection();
            // Create the header
            Header::create([
                'name' => $request->modalPermissionName
            ]);

            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Header created successfully!'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create header!'
            ]);
        }
    }
    public function headeredit(Request $request)
    {
        // return $request;
        DatabaseHelper::setDynamicConnection();
        $request->validate([
            'id' => 'required|exists:headers,id',
            'name' => 'required|string|max:255',
        ]);

        // Cari sub-menu berdasarkan ID
        $subMenu = Header::findOrFail($request->input('id'));


        // Update data sub-menu
        $subMenu->name = $request->input('name');

        // Simpan perubahan
        $subMenu->save();

        // Redirect atau response dengan pesan sukses
        return redirect('/header-menu')->with('success', 'Sub Menu updated successfully!');
    }
    public function headerdelete($id)
    {
        DatabaseHelper::setDynamicConnection();
        $Menu = Header::find($id);
        if (!$Menu) {
            // return $id;
            return response()->json(['status' => 'error', 'message' => 'New role not found.'], 401);
        }
        Header::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Role successfully moved and deleted.']);
    }

    // ============================== //
    // === Menu Controller Handler == //
    // ============================== //

    public function menuadd(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            // 'url' => 'required',
            'header_id' => 'required',
        ], [
            // Custom error messages (opsional)
            'name.required' => 'The menu name is required.',
            'icon.required' => 'The icon is required.',
            // 'url.required' => 'The URL is required.',
            'header_id.required' => 'The Header is required.',
        ]);

        // Set koneksi database dinamis sebelum menyimpan data
        DatabaseHelper::setDynamicConnection();

        // Ambil data dari request
        $data = $request->only(['name', 'icon', 'header_id']);

        // Menyimpan data ke database
        Menu::create($data);

        // return $data;
        return response()->json([
            'status' => 'success',
            'message' => 'Submenu added successfully!',
            'redirect' => '/role-menu' // URL untuk pengalihan
        ]);
    }
    public function menuedit(Request $request)
    {
        // return $request;
        DatabaseHelper::setDynamicConnection();
        // $request->validate([
        //     'id' => 'required|exists:sub_menus,id',
        //     'name' => 'required|string|max:255',
        //     'header_id' => 'required|exists:headers,id',
        //     'icon' => 'required|string|max:255'
        // ]);

        // Cari sub-menu berdasarkan ID
        $subMenu = Menu::find($request->input('id'));
        if (!$subMenu) {
            // return $id;
            return response()->json(['status' => 'error', 'message' => 'New role not found.'], 401);
        }
        // Update data sub-menu
        $subMenu->name = $request->input('name');
        $subMenu->header_id = $request->input('header_id');
        $subMenu->icon = $request->input('icon');

        // Simpan perubahan
        $subMenu->save();

        // Redirect atau response dengan pesan sukses
        return redirect('/header-menu')->with('success', 'Sub Menu updated successfully!');
    }
    public function menudelete($id)
    {
        DatabaseHelper::setDynamicConnection();
        $Menu = Menu::find($id);
        if (!$Menu) {
            // return $id;
            return response()->json(['status' => 'error', 'message' => 'New role not found.'], 401);
        }
        Menu::destroy($id);

        return response()->json(['status' => 'success', 'message' => 'Role successfully moved and deleted.']);
    }
}
