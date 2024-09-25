<?php

namespace App\Http\Controllers;

use App\Fonnte;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Payment;
use Midtrans\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use Fonnte;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function return(Request $request)
    {
        $sid = $request['sid'];
        $status = $request['status'];
        // dd($request);
        $order = Order::where('resi', $sid)->first();

        if ($status == 'berhasil') {

            $orderItems = DB::table('order_items')
                ->join('menus', 'order_items.menu_id', '=', 'menus.id')
                ->where('order_items.order_id', $order->id)
                ->select('menus.name', 'order_items.quantity', 'order_items.total_price', 'menus.price')
                ->get();

            if($order->payment_method == 'ipaymu'){
                
                $order->update([
                    'status' => 'being_prepared',
                    'payment_status' => 'paid',
                ]);

                // Kirim pesan ke user
                $message = "*Pembayaran berhasil, Pesanan anda akan segera kami buat.*";
                $this->send_message($order->phone, $message);

            }else{

                $order->update([
                    'status' => 'being_prepared',
                ]);

                $message = "Terima kasih telah memesan.\n\n";
                $message .="Invoice Order : *{$order->invoice}*\n\n";
                $message .="Berikut adalah detail pesanannya:\n";
                foreach ($orderItems as $item) {
                    $message .= "- {$item->name} x {$item->quantity} - Rp " . number_format($item->total_price, 0, ',', '.') . "\n";
                }
                $message .= "\n*Total Harga: Rp " . number_format($order->total_price, 0, ',', '.') ."*";

                $this->send_message($order->phone, $message);
            }
            
        }

        return view('frontend.callback.return', [
            'data' => $order,
        ]);
    }

    public function notify(Request $request)
    {
        Log::info('Notify webhook called', $request->all());

        // Validasi data request
        $validated = $request->validate([
            'sid' => 'required',
            'trx_id' => 'required',
            'status' => 'required',
            'reference_id' => 'required',
        ]);

        Log::info('Validated data', $validated);

        // Ambil data dari request
        $sid = $validated['sid'];
        $status = $validated['status'];

        // Cari order berdasarkan invoice
        $order = Order::where('resi', $sid)->first();

        // Periksa apakah order ditemukan
        if (!$order) {
            Log::error('Order not found for invoice: ' . $sid);
            return response()->json(['message' => 'Order tidak ditemukan'], 404);
        }

        Log::info('Order found', $order->toArray());

        // Cek apakah order sudah dibayar
        if ($order->payment_status == 'paid') {
            Log::info('Order already paid', ['invoice' => $sid]);
            return response()->json(['message' => 'Transaksi sudah berhasil'], 200);
        }

        // Update status order berdasarkan status pembayaran
        if ($status == 'berhasil') {
            try {
                $order->update([
                    'status' => 'in_process',
                    'payment_status' => 'paid',
                ]);

                Log::info('Order status updated', $order->toArray());

                // Kirim pesan ke user
                $message = "Pembayaran berhasil, Pesanan anda akan segera kami buat.";
                $this->send_message($order->user->phone, $message);

                return response()->json(['message' => 'Transaksi berhasil dan order diperbarui'], 200);
            } catch (\Exception $e) {
                // Log error jika terjadi kesalahan
                Log::error('Error updating order: ' . $e->getMessage());
                return response()->json(['message' => 'Gagal memperbarui order'], 500);
            }
        }

        Log::info('Transaction failed', ['status' => $status]);
        return response()->json(['message' => 'Transaksi gagal'], 400);
    }

    public function cancel()
    {
        return view('frontend.callback.cancel', [
            // 'data' => $data,
        ]);
    }

    public function notificationHandler(Request $request)
    {
        Config::$serverKey = "SB-Mid-server-gxLxA1hDHvuyfmoJmogg34N0";
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        Config::$isProduction = false;
        // Set sanitization on (default)
        Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        Config::$is3ds = true;

        $notification = $request->all();

        Log::info('Midtrans Notification:', $notification);

        $status = $notification['transaction_status'];
        $type = $notification['payment_type'];
        $fraud = $notification['fraud_status'];
        $order_id = $notification['order_id'];

        $order = Order::where('invoice',$order_id);
        // dd($order);
            // Handle notification status
        
        if($notification != null){
            if ($status == 'capture' || $status == 'settlement') {
                $order->update(['status' => 'being_prepared', 'payment_status' => 'paid']);
            } else if ($status == 'pending') {
                $order->update(['status' => 'awaiting_payment', 'payment_status' => 'pending']);
            } else if ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
                $order->update(['status' => 'awaiting_payment', 'payment_status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification received and handled']);
        }

        // Jika verifikasi gagal
        Log::warning('Invalid notification for order_id: ' . $notification['order_id']);
        return response()->json(['message' => 'Invalid notification'], 400);
    }

    public function midtrans_return()
    {

        return view('frontend.callback.return');
    }
}
