<?php

namespace App\Http\Controllers;

use App\Models\Midtrans;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Helpers\DatabaseHelper;
use App\Models\Invoice;
use App\Models\Order;

class OrderController extends Controller
{
    public function callback(Request $request)
    {
        Invoice::where("invoice", $request->order_id)->update([
            "status"=> $request->transaction_status,
            "payment"=> $request->fraud_status,
        ]);
    }
    public function pay(Request $request)
    {
        $midtrans = Midtrans::where("name", "midtrans")->first();
        // DatabaseHelper::setDynamicConnection();

        // Setup konfigurasi Midtrans
        Config::$serverKey = $midtrans->server_key;
        Config::$isProduction = false; // Set to true for production
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $request->invoice, // Order ID unik
                'gross_amount' => $request->price, // Harga total
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
            ],
            'item_details' => [
                [
                    'id' => $request->item_id,
                    'price' => $request->price,
                    'quantity' => $request->qty,
                    'name' => $request->item_name
                ]
            ]
        ];

        // Buat transaksi dengan Snap Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
            // return dd($snapToken);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    
}
