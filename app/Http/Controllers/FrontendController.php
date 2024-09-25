<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Table;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    //

    public function index()
    {
        $menus = Menu::inRandomOrder()->take(3)->where('status','yes')->get();

        $categories = Category::where('status','yes')->get();

        $feedbacks = Feedback::whereIn('rating',[5,4])->get();

        return view('frontend.index',compact('menus','categories','feedbacks'));
    }

    public function list_menu_table($name){
        // Cari meja berdasarkan nama_meja
        $table = Table::where('name', $name)->firstOrFail();

        // Simpan data meja ke dalam cookie
        cookie()->queue('table_id', $table->id, 60); // Cookie berlaku selama 60 menit

        return redirect()->route('list-menu');
    }

    public function list_menu(Request $request)
    {
        $search = $request->input('search');
        $category_id = $request->input('category');

        // Query untuk mengambil menu
        $query = Menu::query();

        // Jika ada search, tambahkan kondisi pencarian berdasarkan nama menu atau deskripsi
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Jika ada filter kategori, tambahkan kondisi berdasarkan kategori
        if ($category_id) {
            $query->where('category_id', $category_id);
        }

        $menus = $query->where('status','yes')->get();
        $categories = Category::where('status','yes')->get();

        $recommendations = Menu::where('status','yes')->inRandomOrder()->take(3)->get();

        return view('frontend.list',compact('menus','categories','recommendations'));
    }

    // Function to filter menus by category
    public function list_menu_category(Category $category)
    {
        $categories = Category::where('status','yes')->get();
        $menus = Menu::where('category_id', $category->id)->where('status','yes')->get();
        $recommendations = Menu::inRandomOrder()->take(3)->where('status','yes')->get();

        return view('frontend.list', compact('menus', 'categories','recommendations'))->with('selectedCategory', $category);
    }

    public function detail_menu(Request $request, Menu $menu)
    {
        $reviews = Review::where('menu_id',$menu->id)->get();

        $total = 0;
        $count = $reviews->count();

        if ($count > 0) {
            foreach ($reviews as $review) {
                $total += $review->rating;
            }
            $average_rating = $total / $count;
        } else {
            $average_rating = null; // Atau bisa di set ke 0 jika lebih cocok
        }

        return view('frontend.menu',compact('menu','reviews','average_rating'));
    }

    public function contact(){
        return view('frontend.contact');
    }

}
