<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //

    public function index(Request $request)
    {
        if(Auth::user()->role == 'user'){
            return redirect()->route('order.index');
        }
        $this->authorize('isStaf');

        // Mendapatkan tanggal hari ini
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Total Penjualan Hari Ini
        $totalSalesToday = Order::whereDate('created_at', $today)
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->count();

        // Total Penjualan Kemarin
        $totalSalesYesterday = Order::whereDate('created_at', $yesterday)
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->count();

        // Pendapatan Hari Ini
        $totalRevenueToday = Order::whereDate('created_at', $today)
                                ->where('status', 'delivered')
                                ->where('payment_status', 'paid')
                                ->sum('total_price');

        // Pendapatan Kemarin
        $totalRevenueYesterday = Order::whereDate('created_at', $yesterday)
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->sum('total_price');

        // Hitung perubahan persentase penjualan
        $salesDifference = $totalSalesToday - $totalSalesYesterday;

        // Hitung perubahan persentase pendapatan
        $revenueDifference = $totalRevenueToday - $totalRevenueYesterday;

        // Mendapatkan tanggal awal dan akhir bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Mendapatkan tanggal awal dan akhir bulan kemarin
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Total Penjualan Bulan Ini
        $totalSalesMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->count();

        // Total Penjualan Bulan Kemarin
        $totalSalesLastMonth = Order::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->count();

        // Pendapatan Bulan Ini
        $totalRevenueMonth = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->sum('total_price');

        // Pendapatan Bulan Kemarin
        $totalRevenueLastMonth = Order::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
                                    ->where('status', 'delivered')
                                    ->where('payment_status', 'paid')
                                    ->sum('total_price');

        // Hitung perubahan persentase penjualan
        $salesMonthDifference = $totalSalesMonth - $totalSalesLastMonth;

        // Hitung perubahan persentase pendapatan
        $revenueMonthDifference = $totalRevenueMonth - $totalRevenueLastMonth;

        // Menu yang paling banyak dibeli
        $mostOrderedMenu = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereHas('order', function($query) {
                $query->where('status', 'delivered');
            })
            ->groupBy('menu_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->with('menu') // eager load menu
            ->get();

         // Mendapatkan tahun yang dipilih, default ke tahun ini
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Mengambil data penjualan dan pendapatan berdasarkan tahun yang dipilih
        $salesData = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereYear('created_at', $selectedYear)
            ->where('status', 'delivered')
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Menyiapkan array untuk chart
        $salesChartData = [];
        $revenueChartData = [];
        $months = [];

        foreach ($salesData as $data) {
            $months[] = Carbon::create($selectedYear, $data->month)->format('F');
            $salesChartData[] = $data->total_sales;
            $revenueChartData[] = $data->total_revenue;
        }

        // Mengambil semua tahun yang ada di database untuk select option
        $years = Order::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year');

        // Mengambil Order Terbaru
        $orders = Order::orderByDesc('id')->take(5)->get();

        $feedbacks = Feedback::orderByDesc('id')->take(8)->get();
        $reviews = Review::orderByDesc('id')->take(8)->get();

        return view('dashboard.dashboard', compact('totalSalesToday', 'totalRevenueToday','salesDifference','revenueDifference','totalSalesMonth', 'totalRevenueMonth','salesMonthDifference','revenueMonthDifference','mostOrderedMenu','months', 'salesChartData', 'revenueChartData', 'years', 'selectedYear','orders','feedbacks','reviews'));
    }

    public function profile()
    {
        $user = Auth::user();

        return view('dashboard.profile',compact('user'));
    }

    public function profile_edit(Request $request, User $user){
        $data = $request->validate([
            'name' =>'required|string|max:255',
            'phone' =>'required|numeric|unique:users,phone,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        
        if($request->hasFile('avatar')){
            $data['avatar'] = $request->file('avatar')->store('profile','public');
        }else{
            $data['avatar'] = $user->avatar;
        }

        $user->update($data);

        return redirect()->route('profile')->with('success','Profile updated successfully!');
    }
}
