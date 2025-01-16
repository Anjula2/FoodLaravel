<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRequestController extends Controller
{
    public function store(Request $request)
{
    if (Auth::id()) { 

    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'meal_name' => 'required|string|max:255',
        'message' => 'nullable|string|max:255',
    ]);

    $customerRequest = new CustomerRequest();
    $customerRequest->user_id = Auth::id();
    $customerRequest->customer_name = $validated['customer_name'];
    $customerRequest->email = $validated['email'];
    $customerRequest->meal_name = $validated['meal_name'];
    $customerRequest->message = $validated['message'];
    $customerRequest->image_path = null;
    $customerRequest->description = null;  
    $customerRequest->price = null;
    $customerRequest->is_accepted = false; 
    $customerRequest->save();

    return redirect()->back()->with('success', 'Your request has been submitted.');
} else {
        return redirect('login');
    }

}

}