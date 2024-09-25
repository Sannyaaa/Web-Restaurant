<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
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
                $query = Feedback::query()->orderByDesc('created_at');
            } else {
                $query = Feedback::query()->where('user_id', $user->id)->orderByDesc('created_at');
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $editRoute = route('feedback.edit', $item->id);
                    $showRoute = route('feedback.show', $item->id);
                    $deleteRoute = route('feedback.destroy', $item->id);
                    
                    $actions = '';
                    // if(auth()->user()->can('update', $item)) {
                    //     $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    // }
                    // $actions .= '<a href="'.$showRoute.'" class="font-lg text-blue-600 dark:text-blue-500 hover:underline px-2">Show</a>';
                    if(auth()->user()->can('delete', $item)) {
                        $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;" onsubmit="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">
                                        '.method_field('DELETE').'
                                        '.csrf_field().'
                                        <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                                    </form>';
                    }
                    return $actions;
                })
                ->editColumn('rating', function($item) {
                    $stars = '';
                    for($i = 1;$i <= $item->rating; $i++){
                        $stars .= '<svg class="w-5 h-5 inline-block" viewBox="0 0 18 17" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M8.10326 1.31699C8.47008 0.57374 9.52992 0.57374 9.89674 1.31699L11.7063 4.98347C11.8519 5.27862 12.1335 5.48319 12.4592 5.53051L16.5054 6.11846C17.3256 6.23765 17.6531 7.24562 17.0596 7.82416L14.1318 10.6781C13.8961 10.9079 13.7885 11.2389 13.8442 11.5632L14.5353 15.5931C14.6754 16.41 13.818 17.033 13.0844 16.6473L9.46534 14.7446C9.17402 14.5915 8.82598 14.5915 8.53466 14.7446L4.91562 16.6473C4.18199 17.033 3.32456 16.41 3.46467 15.5931L4.15585 11.5632C4.21148 11.2389 4.10393 10.9079 3.86825 10.6781L0.940384 7.82416C0.346867 7.24562 0.674378 6.23765 1.4946 6.11846L5.54081 5.53051C5.86652 5.48319 6.14808 5.27862 6.29374 4.98347L8.10326 1.31699Z"
                                        fill="currentColor"></path>
                                </svg>';
                    };

                    return $stars;
                })
                ->editColumn('created_at', function($order) {
                    return $order->created_at->format('d F Y') ;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('rating')) {
                        $query->where('rating', $request->rating);
                    }

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', "%{$searchValue}%")
                                    ->orWhere('phone', 'like', "%{$searchValue}%")
                                    ->orWhere('message', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action','rating'])
                ->make(true);
        }

        return view('dashboard.feedback.index');
    }

    public function bulkActionFeedback(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':

                    Feedback::whereIn('id', $selectedOrders)->delete();
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
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['required','string','max:255'],
            // 'email' => ['required', 'email','max:255'],
            'message' => ['required','string','min:10'],
            'rating' => ['required', 'integer','min:1','max:5'],
        ]);

        $data['user_id'] = Auth::user()->id;

        $feedback = Feedback::create($data);

        return redirect()->route('contact-us')->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feedback $feedback)
    {
        //

        return view('dashboard.feedback.edit',compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {
        //

        $this->authorize('update',$feedback);

        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['required','string','max:255'],
            'message' => ['required','string','min:10'],
            'rating' => ['required', 'integer','min:1','max:5'],
        ]);

        $feedback->update($data);

        return redirect()->route('feedback.index')->with('success','feedback updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        //
        $this->authorize('delete',$feedback);

        $feedback->delete();

        return redirect()->route('feedback.index')->with('success','feedback deleted successfully');
    }
}
