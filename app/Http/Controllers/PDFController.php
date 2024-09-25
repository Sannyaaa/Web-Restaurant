<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
// use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;


class PDFController extends Controller
{
    //

    public function generateOrder($id)
    {
        $order = Order::find($id);
        $logo = public_path('assets/img/connya.jpg');
        $products = OrderItem::with('modifiers')->where('order_id', $id)->get();

        $pdf = PDF::loadView('dashboard.order.pdf', [
                'order' => $order,
                'logo' => $logo,
                'products' => $products
        ]);

        return $pdf->download('order_'. $id. '.pdf');

        // return view('dashboard.order.pdf', [
        //     'order' => $order,
        //     'logo' => $logo,
        //     'products' => $products
        // ]);

        // return Pdf::view('dashboard.order.pdf', [
        //     'order' => $order,
        //     'logo' => $logo,
        //     'products' => $products
        // ])
        // ->timeout(60000)
        // ->download('invoice.pdf');

        // Browsershot::url('')
        //     ->timeout(60000) // Timeout dalam milidetik
        //     ->save('example.pdf');
    }

    public function generateKitchen($id)
    {
        $order = Order::find($id);
        $logo = public_path('assets/img/connya.jpg');
        $products = OrderItem::with('modifiers')->where('order_id', $id)->get();

        $pdf = PDF::loadView('dashboard.kitchen.pdf', [
                'order' => $order,
                'logo' => $logo,
                'products' => $products
        ]);

        return $pdf->download('kitchen_'. $id. '.pdf');
    }
}
