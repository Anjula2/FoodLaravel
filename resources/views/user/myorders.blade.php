<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodTruck.lk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-yellow-100 text-gray-900 flex flex-col min-h-screen">

  <!-- Header Section -->
  <header class="relative bg-cover bg-center py-0">
    <div class="absolute inset-0 bg-black bg-opacity-50 z-0"></div>
    <div class="relative z-10 flex justify-center">
      <nav class="w-full max-w-7xl flex items-center justify-between p-4 lg:p-6 bg-black bg-opacity-75">
        <!-- Logo -->
        <a class="text-white text-2xl lg:text-3xl font-bold uppercase tracking-wide" href="#">FoodTruck.lk</a>

        <!-- Navigation Menu -->
        <div class="hidden md:block"> 
          <ul class="flex space-x-6 text-white text-lg">
            <li><a href="{{url('home')}}" class="hover:text-yellow-500 transition duration-300 ease-in-out">Home</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">Shop</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">About</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">Contact</a></li>
          </ul>
        </div>

        <!-- Auth Links or Logout Button -->
        <div class="space-x-4 flex items-center">
          @if(Auth::check())
            <!-- User-specific content with Account Icon -->
            <div class="flex items-center space-x-4">
              <ul class="flex space-x-2">
                <li>
                  <a href="{{url('cart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
                    <i class="fas fa-shopping-cart"></i> <!-- Cart Icon -->
                    <span class="ml-2">Cart [{{$cartCount}}]</span>
                  </a>
                </li>
              </ul>

              <ul class="flex space-x-2">
                <li>
                  <a href="{{ route('profile.show') }}" class="flex items-center text-white  hover:text-yellow-500 transition duration-300 ease-in-out">
                    <i class="fas fa-user"></i>
                    <span class="ml-2">{{ Auth::user()->name }}</span>
                  </a>
                </li>
              </ul> 
            </div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="text-white bg-red-500 hover:bg-red-600 font-medium px-4 py-2 rounded transition duration-300">
                Logout
              </button>
            </form>
          @else
            <!-- Login/Register Links -->
            <a href="{{ route('login') }}" class="text-white bg-red-500 hover:bg-red-600 font-medium px-4 py-2 rounded transition duration-300">Login</a>
            <a href="{{ route('register') }}" class="text-white bg-red-500 hover:bg-red-600 font-medium px-4 py-2 rounded transition duration-300">Register</a>
          @endif
        </div>
      </nav>
    </div>
  </header>

  <body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

<!-- Header -->
<header class="bg-yellow-500 py-6 text-white text-center shadow-md">
    <h1 class="text-3xl font-bold">My Orders</h1>
</header>

<!-- Orders Section -->
<main class="flex-grow p-6 bg-gray-100">
    @if($orders->isEmpty())
        <div class="text-center text-gray-700 font-medium text-lg mt-10">
            <p>No orders found.</p>
            <a href="{{ url('shop') }}" class="text-yellow-500 hover:underline text-base font-semibold">
                Browse products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($orders as $order)
                <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                    <!-- Order Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">
                            <i class="fas fa-receipt text-yellow-500 mr-2"></i>
                            Order #{{ $order->id }}
                        </h2>
          <span 
            class="text-sm px-3 py-1 rounded-full font-medium"
            style="
               background-color: 
                   @if($order->status === 'pending') #fef08a; /* Yellow */ 
                   @elseif($order->status === 'Received') #fed7aa; /* Blue */
                   @elseif($order->status === 'Preparing') #fed7aa; /* Orange */
                   @elseif($order->status === 'Pick Up by Rider') #e9d8fd; /* Purple */
                   @elseif($order->status === 'On the Way') #fef08a; /* Yellow */
                   @elseif($order->status === 'Delivered') #bbf7d0; /* Green */
                   @elseif($order->status === 'Cancelled') #fecaca; /* Red */
                   @elseif($order->status === 'Picked-Up') #bbf7d0; /* Green */
                   @else #f3f4f6; /* Gray */
                   @endif;
               color: 
                  @if($order->status === 'pending') #ca8a04; /* Dark Yellow */ 
                  @elseif($order->status === 'Received') #1e40af; /* Dark Blue */
                  @elseif($order->status === 'Preparing') #c05621; /* Dark Orange */
                  @elseif($order->status === 'Pick Up by Rider') #7e22ce; /* Dark Purple */
                  @elseif($order->status === 'On the Way') #ca8a04; /* Dark Yellow */
                  @elseif($order->status === 'Delivered') #166534; /* Dark Green */
                  @elseif($order->status === 'Cancelled') #b91c1c; /* Dark Red */
                  @elseif($order->status === 'Picked-Up') #166534; /* Dark Green */
                  @else #4b5563; /* Dark Gray */
                  @endif;">
                         {{ ucfirst($order->status) }}
          </span>
                    </div>
                    
                    <!-- Order Details -->
                    <div class="space-y-2">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-calendar-alt text-yellow-500 mr-2"></i>
                            <strong>Ordered on:</strong> {{ $order->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-layer-group text-yellow-500 mr-2"></i>
                            <strong>Items:</strong> {{ $order->total_items }}
                        </p>
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-dollar-sign text-yellow-500 mr-2"></i>
                            <strong>Total:</strong> Rs. {{ number_format($order->total_price, 2) }}
                        </p>
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-map-marker-alt text-yellow-500 mr-2"></i>
                            <strong>Address:</strong> {{ $order->shipping_address ?? 'N/A' }}
                        </p>
                    </div>

                    <!-- Divider -->
                    <hr class="my-4">

           <div class="flex justify-between items-center bg-yellow-100 p-4 rounded-lg shadow-lg mt-4">
              <div class="flex items-center space-x-3">
                 <i class="fas fa-truck text-yellow-600 text-2xl"></i>
                 <p class="text-lg font-semibold text-gray-800">
                 <strong>Delivery Method:</strong>
                </p>
              </div>
              <p class="text-lg text-gray-700 font-medium">
                     {{ ucfirst($order->delivery_method) }}
              </p>
            </div>
                </div>
            @endforeach
        </div>
    @endif
</main>

    <!-- Footer Section -->
  <footer class="py-12 bg-gray-900 text-gray-100 text-center mt-auto">
    <p>&copy; 2024 FoodTruck.Lk. All rights reserved.</p>
    <p>Follow us on <a href="#" class="text-yellow-500">Social Media</a></p>
  </footer>