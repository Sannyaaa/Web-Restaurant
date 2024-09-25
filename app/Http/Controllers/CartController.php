<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Modifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'quantity' =>'required|numeric|min:1',
            'menu_id' => 'required|exists:menus,id',
        ]);

        $menu = Menu::find($data['menu_id']);

        // Data item yang akan disimpan di session
        $cartItem = [
            'id' => $menu->id,
            'name' => $menu->name,
            'image' => $menu->image,
            'description' => $menu->description,
            'category' => $menu->category->name,
            'price' => $menu->price,
            'modifiers' => [], // Simpan modifier yang dipilih
            'quantity' => $request->input('quantity', 1),
            'instructions' => $request->input('instructions', null)
        ];

        // Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        // Tambahkan item ke keranjang atau update jika sudah ada
        $cart[$data['menu_id']] = $cartItem;

        // Simpan kembali ke session
        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'add to cart successfully']);
        }

        return redirect()->route('list-menu')->with('success','add to cart successfully');
    }

    public function index()
    {
        $carts = session()->get('cart', []);
        $total_price = 0;

        foreach ($carts as &$item) {
            $item_price = $item['price'];
            $modifier_price = 0;

            // Hitung harga modifier
            if (!empty($item['modifiers'])) {
                $modifiers = Modifier::whereIn('id', $item['modifiers'])->get();
                foreach ($modifiers as $modifier) {
                    $modifierQuantity = $item['modifier_quantities'][$modifier->id] ?? 1;
                    $modifier->quantity = $modifierQuantity;
                    $modifier->total_price = $modifier->price * $modifierQuantity;
                    $modifier_price += $modifier->total_price;
                }
                $item['selected_modifiers'] = $modifiers;
            }

            $item['total_modifier_price'] = $modifier_price;
            $item['total_item_price'] = ($item_price * $item['quantity'])  + $modifier_price;
            $total_price += $item['total_item_price'];
        }

        // Simpan kembali cart yang sudah dimodifikasi ke session
        session()->put('cart', $carts);

        $tables = Table::all();
        $recommendations = Menu::inRandomOrder()->take(3)->get();
        $modifiers = Modifier::orderBy('category','DESC')->get();

        return view('frontend.cart', compact('carts', 'modifiers',  'total_price', 'tables', 'recommendations'));
    }

    public function cart_update(Request $request){

        // $cart->quantity = $request->quantity;
        // $cart->instruction = $request->instruction;

        // $cart->save();

        $cart = session()->get('cart', []);

        foreach ($request->cart as $id => $details) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = $details['quantity'];
                $cart[$id]['instructions'] = $details['instructions'];
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success','cart updated succesfully');
    }

    public function destroy($id){
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item deleted successfully');
    }

    public function cart_update_modifier(Request $request)
    {
        $cartId = $request->input('cart_id');
        $selectedModifiers = $request->input('modifiers', []);
        $modifierQuantities = $request->input('modifier_quantities', []);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartId])) {
            // Hapus semua modifiers yang tidak dipilih
            $cart[$cartId]['modifiers'] = [];
            $cart[$cartId]['modifier_quantities'] = [];

            foreach ($selectedModifiers as $modifierId) {
                $cart[$cartId]['modifiers'][] = $modifierId;
                $cart[$cartId]['modifier_quantities'][$modifierId] = $modifierQuantities[$modifierId] ?? 1;
            }

            // Hitung ulang total harga
            $basePrice = $cart[$cartId]['price'];
            $quantity = $cart[$cartId]['quantity'];
            $modifiersPrice = $this->calculateModifiersPrice($cart[$cartId]['modifiers'], $cart[$cartId]['modifier_quantities']);

            $cart[$cartId]['total_price'] = ($basePrice + $modifiersPrice) * $quantity;

            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Modifier updated successfully.');
    }

    private function calculateModifiersPrice($modifierIds, $modifierQuantities)
    {
        $modifiers = Modifier::whereIn('id', $modifierIds)->get();
        $totalPrice = 0;

        foreach ($modifiers as $modifier) {
            $quantity = $modifierQuantities[$modifier->id] ?? 1;
            $totalPrice += $modifier->price * $quantity;
        }

        return $totalPrice;
    }


}
