<?php

namespace App\Http\Controllers;

use App\Models\Modifier;
use Illuminate\Http\Request;
use PhpParser\Modifiers;
use Yajra\DataTables\Facades\DataTables;

class ModifierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $this->authorize('isKitchen');

        if(request()->ajax()){

            $query = Modifier::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $editRoute = route('modifier.edit', $item->id);
                    $showRoute = route('modifier.show', $item->id);
                    $deleteRoute = route('modifier.destroy', $item->id);
                    
                    $actions = '';
                    $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                    '.method_field('DELETE').'
                                    '.csrf_field().'
                                    <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                </form>';
                    return $actions;
                })
                ->editColumn('price', function($item) {
                    return "Rp." . number_format($item->price);
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->rawColumns(['checkbox','action','image'])
                ->make(true);
        }

        return view('dashboard.modifier.index');
    }

    public function bulkActionModifier(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':
                    
                    Modifier::whereIn('id', $selectedOrders)->delete();
                    return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
                case 'edit':
                    $category = $request->input('bulk_action_category');

                        $orders = Modifier::whereIn('id', $selectedOrders);

                        if ($category) {
                            $orders->update(['category' => $category]);
                        }

                        return redirect()->back()->with('success', 'Selected orders updated successfully.');
                    
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
        $this->authorize('isKitchen');

        return view('dashboard.modifier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('isKitchen');

        $data = $request->validate([
            'name' =>'required|string|max:255',
            'price' =>'required|numeric|min:0',
            'category' =>'required|string',
        ]);

        Modifier::create($data);

        return redirect()->route('modifier.index')->with('success', 'Modifier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modifier $modifier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modifier $modifier)
    {
        //
        $this->authorize('isKitchen');

        return view('dashboard.modifier.edit', compact('modifier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modifier $modifier)
    {
        //
        $this->authorize('isKitchen');

        $data = $request->validate([
            'name' =>'required|string|max:255',
            'price' =>'required|numeric|min:0',
            'category' =>'required|string',
        ]);
        $modifier->update($data);
        return redirect()->route('modifier.index')->with('success', 'Modifier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modifier $modifier)
    {
        //
        $this->authorize('isKitchen');

        $modifier->delete();

        return redirect()->route('modifier.index')->with('success', 'Modifier deleted successfully.');
    }
}
