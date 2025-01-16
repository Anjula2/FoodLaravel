<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\CustomerRequest;

class HomeController extends Controller
{
    public function home()
    {
        $data = product::paginate(3);

        $requestdata = customerrequest::paginate(3);

        $count = auth()->check() 
            ? Cart::where('phone', auth()->user()->phone)->count() 
            : 0;

        return view('home', compact('data', 'count','requestdata'));
    }

    public function index()
    {
        $data = product::paginate(3);

        $requestdata = customerrequest::paginate(3);

        $count = auth()->check() 
            ? Cart::where('phone', auth()->user()->phone)->count() 
            : 0;

        return view('home', compact('data', 'count', 'requestdata'));
    }

    public function addcart(Request $request, $id)
{
    if (Auth::id()) {

        $user = auth()->user();
        $product = Product::find($id);

        $cart = new Cart;

        $cart->name = $user->name;
        $cart->phone = $user->phone;
        $cart->address = $user->address;

        $cart->product_title = $product->name;

        $cart->price = $product->price * $request->quantity;

        $cart->quantity = $request->quantity;

        $cart->save();

        return redirect()->back()->with('message', 'Product Added Successfully');
    } else {
        return redirect('login');
    }
}

public function addcartNew(Request $request, $id)
{
    if (Auth::id()) {

        $user = auth()->user();
        $customerrequest = CustomerRequest::find($id);

        $cart = new Cart;

        $cart->name = $user->name;
        $cart->phone = $user->phone;
        $cart->address = $user->address;

        $cart->product_title = $customerrequest->meal_name;

        $cart->price = $customerrequest->price * $request->quantity;

        $cart->quantity = $request->quantity;

        $cart->save();

        return redirect()->back()->with('message', 'Product Added Successfully');
    } else {
        return redirect('login');
    }
}

    public function cart()
  {

    $user = auth()->user();
    $cart = Cart::where('phone', $user->phone)->get();

    $count = $cart->count();

    $orderCount = $user->orders ? $user->orders->count() : 0;

    $totalPrice = $cart->sum(function($item) {
        return $item->price * $item->quantity;
    });
    $totalQuantity = $cart->sum('quantity');

    return view('user.cart', compact('count','orderCount', 'cart', 'totalPrice', 'totalQuantity', 'user'));
}


    public function deletecart($id){

        $data=cart::find($id);
        $data->delete();

        return redirect()->back()->with('message','Product Remove Successfully');
    }
}
