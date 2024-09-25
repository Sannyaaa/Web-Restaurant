<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $this->authorize('isService');

        if(request()->ajax()){

            $query = Table::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $qr_code_route = route('generate.qr_code',$item->id);
                    $editRoute = route('table.edit', $item->id);
                    $printRoute = route('print.table', $item->id);
                    $deleteRoute = route('table.destroy', $item->id);
                    
                    $actions = '';
                    $actions .= '<a href="'.$printRoute.'" class="font-lg text-slate-600 dark:text-slate-500 hover:underline px-2 my-3 inline-block">Print</a>';
                    $actions .= '<a href="'.$qr_code_route.'" class="font-lg text-slate-600 dark:text-slate-500 hover:underline px-2 my-3 inline-block">QR Code</a>';
                    
                    $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    
                        $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                        <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                    </form>';
                    return $actions;
                })
                ->editColumn('qr_code', function($item) {
                    return $item->qr_code ? '<img src="'. Storage::url($item->qr_code).'" style="max-height: 120px;" />' : '';
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->filter(function ($query) use ($request) {

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action','qr_code'])
                ->make(true);
        }

        return view('dashboard.table.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $this->authorize('isService');

        return view('dashboard.table.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $this->authorize('isService');



        $request->validate([
            'name' => 'required|unique:tables,name',
        ]);

        // Membuat URL berdasarkan nama meja
        $url = route('list-menu.table', ['name' => $request->name]);

        // Membuat QR code
        $qrCode = QrCode::format('png')->size(300)->generate($url);

        // Menyimpan QR code ke file atau sebagai string base64
        $qrCodePath = 'qrcodes/' . $request->nama_meja . '.png';
        \Storage::disk('public')->put($qrCodePath, $qrCode);

        // Menyimpan data meja beserta QR code ke database
        $meja = Table::create([
            'name' => $request->name,
            'qr_code' => $qrCodePath, // simpan path file atau base64 string
        ]);

        // $data = $request->validate([
        //     'name' =>'required|string|max:255',
        //     'qr_code' =>'required|image|mimes:png,jpg,jpeg',
        // ]);

        // if($request->hasFile('qr_code')){
        //     $data['qr_code'] = $request->file('qr_code')->store('tables','public');
        // }

        // Table::create($data);

        return redirect()->route('table.index')->with('success','Table added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Table $table)
    {
        //

        $this->authorize('isService');

        return view('dashboard.table.edit', compact('table'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Table $table)
    {
        //

        $this->authorize('isService');

        $request->validate([
            'name' => 'required|unique:tables,name',
        ]);

        // Membuat URL berdasarkan nama meja
        $url = route('list-menu.table', ['name' => $request->name]);

        // Membuat QR code
        $qrCode = QrCode::format('png')->size(300)->generate($url);

        // Menyimpan QR code ke file atau sebagai string base64
        $qrCodePath = 'qrcodes/' . $request->nama_meja . '.png';
        \Storage::disk('public')->put($qrCodePath, $qrCode);

        // Menyimpan data meja beserta QR code ke database
        $table->update([
            'name' => $request->name,
            'qr_code' => $qrCodePath, // simpan path file atau base64 string
        ]);




        // $data = $request->validate([
        //     'name' =>'required|string|max:255',
        //     'qr_code' => 'nullable|image|mimes:png,jpg,jpeg',
        // ]);

        // if($request->hasFile('qr_code')){
        //     FacadesStorage::delete($table->qr_code);
        //     $data['qr_code'] = $request->file('qr_code')->store('tables','public');
        // }

        // $table->update($data);

        return redirect()->route('table.index')->with('success','Table updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        //

        $this->authorize('isService');

        FacadesStorage::delete($table->qr_code);
        $table->delete();
        return redirect()->route('table.index')->with('success','Table deleted successfully.');
    }

    public function generate_qr_code($id){
        $table = Table::find($id);

        // $qrCode = QrCode::format('png')->size(300)->generate(route('list-menu.table', ['name' => $table->name]));
        // return response($qrCode, 200)->header('Content-Type', 'image/png');
        
        // Generate QR code dan langsung return sebagai download response
        return response(QrCode::format('png')->size(300)->generate(route('menu.show', $table->name)))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $table->name . '.png"');
    }

    public function print_table($id){
        $table = Table::find($id);

        return view('dashboard.table.print', compact('table'));
    }

    public function bulkActionTable(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
    
            Table::whereIn('id', $selectedOrders)->delete();
            return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
        }

        return redirect()->back()->with('error', 'No orders selected.');
    }
}
