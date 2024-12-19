<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $this->authorize('isKitchen');

        if(request()->ajax()){

            $query = Category::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $editRoute = route('category.edit', $item->id);
                    $showRoute = route('category.show', $item->id);
                    $deleteRoute = route('category.destroy', $item->id);
                    
                    $actions = '';
                    $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;"  method="POST" action="/delete" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                    '.method_field('DELETE').'
                                    '.csrf_field().'
                                    <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                </form>';
                    return $actions;
                })
                ->editColumn('image', function($item) {
                    return $item->image ? '<img src="'. Storage::url($item->image).'" style="max-height: 120px;" />' : '';
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->rawColumns(['checkbox','action','image'])
                ->make(true);
        }

        return view('dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('isKitchen');

        return view('dashboard.category.create');
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
            'description' =>'required|string|min:5',
            'image' =>'required|image|mimes:png,jpg,jpeg,svg',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('category','public');
        }

        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        $this->authorize('isKitchen');

        return view('dashboard.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $this->authorize('isKitchen');

        $data = $request->validate([
            'name' =>'required|string|max:255',
            'description' =>'required|string|min:5',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('category','public');
        }

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('category','public');
            if($category->image) {
                Storage::disk('public')->delete($category->image);
            }
        } else {
            $data['image'] = $category->image;
        }

        $category->update($data);
        return redirect()->route('category.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $this->authorize('isKitchen');

        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category deleted successfully.');
    }

    public function bulkActionCategory(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
    
            Category::whereIn('id', $selectedOrders)->delete();
            return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
        }

        return redirect()->back()->with('error', 'No orders selected.');
    }
}
