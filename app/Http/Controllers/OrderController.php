<?php

namespace App\Http\Controllers;

use App\Fonnte;
use App\Ipaymu;
use App\Midtrans;
use Carbon\Carbon;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use App\Models\ModifierItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Spatie\SimpleExcel\SimpleExcelReader;
use Spatie\SimpleExcel\SimpleExcelWriter;

class OrderController extends Controller
{
    use Ipaymu;
    use Midtrans;
    use Fonnte;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // dd($request->status);
        // if ($request->filled('status')) {
        //     $query->where('status', $request->status);
        // }

        // if ($request->filled('payment_method')) {
        //     $query->where('payment_method', $request->payment_method);
        // }

        // if ($request->filled('payment_status')) {
        //     $query->where('payment_status', $request->payment_status);
        // }

        // if ($request->filled('search')) {
        //     $query->where('invoice', 'like', '%' . $request->search . '%')
        //             ->orWhere('total_price', 'like', '%' . $request->search . '%')
        //             ->orWhere('phone', 'like', '%' . $request->search . '%')
        //             ->orWhere('name', 'like', '%' . $request->search . '%');
        // }

            // dd($query);

        if(request()->ajax()){

            $user = auth()->user();
            
            if ($user->role == 'admin' || $user->role == 'service') {
                $query = Order::query();
            } else {
                $query = Order::query()->where('phone', $user->phone);
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($order){
                    if(auth()->user()->can('orderAccess')) {
                        return '<input type="checkbox" name="selected_orders[]" value="'.$order->id.'">';
                    }else{
                        return '-';
                    }
                })
                ->addColumn('action', function($order){
                    $pdfRoute = route('order.invoice',$order->id);
                    // $editRoute = route('order.edit', $order->id);
                    $showRoute = route('order.show', $order->id);
                    $deleteRoute = route('order.destroy', $order->id);
                    $printRoute = route('print.order', $order->id);
                    
                    $actions = '';
                    if(auth()->user()->can('isCashier')) {
                        
                        $actions .= '<a href="'.$printRoute.'" target="_blank" class="font-lg text-slate-600 dark:text-slate-500 hover:underline px-2 my-3 inline-block">Cetak</a>';
                        $actions .= '<a href="'.$pdfRoute.'" class="font-lg text-slate-600 dark:text-slate-500 hover:underline px-2 my-3 inline-block">Download</a>';
                        // $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2 my-3 inline-block">Edit</a>';
                    }
                    $actions .= '<a href="'.$showRoute.'" class="font-lg text-blue-600 dark:text-blue-500 hover:underline px-2 my-3 inline-block">Show</a>';
                    if(auth()->user()->can('orderAccess')) {
                        $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                        <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 my-3 inline-block">Hapus</button>
                                    </form>';
                    }
                    return '
                    <div class="flex">
                        '.$actions.'
                    </div>';
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->editColumn('total_price', function($order) {
                    return "Rp. " . number_format($order->total_price) ;
                })
                ->editColumn('status', function($order) {
                    $class = '';

                    switch ($order->status) {
                            case 'awaiting_payment':
                                $class = 'bg-yellow-100 text-yellow-700';
                                break;
                            case 'being_prepared':
                                $class = 'bg-gray-100 text-gray-700';
                                break;
                            case 'out_for_delivery':
                                $class = 'bg-blue-100 text-blue-700';
                                break;
                            case 'delivered':
                                $class = 'bg-green-100 text-green-700';
                                break;
                            default:
                                $class = 'bg-gray-100 text-gray-700';
                                break;
                        }

                    if(auth()->user()->can('isService')) {

                        $statuses = [
                            // 'awaiting_payment' => 'Menunggu Pembayaran',
                            'being_prepared' => 'Sedang Dibuat',
                            'out_for_delivery' => 'Sedang Diantar',
                            'delivered' => 'Sudah Disajikan',
                        ];

                        $options = '';
                        foreach ($statuses as $key => $value) {
                            $selected = $order->status === $key ? 'selected' : '';
                            $options .= "<option value='{$key}' {$selected}>{$value}</option>";
                        }
                        
                        return "<select class='status-dropdown py-2 px-4 my-2 rounded-lg w-fit {$class}' data-id='{$order->id}'>
                                    {$options}
                                </select>";
                    }else {
                        return  "<span class='py-2 px-4 my-2 rounded-lg w-fit {$class}'>" . ucfirst($order->status) . "</span>";;
                    }
                })
                ->editColumn('payment_status', function($order) {
                    $class = '';

                    switch ($order->payment_status) {
                        case 'pending':
                            $class = 'bg-yellow-100 text-yellow-700';
                            break;
                        case 'paid':
                            $class = 'bg-green-100 text-green-700';
                            break;
                        case 'cancelled':
                            $class = 'bg-rose-100 text-rose-700';
                            break;
                        default:
                            $class = 'bg-gray-100 text-gray-700';
                            break;
                    }

                    if(auth()->user()->can('isCashier')) {
                    
                        $paymentStatuses = [
                            'cancelled' => 'Dibatalkan',
                            'pending' => 'Pending',
                            'paid' => 'Dibayar',
                        ];

                        $options = '';
                        foreach ($paymentStatuses as $key => $value) {
                            $selected = $order->payment_status === $key ? 'selected' : '';
                            $options .= "<option value='{$key}' {$selected}>{$value}</option>";
                        }
                        
                        return "<select class='payment-status-dropdown py-2 px-4 my-2 rounded-lg w-fit {$class}' data-id='{$order->id}'>
                                    {$options}
                                </select>";

                    }else {
                        return "<span class='py-2 px-4 my-2 rounded-lg w-fit {$class}'>" . ucfirst($order->payment_status) . "</span>";;
                    }
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }

                    if ($request->filled('payment_method')) {
                        $query->where('payment_method', $request->payment_method);
                    }

                    if ($request->filled('payment_status')) {
                        $query->where('payment_status', $request->payment_status);
                    }

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('invoice', 'like', "%{$searchValue}%")
                                    ->orWhere('total_price', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action', 'created_at','total_price','status','payment_status','payment_method'])
                ->make(true);
        }

        return view('dashboard.order.index');
    }

    public function bulkAction(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':
                    Order::whereIn('id', $selectedOrders)->delete();
                    return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
                case 'edit':
                    $status = $request->input('bulk_action_status');
                    $paymentStatus = $request->input('bulk_action_payment_status');

                    if ($status || $paymentStatus) {
                        $orders = Order::whereIn('id', $selectedOrders);

                        if ($status) {
                            $orders->update(['status' => $status]);

                            if($status == 'delivered'){
                                $message = "*Selamat menikmati hidangan kami, jangan lupa berikan rating yang terbaik*";

                                foreach($orders as $order){
                                    $this->send_message($order->phone, $message);
                                }
                            }
                        }

                        if ($paymentStatus) {
                            $orders->update(['payment_status' => $paymentStatus]);
                        }

                        return redirect()->back()->with('success', 'Selected orders updated successfully.');
                    }
                    break;

                default:
                    return redirect()->back()->with('error', 'No valid action selected.');
            }
        }

        return redirect()->back()->with('error', 'No orders selected.');
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
    public function show(Order $order)
    {
        $this->authorize('view',$order);

        $orderItems = OrderItem::with('modifiers')->where('order_id', $order->id)->get();

        // Loop through each order item to calculate total modifier price
        foreach($orderItems as $item){
            $totalModifierPrice = 0;
            foreach($item->modifiers as $modifier){
                $totalModifierPrice += $modifier->price * $modifier->quantity;
            }
            // Optional: Add this total to the item for later use
            $item->total_modifier_price = $totalModifierPrice;
        }

        return view('dashboard.order.show', compact('order', 'orderItems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //

        $this->authorize('update',$order);

        return view('dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Order $order)
    // {
        
    //     $this->authorize('update',$order);

    //     $order->update([
    //         'status' => $request->status,
    //         'payment_status' => $request->payment_status
    //     ]);

    //     $orderItems = DB::table('order_items')
    //         ->join('menus', 'order_items.menu_id', '=', 'menus.id')
    //         ->where('order_items.order_id', $order->id)
    //         ->select('menus.name', 'order_items.quantity', 'menus.price')
    //         ->get();

    //     if($order->status == 'delivered'){

    //         $message = '*selamat menikmati hidangan kami, jangan lupa berikan rating yang terbaik*';

    //     }elseif($order->status == 'being_prepared'){

    //         $message = "Terima kasih telah memesan.\n\n";
    //         $message .="Invoice Order : *{$order->invoice}*\n\n";
    //         $message .="Berikut adalah detail pesanan Anda:\n\n";
    //         foreach ($orderItems as $item) {
            
    //             $message .= "{$item->name} x{$item->quantity} - Rp " . number_format($item->total_price, 0, ',', '.') . "\n";
            
    //         }

    //         $message .= "\nTotal Harga: Rp " . number_format($order->total_price, 0, ',', '.');
        
    //     }

    //     $this->send_message($order->phone, $message);

    //     return redirect()->route('order.index')->with('success', 'Order updated successfully');
        
    // }

    public function orderUpdate(Request $request)
    {

        $order = Order::find($request->id);

        $orderItems = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->where('order_items.order_id', $order->id)
            ->select('menus.name', 'order_items.quantity', 'menus.price')
            ->get();

        if ($order) {

            if ($request->status) {
                $data = ['status' => $request->status];

                if ($request->status == 'delivered') {
                    $data['waiter'] = Auth::user()->name;
                    $message = "*Selamat menikmati hidangan kami, jangan lupa berikan rating yang terbaik*";
                }

                $order->update($data);

                $this->send_message($order->phone, $message);
                // elseif($order->status == 'being_prepared'){

                //     $message = "Terima kasih telah memesan.\n\n";
                //     $message .="Invoice Order : *{$order->invoice}*\n\n";
                //     $message .="Berikut adalah detail pesanan Anda:\n\n";
                //     foreach ($orderItems as $item) {
                    
                //         $message .= "{$item->name} x{$item->quantity} - Rp " . number_format($item->total_price, 0, ',', '.') . "\n";
                    
                //     }

                //     $message .= "\nTotal Harga: Rp " . number_format($order->total_price, 0, ',', '.');
                
                // }
            }

            if ($request->paymentStatus) {
                $data = ['payment_status' => $request->paymentStatus];

                if($request->paymentStatus == 'paid'){
                    $data['cashier'] = Auth::user()->name;
                }

                $order->update($data);
            }

            $order->save();

            session()->flash('success', 'Update status berhasil');
            
            return response()->json([
                'success' => true,
                'message' => 'Update status berhasil'
            ]);
        }

        return response()->json(['success' => false], 400);

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Order $order)
    {
        //
        $this->authorize('delete',$order);

        $order->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully');
    }

    public function checkout(Request $request){
        
        $data = $request->validate([
            'name' => 'string|required',
            'phone' => 'numeric|required',
            'table_id' => 'required|exists:tables,id',
            'total_price' => 'required|numeric',
            'payment_method' => 'required|in:cash,ipaymu,midtrans',
        ],);

        // dd($data);

        $data['invoice'] = 'CONNYA-'.rand(000000, 999999);

        $user = Auth::user();

        if($data['payment_method'] == 'ipaymu'){
            $payment = json_decode
            (
                json_encode(
                    $this->redirect_payment(
                        $data
                    )
                ), true);
            // dd($payment);
            $order = Order::create([
                // dd($data['table_id']),
                'user_id' => Auth::check() ? Auth::id() : null,
                'invoice' => $data['invoice'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'resi' => $payment['Data']['SessionID'],
                'table_id' => $data['table_id'],
                'total_price' => $data['total_price'],
                'status' => 'awaiting_payment',
                'payment_url' => $payment['Data']['Url'],
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
                    'total_price' => $value['price'] * $value['quantity'],
                    'special_instructions' => $value['instructions'],
                ]);
            }

            session()->forget('cart');

            return redirect($order->payment_url);

        }elseif($data['payment_method'] == 'midtrans'){

            $paymentUrl = $this->midtransTransaction($data);

            if ($paymentUrl) {
                return redirect()->away($paymentUrl);
            } else {
                return back()->with('error', 'Failed to process payment.');
            }

        }else{
            $uuid = Str::uuid()->toString();

            $order = Order::create([
                // dd($data['table_id']),
                'user_id' => Auth::check() ? Auth::id() : null,
                'invoice' => $data['invoice'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'resi' => $uuid,
                'table_id' => $data['table_id'],
                'total_price' => $data['total_price'],
                'status' => 'awaiting_payment',
                'payment_url' => null,
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
                    'total_price' => $value['price'] * $value['quantity'],
                    'special_instructions' => $value['instructions'],
                ]);

                // Memproses modifier yang dipilih untuk item ini
                if (isset($value['modifiers']) && isset($value['selected_modifiers'])) {

                    $total_price_modifier = 0;

                    foreach($value['selected_modifiers'] as $modifier) {
                        // Ambil data modifier berdasarkan id
                        $modifierId = $modifier->id;
                        $modifierName = $modifier->name;
                        $modifierQuantity = $value['modifier_quantities'][$modifierId];
                        $modifierPrice = $modifier->price;

                        // Simpan data modifier ke dalam tabel OrderItemModifier atau tabel yang relevan
                        $modifierItem = ModifierItem::create([
                            'order_item_id' => $orderItem->id,
                            'modifier_id' => $modifierId,
                            'name' => $modifierName,
                            'quantity' => $modifierQuantity,
                            'price' => $modifierPrice,
                        ]);

                        $total_price_modifier += $modifierItem['quantity'] * $modifierItem['price'];
                    }

                    $orderItem->update([
                        'total_price' => $orderItem['price'] + $total_price_modifier,
                    ]);

                }

            }

            session()->forget('cart');

            $status = 'berhasil';

            // dd($order->resi);

            return redirect()->route('callback.return',[
                'status' => $status,
                'sid' => $order->resi,
            ]);
        }

        // dd($order);

        // Menghapus data keranjang dari session
    }

    public function reorder(Request $request){
        $data = $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($data['order_id']);

        $this->authorize('restore',$order);

        $orderItem = OrderItem::where('order_id',$data['order_id'])->get();

        // dd($orderItem);

        foreach ($orderItem as $key => $value) {

            $data['menu_id'] = $value->menu_id;

            // dd($menu);
            // Data item yang akan disimpan di session
            $cartItem = [
                'id' => $value->menu->id,
                'name' => $value->menu->name,
                'image' => $value->menu->image,
                'description' => $value->menu->description,
                'category' => $value->menu->category->name,
                'price' => $value->menu->price,
                'modifiers' => [], // Simpan modifier yang dipilih
                'quantity' => $value->quantity,
                'instructions' => $value->special_instructions,
            ];

            // Ambil data keranjang dari session
            $cart = session()->get('cart', []);

            // Tambahkan item ke keranjang atau update jika sudah ada
            $cart[$data['menu_id']] = $cartItem;

            // Simpan kembali ke session
            session()->put('cart', $cart);
        }

        // $order = Order::find($data['order_id']);

        // $order->status = 'in_process';

        // $order->save();

        return redirect()->route('cart.index')->with('success','berhasil masuk keranjang, lanjutkan pembayaran');
    }

    public function kitchen()
    {
        //
        $this->authorize('isKitchen');

        $orders = Order::with('items')->where('status','being_prepared')->get();

        return view('dashboard.kitchen.index', compact('orders'));
    }

    public function kitchen_edit(Order $order)
    {
        //
        $this->authorize('isKitchen');

        $orderItems = OrderItem::with('modifiers')->where('order_id',$order->id)->get();

        return view('dashboard.kitchen.edit', compact('order','orderItems'));
    }

    public function kitchen_update(Request $request, Order $order)
    {
        //
        $this->authorize('isKitchen');

        $order->update([
           'status' =>'out_for_delivery',
           'chef' => Auth::user()->name,
        ]);

        $message = 'Pesanan sedang diantar ke meja anda';

        $this->send_message($order->phone, $message);

        return redirect()->route('kitchen')->with('success','Update status berhasil');
    }

    public function print_kitchen($id){
        $order = Order::find($id);
        $logo = public_path('assets/img/connya.jpg');
        $products = OrderItem::with('modifiers')->where('order_id', $id)->get();

        return view('dashboard.kitchen.pdf', [
                'order' => $order,
                'logo' => $logo,
                'products' => $products
        ]);

        // return $pdf->download('kitchen_'. $id. '.pdf');
    }

    // public function import(Request $request)
    // {
    //     // Validate the uploaded file
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx,xls',
    //     ]);
 
    //     // Get the uploaded file
    //     $file = $request->file('file');
 
    //     // Process the Excel file
    //     Excel::import(new YourImportClass, $file);
 
    //     return redirect()->back()->with('success', 'Excel file imported successfully!');
    // }

    public function export_order(Request $request){
        // Buat file Excel baru dengan header
        $writer = SimpleExcelWriter::streamDownload('orders.xlsx')
            ->addHeader(['ID', 'Name', 'Phone', 'Table Id', 'Total Price', 'Status', 'Invoice', 'Resi', 'Payment Method', 'Payment Status', 'Created At']);
        
        // Ambil data user dari database
        $orders = Order::query();

        // dd($orders);

        if ($request->filled('status')) {
            $orders->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $orders->where('payment_method', $request->payment_method);
        }

        if ($request->filled('payment_status')) {
            $orders->where('payment_status', $request->payment_status);
        }

        // Jalankan query untuk mengambil hasil filter
        $orders = $orders->get();

        // Tambahkan data user ke dalam file Excel
        foreach ($orders as $user) {
            $writer->addRow([
                'ID' => $user->id,
                'Name' => $user->name,
                'Phone' => $user->phone,
                'Table Id' => $user->table_id,
                'Total Price' => $user->total_price,
                'Status' => $user->status,
                'Invoice' => $user->invoice,
                'Resi' => $user->resi,
                'Payment Method' => $user->payment_method,
                'Payment Status' => $user->payment_status,
                'Created At' => $user->created_at->format('Y-m-d H:i:s')
            ]);
        }

        // Selesaikan dan kirim file ke browser
        $writer->toBrowser();
    }

    public function import_order(Request $request){
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv'
        ]);

        // // Baca file Excel yang diunggah
        // $path = $request->file('file')->getRealPath();
        // $rows = SimpleExcelReader::create($path)->getRows();

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Pindahkan file ke lokasi sementara dengan ekstensi yang benar
        $filePath = $file->storeAs('temp', $file->getClientOriginalName());

        // Baca file Excel
        $rows = SimpleExcelReader::create(storage_path('app/' . $filePath))->getRows();

        // Import setiap baris ke dalam database
        $rows->each(function(array $rowProperties) {
            Order::create([
                // 'name' => $rowProperties['Name'],
                'name' => $rowProperties['Name'],
                'phone' => $rowProperties['Phone'],
                'table_id' => $rowProperties['Table Id'],
                'total_price' => $rowProperties['Total Price'],
                'status' => $rowProperties['Status'],
                'invoice' => $rowProperties['Invoice'],
                'resi' => $rowProperties['Resi'],
                'payment_method' => $rowProperties['Payment Method'],
                'payment_status' => $rowProperties['Payment Status'],
                'created_at' => $rowProperties['Created At'],
            ]);
        });

        return redirect()->back()->with('success', 'Data berhasil diimport!');

    }

    public function print_order($id){
        $order = Order::find($id);
        $logo = public_path('assets/img/connya.jpg');
        $products = OrderItem::with('modifiers')->where('order_id', $id)->get();

        return view('dashboard.order.print', [
                'order' => $order,
                'logo' => $logo,
                'products' => $products
        ]);

        // return $pdf->download('order_'. $id. '.pdf');
    }

}
