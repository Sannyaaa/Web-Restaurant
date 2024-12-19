<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if(request()->ajax()){

            $user = auth()->user();
            
            if ($user->role == 'admin') {
                $query = Review::query()->orderByDesc('created_at');
            } else {
                $query = Review::query()->where('user_id', $user->id)->orderByDesc('created_at');
            }

            $query = $query->join('users', 'reviews.user_id', '=', 'users.id')
                ->join('menus', 'reviews.menu_id', '=', 'menus.id')
                ->select('reviews.*', 'users.name as user_name', 'menus.name as menu_name');

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($review){
                    $editRoute = route('review.edit', $review->id);
                    $showRoute = route('review.show', $review->id);
                    $deleteRoute = route('review.destroy', $review->id);
                    
                    $actions = '';
                    if(auth()->user()->can('update', $review)) {
                        $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    }
                    // $actions .= '<a href="'.$showRoute.'" class="font-lg text-blue-600 dark:text-blue-500 hover:underline px-2">Show</a>';
                    if(auth()->user()->can('delete', $review)) {
                        $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                        <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                    </form>';
                    }
                    return $actions;
                })
                ->editColumn('menu_id', function($review) {
                    return $review->menu->name;
                })
                
                ->editColumn('user_id', function($review) {
                    return $review->user->name;
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->editColumn('rating', function($review) {
                    $stars = '';
                    for($i = 1;$i <= $review->rating; $i++){
                        $stars .= '<svg class="w-5 h-5 inline-block" viewBox="0 0 18 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z"
                                        fill="currentColor"></path>
                                </svg>';
                    };

                    return $stars;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('rating')) {
                        $query->where('rating', $request->rating);
                    }

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('users.name', 'like', "%{$searchValue}%")
                                    ->orWhere('menus.name', 'like', "%{$searchValue}%")
                                    ->orWhere('comment', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action','menu_id','user_id','rating','created_at'])
                ->make(true);
        }

        return view('dashboard.review.index');
    }

    public function bulkActionReview(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':

                    Review::whereIn('id', $selectedOrders)->delete();
                    return redirect()->back()->with('success', 'Selected orders deleted successfully.');

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
        // dd($request);

        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'required|exists:order_items,id',
            'comment' =>'nullable|max:255',
            'is_show' =>'required|max:255',
            'rating' =>'required|numeric|between:1,5',
        ]);

        $validated['user_id'] = Auth::user()->id;

        $order = Order::where('id',$validated['order_id'])->get();

        // dd($order);

        $orderItem = OrderItem::with('order')->where('id',$validated['order_item_id'])->get();

        // dd($orderItem->order);

        Review::create($validated);

        return redirect()->route('order.show', $validated['order_id'])->with('success','review created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
        $this->authorize('update', $review);

        return view('dashboard.review.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
        $this->authorize('update', $review);

        $validated = $request->validate([
            'comment' =>'nullable|max:255',
            'is_show' =>'required|max:255',
            'rating' =>'required|numeric|between:1,5',
        ]);

        $review->update($validated);

        return redirect()->route('review.index', $review->id)->with('success','Review updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
        $this->authorize('delete', $review);

        $review->delete();

        return redirect()->route('review.index')->with('success','Review deleted successfully');
    }
}
