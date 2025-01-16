<section class="py-12 mt-12 mb-12 relative" style="background-image: url('images/bg-image.jpg');background-size: cover; 
                background-position: center; 
                background-repeat: no-repeat;">
  <!-- Gradient Overlay -->
  <div class="absolute inset-0 bg-black opacity-50 z-0"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
  <h1 class="text-3xl font-extrabold text-center text-white mb-10 relative z-20">Your Choicess</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      @foreach($requestdata as $customerrequest)
      @if($customerrequest->is_accepted)
        <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 hover:scale-105">
          <!-- Image Section with Outline -->
          <div class="relative bg-gradient-to-br from-blue-100 to-blue-300 p-6 flex items-center justify-center outline outline-4 outline-blue-500 rounded-t-2xl">
            <div class="relative rounded-full overflow-hidden w-40 h-40 bg-white shadow-md outline outline-4 outline-white">
              <img src="/storage/{{$customerrequest->image_path}}" alt="{{$customerrequest->meal_name}}" class="w-full h-full object-cover">
            </div>
          </div>
          <!-- Content Section -->
          <div class="p-6">
            <h2 class="text-2xl font-bold text-center text-blue-900 mb-2">{{$customerrequest->meal_name}}</h2>
            <p class="text-sm text-gray-600 font-bold  text-center mb-4">{{$customerrequest->description}}</p>
            <p class="text-2xl text-red-500 font-bold text-center">Rs.<span class="dynamic-price">{{$customerrequest->price}}</span></p>
            <!-- Add to Cart Form -->
            <form action="{{url('addcartNew', $customerrequest->id)}}" method="POST" class="mt-6">
              @csrf
              <div class="flex items-center justify-between">
                <!-- Quantity Input -->
                <div class="w-20">
                  <input type="number" value="1" min="1" name="quantity" class="w-full p-2 text-center border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 quantity-input text-black" data-price="{{$customerrequest->price}}">
                </div>
                <!-- Add to Cart Button -->
                <button type="submit" class="w-40 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:from-blue-600 hover:to-blue-800">
                  Add to Cart
                </button>
              </div>
              <input type="hidden" name="calculated_price" class="calculated-price" value="{{ $customerrequest->price }}">
            </form>
          </div>
        </div>
        @endif
      @endforeach
    </div>

    @if ($requestdata->hasPages())
  <div class="flex justify-center mt-8">
    <div class="flex items-center space-x-4">
      {{-- Previous Button --}}
      @if ($requestdata->onFirstPage())
        <button class="px-4 py-2 text-gray-500 bg-gray-200 rounded-full cursor-not-allowed" disabled>
          <i class="fas fa-chevron-left"></i>
        </button>
      @else
        <a href="{{ $requestdata->previousPageUrl() }}" class="px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition">
          <i class="fas fa-chevron-left"></i>
        </a>
      @endif

      {{-- Page Links --}}
      @foreach ($requestdata->links() as $link)
        <a href="{{ $link->url }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-full hover:bg-blue-100 transition">{{ $link->label }}</a>
      @endforeach

      {{-- Next Button --}}
      @if ($requestdata->hasMorePages())
        <a href="{{ $requestdata->nextPageUrl() }}" class="px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition">
          <i class="fas fa-chevron-right"></i>
        </a>
      @else
        <button class="px-4 py-2 text-gray-500 bg-gray-200 rounded-full cursor-not-allowed" disabled>
          <i class="fas fa-chevron-right"></i>
        </button>
      @endif
    </div>
  </div>
@endif

  </div>
</section>

<script>
  document.querySelectorAll('.product-form').forEach(form => {
    const quantityInput = form.querySelector('.quantity-input');
    const priceElement = form.querySelector('.dynamic-price');  
    const hiddenPriceInput = form.querySelector('.calculated-price');
    const basePrice = parseFloat(quantityInput.dataset.price);

    quantityInput.addEventListener('input', function() {
      const quantity = parseInt(quantityInput.value);
      if (quantity >= 1) {
        const totalPrice = basePrice * quantity;
        priceElement.textContent = `${totalPrice.toFixed(2)}`; 
        hiddenPriceInput.value = totalPrice.toFixed(2); 
      }
    });
  });
</script>
