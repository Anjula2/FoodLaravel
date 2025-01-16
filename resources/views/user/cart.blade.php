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
                    <span class="ml-2">Cart [{{$count}}]</span>
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

  <!-- Main Content Section -->
  <div class="flex-grow p-10 text-center">
  <div class="bg-white shadow-md rounded-lg p-4 mb-6">
  <!-- "View My Orders" button -->
      @if(auth()->check())
          <div class="mb-4 flex justify-between items-center bg-yellow-100 p-4 rounded-lg">
              <h2 class="text-lg font-semibold text-gray-700">Hello, {{ Auth::user()->name }}!</h2>
              <a href="{{url('myorders')}}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition font-bold">View My Orders [{{$orderCount}}]</a>
          </div>
      @endif
    </div>
    <!-- Cart Table -->
    <table class="table-auto mx-auto w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
      <thead>
        <tr class="bg-yellow-500 text-white">
          <th class="px-6 py-3 text-lg font-bold">
            <input type="checkbox" id="select-all" class="form-checkbox text-yellow-500" onclick="toggleSelectAll()" />
          </th>
          <th class="px-6 py-3 text-lg font-bold">Product Name</th>
          <th class="px-6 py-3 text-lg font-bold">Quantity</th>
          <th class="px-6 py-3 text-lg font-bold">Price</th>
          <th class="px-6 py-3 text-lg font-bold">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cart as $carts)
        <tr class="border-b hover:bg-blue-100">
          <td class="px-6 py-4">
            <input type="checkbox" class="row-checkbox form-checkbox text-yellow-500" 
                   data-id="{{ $carts->id }}" 
                   data-name="{{ $carts->product_title }}" 
                   data-quantity="{{ $carts->quantity }}" 
                   data-price="{{ $carts->price }}" 
                   onclick="updateReceipt()" />
          </td>
          <td class="px-6 py-4 text-gray-700">{{ $carts->product_title }}</td>
          <td class="px-6 py-4 text-gray-700">{{ $carts->quantity }}</td>
          <td class="px-6 py-4 text-gray-700">{{ $carts->price }}</td>
          <td class="px-6 py-4 text-gray-700">
            <a href="{{url('delete',$carts->id)}}" class="inline-block px-4 py-2 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-300">Delete</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

<!-- Delivery Method Section -->
<div class="mt-8 bg-yellow-50 p-6 rounded-lg shadow-lg max-w-lg mx-auto">
  <label class="text-lg font-semibold text-gray-800">Choose Delivery Method:</label>
  <div class="flex items-center justify-center space-x-6 mt-4">
    <!-- Pick-Up Option -->
    <label class="flex items-center space-x-3 cursor-pointer p-4 border-2 border-transparent hover:border-yellow-500 rounded-lg transition duration-300 ease-in-out hover:shadow-lg">
      <input type="radio" name="delivery_method" value="pickup" class="form-radio text-yellow-500" onclick="updateReceipt()" checked />
      <div class="flex items-center space-x-2">
        <i class="fas fa-car text-yellow-500 text-2xl"></i>
        <span class="text-xl font-semibold text-gray-700">Pick-Up</span>
      </div>
    </label>

    <!-- Delivery Option -->
    <label class="flex items-center space-x-3 cursor-pointer p-4 border-2 border-transparent hover:border-yellow-500 rounded-lg transition duration-300 ease-in-out hover:shadow-lg">
      <input type="radio" name="delivery_method" value="delivery" class="form-radio text-yellow-500" onclick="updateReceipt()" />
      <div class="flex items-center space-x-2">
        <i class="fas fa-truck text-yellow-500 text-2xl"></i>
        <span class="text-xl font-semibold text-gray-700">Delivery (+Rs. 300)</span>
      </div>
    </label>
  </div>
</div>

    <!-- Receipt Section -->
    <form action="{{ route('order.store') }}" method="POST">
  @csrf
  <input type="hidden" name="cart_data" id="cart-data" value="">

  <div id="order-receipt" class="mt-10 hidden max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg border-t-4 border-green-500" style="background-image: url('images/Receipt1.jpg'); background-size: cover; background-position: center;">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Order Receipt</h2>

    <div class="space-y-6">
      <!-- Customer Info Section -->
      <div class="space-y-4">
        <div class="flex items-center text-lg">
          <i class="fas fa-user text-blue-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Customer Name:</strong>
          <span id="receipt-user-name" class="font-semibold text-gray-900 ml-2">{{ $user->name }}</span>
        </div>
        <div class="flex items-center text-lg">
          <i class="fas fa-phone text-green-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Contact Number:</strong>
          <span id="receipt-user-phone" class="font-semibold text-gray-900 ml-2">{{ $user->phone }}</span>
        </div>
        <div class="flex items-center text-lg">
          <i class="fas fa-map-marker-alt text-red-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Customer Address:</strong>
          <span id="receipt-user-address" class="font-semibold text-gray-900 ml-2">{{ $user->address ?? 'N/A' }}</span>
        </div>
      </div>

      <hr class="border-t-2 border-gray-200">

      <!-- Order Summary Section -->
      <div class="space-y-4">
        <div class="flex items-center text-lg">
          <i class="fas fa-layer-group text-yellow-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Item Name(s):</strong>
          <span id="receipt-item-name" class="font-semibold text-gray-900 ml-2">
            @foreach($cart as $item)
              {{ $item->product_title }} @if(!$loop->last), @endif
            @endforeach
          </span>
        </div>
        <div class="flex items-center text-lg">
          <i class="fas fa-layer-group text-yellow-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Total Items:</strong>
          <span id="receipt-quantity" class="font-semibold text-gray-900 ml-2">0</span>
        </div>
        <div class="flex items-center text-lg">
          <i class="fas fa-truck text-blue-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Delivery Method:</strong>
          <span id="receipt-delivery-method" class="font-semibold text-gray-900 ml-2">Pick-Up</span>
        </div>
        <div class="flex items-center text-lg">
          <i class="fas fa-dollar-sign text-red-500 text-xl"></i>
          <strong class="ml-4 text-gray-700">Total Price:</strong>
          <span id="receipt-total" class="font-semibold ml-2  text-yellow-700 bg-yellow-100 px-2 py-1 rounded-full">Rs. 0.00</span>
        </div>
      </div>

      <hr class="border-t-2 border-gray-200">

      <!-- Confirm Order Button -->
      <div class="mt-6 text-center">
        <button type="submit" class="px-8 py-3 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-300 shadow-lg transform hover:scale-105">
          Place Order
        </button>
      </div>
    </div>
  </div>
</form>
  </div>

   <!-- Footer Section -->
   <footer class="py-12 bg-gray-900 text-gray-100 text-center mt-auto">
    <p>&copy; 2024 FoodTruck.Lk. All rights reserved.</p>
    <p>Follow us on <a href="#" class="text-yellow-500">Social Media</a></p>
  </footer>
  
  <script>
    function toggleSelectAll() {
      const selectAll = document.getElementById('select-all').checked;
      document.querySelectorAll('.row-checkbox').forEach(checkbox => checkbox.checked = selectAll);
      updateReceipt();
    }

    function updateReceipt() {
    const selectedItems = [];
    let total = 0;
    let quantity = 0;

    document.querySelectorAll('.row-checkbox:checked').forEach(checkbox => {
        const row = checkbox.closest('tr');
        const price = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace('Rs. ', ''));
        const qty = parseInt(row.querySelector('td:nth-child(3)').textContent);
        selectedItems.push(row.querySelector('td:nth-child(2)').textContent);
        total += price;
        quantity += qty;
    });

    const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
    const deliveryFee = deliveryMethod === 'delivery' ? 300 : 0;
    total += deliveryFee;

    // Only update and show receipt if there are selected items
    if (selectedItems.length > 0) {
        document.getElementById('receipt-delivery-method').textContent = 
            deliveryMethod === 'delivery' ? 'Delivery (+Rs. 300)' : 'Pick-Up';
        document.getElementById('receipt-item-name').textContent = selectedItems.join(', ') || 'No items selected';
        document.getElementById('receipt-quantity').textContent = quantity;
        document.getElementById('receipt-total').textContent = `Rs. ${total.toFixed(2)}`;
        document.getElementById('order-receipt').classList.remove('hidden');
    } else {
        // Hide the receipt if no items are selected
        document.getElementById('order-receipt').classList.add('hidden');
    }

    const cartData = {
        items: selectedItems,
        total_price: total, 
        total_items: quantity,  
        delivery_method: deliveryMethod
    };

    document.getElementById('cart-data').value = JSON.stringify(cartData);
}

  </script>
</body>
</html>
