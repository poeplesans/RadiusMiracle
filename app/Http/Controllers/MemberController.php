<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Role;
use App\Models\User;
use App\Helpers\MenuHelper;
use App\Models\RoleSubMenu;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function apiUsersGet()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return '';
            }
            $user['password'] = "";

            // Ambil semua data pengguna
            // Set dynamic connection
            DatabaseHelper::setDynamicConnection();

            // Mengambil semua data user
            $users = User::with('role_id')->get();
            

            // Format data untuk respons
            return response()->json([
                'status' => 'success',
                'data' => $users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'nip' => $user->nip,
                        'full_name' => $user->full_name,
                        'email' => $user->email,
                        'username' => $user->username,
                        'telegram_id' => $user->telegram_id, // Pastikan ada kolom telegram_id di tabel User
                        'access_bot' => $user->access_bot, // Pastikan ada kolom access_bot di tabel User
                        'status' => $user->status,
                        'role' => $user->role ? $user->role_id->name : null, // Mengambil nama role
                        'role_id' => $user->role_id->id,
                    ];
                }),
            ]);
        } catch (\Exception $e) {
            // Handle error dan log pesan errornya
            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error'
            ], 500);
        }
    }

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
        return view('content.management.member', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'roles' => $roles,

        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function roleadd(Request $request)
    {
        DatabaseHelper::setDynamicConnection();
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'sub_menus' => 'array', // memastikan sub_menus harus array
        ]);

        $roleName = $request->input('name');
        // Ambil sub menu ID yang dicentang
        $subMenus = $request->input('sub_menus');

        $role = new Role();
        $role->name = $roleName;
        $role->save();

        // Ambil ID role yang baru disimpan
        $roleId = $role->id;

        // 2. Masukkan sub_menu_id yang dipilih ke dalam tabel 'role_sub_menus'
        if ($subMenus && is_array($subMenus)) {
            foreach ($subMenus as $subMenuId) {
                DB::table('role_sub_menu')->insert([
                    'role_id' => $roleId,
                    'sub_menu_id' => $subMenuId
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Submenu added successfully!',
            'redirect' => '/members' // URL untuk pengalihan
        ]);
    }

    public function roleedit(Request $request)
    {
        DatabaseHelper::setDynamicConnection();
        // Validasi input
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'sub_menus' => 'nullable|array',
            'sub_menus.*' => 'exists:sub_menus,id',
        ]);

        // Ambil data dari request
        $roleId = $request->input('role_id');
        $roleName = $request->input('name');
        $subMenus = $request->input('sub_menus', []);

        // Temukan role berdasarkan ID
        $role = Role::findOrFail($roleId);

        // Perbarui nama role
        $role->name = $roleName;
        $role->save();

        // Hapus semua submenu yang terkait dengan role ini
        RoleSubMenu::where('role_id', $roleId)->delete();

        // Tambahkan submenu yang baru
        foreach ($subMenus as $subMenuId) {
            RoleSubMenu::create([
                'role_id' => $roleId,
                'sub_menu_id' => $subMenuId,
            ]);
        }

        // Mengembalikan response JSON untuk ditangani di frontend
        return redirect()->back()->with('success', 'User updated successfully');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function roledelete(Request $request, $roleId)
    {
        $newRoleId = $request->new_role_id;

        DatabaseHelper::setDynamicConnection();
        if (!$newRoleId) {
            Role::destroy($roleId);
            return response()->json(['status' => 'success', 'message' => 'Role successfully moved and deleted.']);
        }
        // Ambil role lama
        $oldRole = Role::find($roleId);

        if ($oldRole) {
            // Validasi bahwa role baru ada di database
            $newRole = Role::find($newRoleId);

            if (!$newRole) {
                return response()->json(['status' => 'error', 'message' => 'New role not found.'], 404);
            }

            // Pindahkan semua user ke role baru
            DB::transaction(function () use ($roleId, $newRoleId) {
                User::where('role', $roleId)->update(['role' => $newRoleId]);

                // Hapus role lama
                Role::destroy($roleId);
            });

            return response()->json(['status' => 'success', 'message' => 'Role and users successfully moved and deleted.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Role not found.'], 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $user = Auth::user();
        if (!$user) {
            return '';
        }
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'telegram_id' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|max:255',
            // 'access_bot' => 'string|max:255',
            'role' => 'required|string|max:255',
        ], [
            // Custom error messages (opsional)
            'full_name.required' => 'The full_name name is required.',
            'username.required' => 'The username is required.',
            'nip.required' => 'The nip is required.',
            'telegram_id.required' => 'The telegram_id is required.',
            'email.required' => 'The email is required.',
            'password.required' => 'The password is required.',
            // 'access_bot.required' => 'The access_bot is required.',
            'role.required' => 'The role is required.',
        ]);

        if (!$validatedData) {
            return response()->json([
                'status' => 'error',
                'message' => 'error!',
                'redirect' => '/members' // URL untuk pengalihan
            ]);
        }


        User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'office_id' => $user['office_id'],
            'password' => bcrypt($validatedData['password']),
            'user_type' => 'member'
        ]);

        DatabaseHelper::setDynamicConnection();
        // return $validatedData;


        // Ambil data dari request
        // $data = $request->only(['name', 'url', 'menu_id']);

        User::create([
            'full_name' => $validatedData['full_name'],
            'username' => $validatedData['username'],
            'nip' => $validatedData['nip'],
            'telegram_id' => $validatedData['telegram_id'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash password
            'role' => $validatedData['role'],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Submenu added successfully!',
            'redirect' => '/members' // URL untuk pengalihan
        ]);
    }

    public function usersedit(Request $request)
    {
        // return $request;
        DatabaseHelper::setDynamicConnection();
        $user = User::find($request->input('id'));

        // Update data pengguna
        $user->nip = $request->input('nip');
        $user->full_name = $request->input('full_name');
        $user->username = $request->input('username');
        $user->telegram_id = $request->input('telegram_id');
        $user->email = $request->input('email');
        $user->access_bot = $request->input('access_bot');
        $user->status = $request->input('status');
        $user->role = $request->input('role');

        // Update password jika diberikan
        if ($request->input('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }
    public function usersdelete($email)
    {
        $mainuser = User::where('email', $email)->first();

        if (!$mainuser) {
            DatabaseHelper::setDynamicConnection();
            $user = User::where('email', $email)->first();

            if (!$user) {
                // return $id;
                return response()->json(['status' => 'error', 'message' => 'New role not found.'], 404);
            }

            User::destroy($user->id);
            return response()->json(['status' => 'success', 'message' => 'Role successfully moved and deleted.']);
        }

        User::destroy($mainuser->id);

        DatabaseHelper::setDynamicConnection();
        $user = User::where('email', $email)->first();

        if (!$user) {
            // return $id;
            return response()->json(['status' => 'error', 'message' => 'New role not found.'], 404);
        }

        User::destroy($user->id);
        return response()->json(['status' => 'success', 'message' => 'Role successfully moved and deleted.']);
    }
}
