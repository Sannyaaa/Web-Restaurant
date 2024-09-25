<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $this->authorize('isKitchen');

        if(request()->ajax()){

            $user = auth()->user();
            
            if ($user->role == 'admin' || $user->role == 'kitchen') {
                $query = Menu::query();
            } else {
                $query = Menu::query()->where('user_id', $user->id);
            }

            
            

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $editRoute = route('menu.edit', $item->id);
                    $showRoute = route('menu.show', $item->id);
                    $deleteRoute = route('menu.destroy', $item->id);
                    
                    $actions = '';
                    $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    
                    $actions .= '<a href="'.$showRoute.'" class="font-lg text-blue-600 dark:text-blue-500 hover:underline px-2">Show</a>';
                     
                    $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                        <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                    </form>';
                    
                    return $actions;
                })
                ->editColumn('image', function($item) {
                    return $item->image ? '<img src="'. Storage::url($item->image).'" style="max-height: 80px;" />' : '';
                })
                ->editColumn('category_id', function($item) {
                    return $item->category->name;
                })
                ->editColumn('price', function($item) {
                    return "Rp. " . number_format($item->price) ;
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('category_id')) {
                        $query->where('category_id', $request->category_id);
                    }

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', "%{$searchValue}%")
                                    ->orWhere('price', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action','price','image'])
                ->make(true);
        }

        $categories = Category::all();

        return view('dashboard.menu.index', compact('categories'));
    }

    public function bulkActionMenu(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':
                    
                    Menu::whereIn('id', $selectedOrders)->delete();
                    return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
                case 'edit':
                    $category = $request->input('bulk_action_category');

                        $orders = Menu::whereIn('id', $selectedOrders);

                        if ($category) {
                            $orders->update(['category_id' => $category]);
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

        $categories = Category::all();

        return view('dashboard.menu.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $this->authorize('isKitchen');

        $data = $request->validate([
            'name' =>'required|max:255',
            'description' =>'required|min:5',
            'ingredient' =>'required|min:5',
            'price' =>'required|integer',
            'image' =>'required|image|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('menu','public');
        }

        $data['slug'] = Str::slug($data['name']);

        Menu::create($data);

        return redirect()->route('menu.index')->with('success','Menu created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
        $this->authorize('isKitchen');

        $categories = Category::all();

        return view('dashboard.menu.edit', compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
        $this->authorize('isKitchen');

        $data = $request->validate([
            'name' =>'required|max:255',
            'description' =>'required|string|min:5',
            'ingredient' =>'required|string|min:5',
            'price' =>'required|integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'category_id' => 'required|exists:categories,id',
        ]);

        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('manu','public');
        }

        $data['slug'] = Str::slug($data['name']);

        $menu->update($data);
        return redirect()->route('menu.index')->with('success','Menu updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
        $this->authorize('isKitchen');

        $menu->delete();

        return redirect()->route('menu.index');
    }
}
