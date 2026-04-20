<x-guest-layout>

    <x-slot  name="header" >
        <h1>Ecommerce   </h1>

        <div class="flex flex-row-reverse ">
                    <a href="{{ route('cart.index') }}" >

              <i class="bi bi-basket text-2xl "></i>
        </a>
              <h2 class="bg-purple-500 p-2 mt-2 rounded-full w-[24px] h-[24px] flex justify-center items-center ">{{$count}}</h2>

        </div>

    </x-slot>   
    <div class="py-12 bg-gray-50">
        <div class="mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-8 text-gray-800">Our Products</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">  
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                             class="h-48 w-full object-cover">
                        
                        <div class="p-4 flex-grow">
                            <h2 class="font-bold text-lg text-gray-900">{{ $product->name }}</h2>
                            <p class="text-gray-500 text-sm mb-2">{{ $product->categories->name }}</p>
                            <p class="text-indigo-600 font-bold text-xl">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <div class="p-4 border-t flex gap-2">

                            <a href="{{ route('shop.show', $product->slug) }}" 
                               class="block flex-1 text-center bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                View Details
                            </a>

                            <form action="#"   method="POST">
                                    <button type="submit"
                                    title="add to cart"

                                     class="block text-center bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                                
                                    +
                                    </button>
                            </form>
                       
                        </div>

                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-guest-layout>