<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Midtrans;
use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Helpers\DatabaseHelper;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function index()
    {
        
        // return $midtrans;


        $user = Auth::user();
        if (!$user) {
            return '';
        }

        $invoice = Invoice::where('office_id', $user->office_id)->get();
        // return dd($invoice);
        // Mengambil dynamic menu
        $arraymenus = MenuHelper::getDynamicMenu();
        $menus = $arraymenus['menus'];

        // Set dynamic connection
        $midtrans = Midtrans::where("name", "midtrans")->first();
        DatabaseHelper::setDynamicConnection();
        // Mengambil semua data user
        $users = User::with('role_id')->get();
        $usercek = User::where('email', $user->email)->with('role_id')->first();
        $usercek->makeHidden(['password']);

        return view('content.account.owner', [
            'menuArray' => $menus,
            'users' => $users,
            'usercek' => $usercek,
            'invoice' => $invoice,
            'client_key' => $midtrans->client_key,
            'url_endpoint' => $midtrans->url_endpoint
        ]);
    }
}
