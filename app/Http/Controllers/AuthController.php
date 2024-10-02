<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Office;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use App\Models\UserOffice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // return dd($request->all());
        // Validasi data input
        $request->validate([
            'username' => 'required|string|min:6|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'office_name' => 'required|string|max:255|unique:office',
            'office_name_short' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Format nama office untuk digunakan sebagai nama database
        $officeName = $request->office_name;
        $formattedName = strtolower(str_replace(' ', '_', $officeName));
        $dbName = 'users_' . $formattedName;

        // Buat Office baru di master_DB
        $office = Office::create([
            'office_name' => $request->office_name,
            'desc' => $request->desc,
            'db_name_users' => $dbName,
            'office_name_short' => $request->office_name_short,
            'address' => $request->address,
            'status' => 'active'
        ]);


        // Buat database baru jika belum ada
        DB::statement("CREATE DATABASE IF NOT EXISTS $dbName");

        // Tambahkan koneksi database secara dinamis
        config([
            'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                'database' => $dbName,
            ]),
        ]);

        // Setup tabel di database baru
        $this->setupOfficeDatabase($dbName);

        // Simpan user di master_DB
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'office_id' => $office->id,
            'password' => Hash::make($request->password),
            'user_type' => 'Creator',
        ]);

        UserOffice::create([
            'user_id' => $user->id,
            'office_id' => $office->id,
        ]);

        // // Simpan user di database office yang baru dibuat
        // DB::connection($dbName)->table('users')->insert([
        //     'username' => $request->username,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'status' => 'active',
        //     'role' => 'SuperAdmin',
        // ]);

        // Set the value in the configuration
        Config::set('seeder.db_name', $dbName);
        Artisan::call('db:seed', [
            '--class' => 'RoleMenuSeeder',
        ]);

        return redirect('/login')->with('status', 'Registration successful! Please log in.');
    }

    protected function setupOfficeDatabase($dbName)
    {
        Schema::connection($dbName)->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable();
            $table->string('full_name')->nullable();
            $table->string('username')->nullable();
            $table->string('telegram_id')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('access_bot', ['active', 'inactive'])->default('inactive');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('role')->nullable();
            $table->timestamps();
        });

        Schema::connection($dbName)->create('param', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->timestamps();
        });

        Schema::connection($dbName)->create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->boolean('all_day')->default(false);
            $table->string('calendar')->nullable(); // Misalnya untuk kategori event seperti 'Business', 'Personal', dll.
            $table->timestamps();
        });
        Schema::connection($dbName)->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::connection($dbName)->create('headers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::connection($dbName)->create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('header_id')->constrained('headers')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::connection($dbName)->create('sub_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::connection($dbName)->create('role_sub_menu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('sub_menu_id')->constrained('sub_menus')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::connection($dbName)->create('lines', function (Blueprint $table) {
            $table->increments('id'); // Auto-incrementing primary key
            $table->string('name', 255)->nullable(); // Nullable string with a length of 255
            $table->text('data')->nullable(); // Nullable text field
        });
        Schema::connection($dbName)->create('invoices', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('invoice')->unique();
            $table->string('item');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->enum('payment', ['unpaid', 'paid', 'partial']);
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->decimal('amount', 15, 2); // Decimal with precision for currency
            $table->decimal('ppn', 5, 2)->nullable(); // Nullable tax (in percent)
            $table->decimal('discount', 5, 2)->nullable(); // Nullable discount (in percent)
            $table->decimal('total', 15, 2); // Final total amount
            $table->timestamps();
        });
        Schema::connection($dbName)->create('payment_gateways', function (Blueprint $table) {
            $table->id(); // auto-increment big integer
            $table->string('name'); // Name of the payment gateway
            $table->text('url_endpoint'); // Endpoint URL for the gateway
            $table->string('merchant_id'); // Merchant ID
            $table->string('client_key'); // Client key for the gateway
            $table->string('server_key'); // Server key for the gateway
            $table->boolean('status')->default(true); // Status (active or inactive)
            $table->timestamps(); // created_at and updated_at
        });
        Schema::connection($dbName)->create('points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('line_id')->nullable();
            $table->integer('map_id')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('village', 45)->nullable();
            $table->string('county', 45)->nullable();
            $table->string('state', 45)->nullable();
            $table->string('region', 45)->nullable();
            $table->string('display_name', 255)->nullable();
            $table->timestamps(); // For created_at and updated_at
        });
    }


    public function selectlogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);



        // Coba autentikasi pengguna menggunakan email dan password
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Simpan database yang dipilih ke dalam session
            $office = Office::find($request->db);
            $dbName = $office->db_name_users;
            session(['db_connection' => $dbName]);
            if (!config()->has('database.connections.' . $dbName)) {
                config([
                    'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                        'database' => $dbName,
                    ]),
                ]);
            }
            return redirect()->intended('/');
        } else {
            // Jika gagal login, kembalikan ke form login dengan pesan error
            return redirect()->back()->withErrors(['password' => 'Password salah.']);
        }
    }

    public function login(Request $request)
    {
        // Validasi data input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Cari user di master_DB
        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['error' => 'User Tidak ada di DB Master'], 401);
        }

        if (in_array($user->user_type, ['owner', 'creator'])) {
            if (!Hash::check($request->password, $user->password)) {
                session()->flash('error', 'Failed Auth. Silakan coba lagi.');
                return redirect()->back();
            }
            if ($user->user_type == 'owner') {
                $office = UserOffice::with('office')->get();
            }
            if ($user->user_type == 'creator') {
                $office = UserOffice::where('user_id', $user->id)->with('office')->get();
            }

            // return dd($office);
            return view('layouts.auth.select', ['email' => $user->email, 'office' => $office]);
        }

        // Cek database pengguna berdasarkan office_id
        $office = Office::find($user->office_id);
        return $office;
        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }

        // Tambahkan koneksi database dinamis jika belum ada
        $dbName = $office->db_name_users;
        session(['db_connection' => $dbName]);
        if (!config()->has('database.connections.' . $dbName)) {
            config([
                'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                    'database' => $dbName,
                ]),
            ]);
        }

        // Cek password di database office
        $officeUser = DB::connection($dbName)
            ->table('users')
            ->where('email', $request->email)
            ->first();

        if (!$officeUser || !Hash::check($request->password, $officeUser->password)) {
            return response()->json(['error' => 'User password salah'], 401);
        }

        // Autentikasi pengguna
        Auth::login($user);
        // return dd($request);        // Redirect ke halaman dashboard atau halaman lain setelah login
        return redirect()->intended('/');
    }

    public function authlogin(Request $request)
    {
        // Validasi data input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Cari user di master_DB
        $user = User::where('email', $request->email)->first();

        return $user;
        if (!$user) {
            return response()->json(['error' => 'User Tidak ada di DB Master'], 401);
        }

        // Cek database pengguna berdasarkan office_id
        $office = Office::find($user->office_id);

        if (!$office) {
            return response()->json(['error' => 'Office not found'], 404);
        }

        // Tambahkan koneksi database dinamis jika belum ada
        $dbName = $office->db_name_users;
        session(['db_connection' => $dbName]);
        if (!config()->has('database.connections.' . $dbName)) {
            config([
                'database.connections.' . $dbName => array_merge(config('database.connections.mysql'), [
                    'database' => $dbName,
                ]),
            ]);
        }

        // Cek password di database office
        $officeUser = DB::connection($dbName)
            ->table('users')
            ->where('email', $request->email)
            ->first();

        if (!$officeUser || !Hash::check($request->password, $officeUser->password)) {
            return response()->json(['error' => 'User password salah'], 401);
        }

        // Autentikasi pengguna
        Auth::login($user);
        // return dd($request);        // Redirect ke halaman dashboard atau halaman lain setelah login
        return redirect()->intended('/');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }

    public function notauth(Request $request)
    {
        // return dd($request);
        $user = Auth::user();
        if (!$user) {
            return '';
        }

        // return $user['office_id'];
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];
        // $subMenus = $arraymenus['subMenus'];

        DatabaseHelper::setDynamicConnection();
        $users = User::all();
        $roles = Role::withCount('userrole')->get();

        // return $roles;
        return view('layouts.misc.notauth', ['menuArray' => $menus, 'users' => $users, 'roles' => $roles]);
    }
}
