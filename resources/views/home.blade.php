<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <title>FoodTruck.lk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-yellow-100 text-gray-900">

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
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">Home</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">Shop</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">About</a></li>
            <li><a href="#" class="hover:text-yellow-500 transition duration-300 ease-in-out">Contact</a></li>
          </ul>
        </div>

        <div class="space-x-4 flex items-center">
          @if(Auth::check())
            <div class="flex items-center space-x-4">
            <ul class="flex space-x-2">
            <li>
              <a href="{{url('cart')}}" class="flex items-center text-white hover:text-yellow-500 transition duration-300 ease-in-out">
              <i class="fas fa-shopping-cart"></i> 
              <span class="ml-2">Car [{{$count}}]</span>
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
            <a href="{{ route('login') }}" class="text-white bg-red-500 hover:bg-red-600 font-medium px-4 py-2 rounded transition duration-300">Login</a>
            <a href="{{ route('register') }}" class="text-white bg-red-500 hover:bg-red-600 font-medium px-4 py-2 rounded transition duration-300">Register</a>
          @endif
        </div>
      </nav>
    </div>
    @if(session()->has('message'))
     <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session()->get('message') }}
     <button type="button" class="absolute top-0 right-0 mt-1 mr-2 text-green-500 hover:text-green-800" onclick="document.getElementById('success-alert').style.display='none';">
    &times;
     </button>
    </div>
@endif

@if (session('success'))
    <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button 
            onclick="document.getElementById('success-alert').style.display='none';" 
            class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1 1 0 01-1.414 0L10 11.414l-2.934 2.935a1 1 0 11-1.414-1.414l2.934-2.935-2.935-2.934a1 1 0 011.414-1.414L10 8.586l2.934-2.935a1 1 0 111.414 1.414L11.414 10l2.935 2.934a1 1 0 010 1.415z"/>
            </svg>
        </button>
    </div>
@endif

  </header>

  <!-- Hero Section -->
  <section class="relative text-center py-24 bg-cover bg-center bg-no-repeat" style="background-image: url('images/Main_Image.jpg');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Content Wrapper -->
    <div class="relative z-10">
      <h1 class="text-5xl font-bold text-white">Welcome to Food Truck Restaurant</h1>
      <p class="mt-4 text-lg text-gray-300">Find the best foods with amazing taste.</p>
      <div class="mt-6">
        <a href="#" class="inline-block px-8 py-3 bg-yellow-500 text-white border border-yellow-500 hover:bg-transparent hover:text-yellow-500 transition-all duration-300">Shop Now</a>
      </div>
    </div>
  </section>

  <!-- Popular Meals Heading -->
  <div class="flex justify-center items-center py-10">
    <h1 class="text-3xl font-bold">Popular Meals</h1>
  </div>

  <!-- Product Section -->
  <section class="py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Product 1 -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
          <img src="images/chickenkottu.jpg" alt="Product 1" class="w-full h-48 object-cover rounded-md">
          <h2 class="mt-4 text-xl font-bold text-gray-800">Chicken Kottu</h2>
          <p class="mt-2 text-gray-600">Taste our Chicken Kottu.</p>
          <p class="mt-2 text-gray-600">Rs.1400/=</p>
          <div class="mt-4">
            <a href="#" class="inline-block px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">Buy Now</a>
          </div>
        </div>
        <!-- Product 2 -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
          <img src="images/chickenfried.jpg" alt="Product 2" class="w-full h-48 object-cover rounded-md">
          <h2 class="mt-4 text-xl font-bold text-gray-800">Chicken Fried Rice</h2>
          <p class="mt-2 text-gray-600">Taste our Chicken Fried Rice</p>
          <p class="mt-2 text-gray-600">Rs.1200/=</p>
          <div class="mt-4">
            <a href="#" class="inline-block px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">Buy Now</a>
          </div>
        </div>
        <!-- Product 3 -->
        <div class="bg-white p-6 shadow-lg rounded-lg">
          <img src="images/koreanramen.jpg" alt="Product 3" class="w-full h-48 object-cover rounded-md">
          <h2 class="mt-4 text-xl font-bold text-gray-800">Korean Ramen Noodles</h2>
          <p class="mt-2 text-gray-600">Taste our Korean Ramen Noodles.</p>
          <p class="mt-2 text-gray-600">Rs.1550/=</p>
          <div class="mt-4">
            <a href="#" class="inline-block px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">Buy Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="flex justify-center items-center py-10">
    <h1 class="text-3xl font-bold">New Items</h1>
  </div>

  @include('user.product')
<!-- <div class="relative mt-0">
  <svg class="w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
    <path fill="#f59e0b" fill-opacity="1" d="M0,64L48,85.3C96,107,192,149,288,181.3C384,213,480,235,576,229.3C672,224,768,192,864,170.7C960,149,1056,139,1152,144C1248,149,1344,171,1392,181.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
  </svg>
</div> -->
@include('user.latestproduct')

  <!-- Contact Section -->
  <section class="py-24 bg-gray-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-gray-800 text-center">Customer Requests</h2>
      <p class="text-lg text-gray-600 text-center mt-2">We'd love to hear from you.</p>

      <form action="{{ route('customer.requests.store') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        <input 
            type="text" 
            name="customer_name" 
            placeholder="Name" 
            class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-yellow-300"
        >
        <input 
            type="email" 
            name="email" 
            placeholder="Email" 
            class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-yellow-300"
        >
        <input 
            type="text" 
            name="meal_name" 
            placeholder="Name of the Meal" 
            class="w-full p-4 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:ring-yellow-300"
        >
        <textarea 
            name="message" 
            placeholder="Message" 
            class="w-full p-4 border border-gray-300 rounded-lg shadow-sm h-32 focus:outline-none focus:ring focus:ring-yellow-300"
        ></textarea>
        <button 
            class="w-full py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all"
        >
            Submit
        </button>
      </form>
    </div>
</section>

   <!-- Footer Section -->
   <footer class="py-12 bg-gray-900 text-gray-100 text-center mt-auto">
    <p>&copy; 2024 FoodTruck.Lk. All rights reserved.</p>
    <p>Follow us on <a href="#" class="text-yellow-500">Social Media</a></p>
  </footer>

</body>
</html>
