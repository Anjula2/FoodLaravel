<!-- Product Section -->
<section class="py-5">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($data as $product)
        <div class="bg-white p-6 shadow-lg rounded-lg transition-all hover:shadow-xl hover:scale-105 transform">
          <div class="overflow-hidden rounded-lg">
            <img src="/storage/{{$product->image_path}}" alt="{{$product->name}}" class="w-full h-48 object-cover rounded-md transition-transform duration-300 transform hover:scale-110">
          </div>
          <div class="mt-4">
            <h2 class="text-xl font-semibold text-gray-800 hover:text-red-500 transition-all">{{$product->name}}</h2>
            <p class="mt-2 text-gray-600 text-sm">{{$product->description}}</p>
            <p class="mt-2 text-gray-700 font-semibold text-lg">Rs.<span class="dynamic-price">{{$product->price}}</span></p>
          </div>

          <form action="{{url('addcart', $product->id)}}" method="POST" class="product-form mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-2">
                <input type="number" value="1" min="1" class="w-16 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 quantity-input" name="quantity" data-price="{{$product->price}}">
              </div>
              <input type="hidden" name="calculated_price" class="calculated-price" value="{{ $product->price }}">
              <input type="submit" value="Add to Cart" class="inline-block px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all cursor-pointer">
            </div>
          </form>
        </div>
      @endforeach
    </div>

    @if ($data->hasPages())
  <div class="flex justify-center mt-6">
    <div class="flex items-center space-x-4">
      {{-- Previous Button --}}
      @if ($data->onFirstPage())
        <button class="px-4 py-2 text-gray-500 bg-gray-200 rounded-full cursor-not-allowed" disabled>
          <i class="fas fa-chevron-left"></i>
        </button>
      @else
        <a href="{{ $data->previousPageUrl() }}" class="px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition">
          <i class="fas fa-chevron-left"></i>
        </a>
      @endif

      {{-- Page Links --}}
      @foreach ($data->links() as $link)
        <a href="{{ $link->url }}" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-full hover:bg-blue-100 transition">{{ $link->label }}</a>
      @endforeach

      {{-- Next Button --}}
      @if ($data->hasMorePages())
        <a href="{{ $data->nextPageUrl() }}" class="px-4 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition">
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
        priceElement.textContent = `Rs. ${totalPrice.toFixed(2)}`; 
        hiddenPriceInput.value = totalPrice.toFixed(2); 
      }
    });
  });
</script>
