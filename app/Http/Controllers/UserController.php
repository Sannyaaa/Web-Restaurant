<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\SimpleExcel\SimpleExcelWriter;

class UserController extends Controller
{
    //

    public function index(Request $request){
        $this->authorize('isAdmin');

        if(request()->ajax()){

            $user = auth()->user();
            
            if ($user->role == 'admin' || $user->role == 'service') {
                $query = User::query();
            } else {
                $query = User::query()->where('user_id', $user->id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($item){
                    return '<input type="checkbox" name="selected_orders[]" value="'.$item->id.'">';
                })
                ->addColumn('action', function($item){
                    $editRoute = route('user.edit', $item->id);
                    $showRoute = route('user.show', $item->id);
                    $deleteRoute = route('user.destroy', $item->id);
                    
                    $actions = '';
                    // if(auth()->user()->can('update', $item)) {
                        $actions .= '<a href="'.$editRoute.'" class="font-lg text-green-600 dark:text-green-500 hover:underline px-2">Edit</a>';
                    // }
                    // $actions .= '<a href="'.$showRoute.'" class="font-lg text-blue-600 dark:text-blue-500 hover:underline px-2  ">Show</a>';
                    // if(auth()->user()->can('delete', $item)) {
                        // $actions .= '<form action="'.$deleteRoute.'" method="POST" style="display:inline;">
                    //                     '.method_field('DELETE').'
                    //                     '.csrf_field().'
                    //                     <button type="submit" class="font-lg text-red-600 dark:text-red-500 hover:underline px-2 py-2">Hapus</button>
                    //                 </form>';
                    // }
                    return $actions;
                })
                ->editColumn('created_at', function($item) {
                    return $item->created_at->format('d F Y') ;
                })
                ->editColumn('access', function($item) {
                    $class = '';

                    switch ($item->access) {
                        case 'no':
                            $class = 'bg-yellow-100 text-yellow-700';
                            break;
                        case 'yes':
                            $class = 'bg-green-100 text-green-700';
                            break;
                        default:
                            $class = 'bg-gray-100 text-gray-700';
                            break;
                    }

                    return "<span class='py-2 px-4 rounded-lg w-fit {$class}'>" . ucfirst($item->access) . "</span>";
                })
                ->filter(function ($query) use ($request) {
                    if ($request->filled('role')) {
                        $query->where('role', $request->role);
                    }

                    if ($request->filled('access')) {
                        $query->where('access', $request->access);
                    }

                    $searchValue = request()->input('search.value');
            
                    // Menggunakan 'search.value' dari request DataTables
                    if ($searchValue) {
                        $query->where(function($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', "%{$searchValue}%")
                                    ->orWhere('phone', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->rawColumns(['checkbox','action', 'created_at','access'])
                ->make(true);
        }

        $roles = Role::all();
        
        return view('dashboard.user.index', compact('roles'));
    }

    public function bulkActionUser(Request $request)
    {
        $selectedOrders = $request->input('selected_orders');
        $action = $request->input('bulk_action');

        if ($selectedOrders) {
            switch ($action) {
                case 'delete':

                    User::whereIn('id', $selectedOrders)->delete();
                    return redirect()->back()->with('success', 'Selected orders deleted successfully.');
                
                case 'edit':

                    $access = $request->input('bulk_action_access');

                        $orders = User::whereIn('id', $selectedOrders);

                        if ($access) {
                            $orders->update(['access' => $access]);
                        }

                        return redirect()->back()->with('success', 'Selected orders updated successfully.');
                    
                    break;

                default:

                    return redirect()->back()->with('error', 'No valid action selected.');
            }
        }

        return redirect()->back()->with('error', 'No orders selected.');
    }

    public function create(){
        $this->authorize('isAdmin');

        return view('dashboard.user.create');
    }

    public function store(Request $request){
        $this->authorize('isAdmin');

        $data = $request->validate([
            'name' =>'required|string|max:255',
            'phone' =>'required|string|unique:users|max:15',
            'email' =>'required|string|email|unique:users|max:255',
            'role' =>'required|string|exists:roles,name',
            'access' =>'required|string|in:yes,no',
        ]);

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    public function edit(User $user){

        $this->authorize('isAdmin');

        $roles = Role::all();

        return view('dashboard.user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user){

        $this->authorize('isAdmin');

        $data = $request->validate([
            'role' =>'required|string|exists:roles,name',
            'access' =>'required|string|in:yes,no',
        ]);

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user){
        $this->authorize('isAdmin');

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function export_user(){
        // Buat file Excel baru dengan header
        $writer = SimpleExcelWriter::streamDownload('users.xlsx')
            ->addHeader(['ID', 'Name', 'Phone', 'Email', 'Role', 'Access', 'Created At']);
        
        // Ambil data user dari database
        $users = User::all();

        // Tambahkan data user ke dalam file Excel
        foreach ($users as $user) {
            $writer->addRow([
                'ID' => $user->id,
                'Name' => $user->name,
                'Phone' => $user->phone,
                'Email' => $user->email,
                'Role' => $user->role,
                'Access' => $user->access,
                'Created At' => $user->created_at->format('Y-m-d H:i:s')
            ]);
        }

        // Selesaikan dan kirim file ke browser
        $writer->toBrowser();
    }
    
}
