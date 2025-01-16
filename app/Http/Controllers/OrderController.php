<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'cart_data' => 'required|json',
    ]);

    $cartData = json_decode($request->cart_data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return redirect('/cart')->with('error', 'Invalid cart data.');
    }

    if (isset($cartData['items']) && is_array($cartData['items'])) {

        $totalPrice = $cartData['total_price'];
        $totalItems = $cartData['total_items'];
        $deliveryMethod = $cartData['delivery_method'] ?? 'pickup';  

        Order::create([
            'user_id' => Auth::id(),
            'customer_name' => Auth::user()->name,
            'contact_number' => Auth::user()->phone,
            'shipping_address' => Auth::user()->address,
            'total_price' => $totalPrice,
            'total_items' => $totalItems,
            'items' => json_encode($cartData['items']),  
            'status' => 'pending',
            'delivery_method' => $deliveryMethod,
            'is_completed' => false,
        ]);

        Cart::where('phone', Auth::user()->phone)->delete();

        session()->forget('cart');

        return redirect('/cart')->with('success', 'Your order has been placed successfully!');
    }
}


    public function myorders()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->get();

        $cartCount = Cart::where('phone', Auth::user()->phone)->count();

        return view('user.myorders', compact('orders', 'cartCount'));
    }
}

