<?php

namespace App;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

trait Midtrans
{
    //

    public function midtransTransaction($data){

        // Konfigurasi MIdtrans
        // Set your Merchant Server Key
        Config::$serverKey = "SB-Mid-server-gxLxA1hDHvuyfmoJmogg34N0";
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $param = [
            'transaction_details' => [
                'order_id' => $data['invoice'],
                'gross_amount' => (int) $data['total_price'],
            ],
            'customer_details' => [
                'first_name' => $data['name'],
                'phone' => $data['phone'],
            ],
            'enabled_payments' => [
                'gopay','bank_transfer'
            ],
            'vtweb' => []
        ];

        // dd(Config::$isSanitized);

        try {
            // Get Snap Payment Page URL
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($param)->redirect_url;
            $token = Snap::createTransaction($param)->token;

            // Transaction create
            $order = Order::create([
                // dd($data['table_id']),
                'user_id' => Auth::check() ? Auth::id() : null,
                'invoice' => $data['invoice'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'resi' => $token,
                'table_id' => $data['table_id'],
                'total_price' => $data['total_price'],
                'status' => 'awaiting_payment',
                'payment_url' => $paymentUrl,
                'payment_method' => $data['payment_method'],
                'payment_status' => 'pending',
            ]);

            $carts = session()->get('cart', []);

            foreach($carts as $value){

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $value['id'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'] * $value['quantity'],
                    'special_instructions' => $value['instructions'],
                ]);
            }

            session()->forget('cart');
            
            // Redirect to Snap Payment Page
            return $paymentUrl;

            // return redirect($paymentUrl);
        }catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
