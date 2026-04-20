<x-guest-layout>

    <x-slot name="header" >
                    <a href={{ route('shop.index') }}><- Show all products </a>

    </x-slot>
    <div class="py-12 bg-gray-50  mx-auto   max-w-xl">
        @if( session('error'))
                    
            <p class="text-red-800">=========={{session('error')}}=================</p>


        @endif

        
        <div class=" sm:px-6 lg:px-8">
            
                    <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/300' }}" 
                             class="h-48 w-full object-cover">
                        
                        <div class="p-4 flex-grow">
                            <h2 class="font-bold text-lg text-gray-900">{{ $product->name }}</h2>
                            <p class="text-gray-500 text-sm mb-2">
                                <b>Category : </b>
                                {{ $product->categories->name }}</p>
                                
                            <p class="text-gray-500 text-sm mb-2">
                                <b>Stock Quanitiy : </b>
                                {{ $product->stock_quantity }}</p>
                            
                             <p class="text-gray-500 text-sm mb-2">
                                <b>Description : </b>
                                {{ $product->description }}</p>

                            <p class="text-indigo-600 font-bold text-xl">
                                  <b>price : </b>
                                ${{ number_format($product->price, 2) }}</p>
                            

                            <div class="flex justify-between items-center mt-4">
                                <p class="text-gray-500 text-xs">
                                    &lt;&lt; {{ $product->slug }} &gt;&gt;
                                </p>

                                <form action="{{ route('cart.add'  , $product->id) }}" method="POST">
                                    @csrf 
                                    <div class="flex items-center gap-2">
                                        <input type="number" 
                                            name="quantity" 
                                            min="1" 
                                            value="1" 
                                            max="{{ $product->stock_quantity }}" 
                                            class="w-16 text-sm rounded border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">

                                        <button type="submit" 
                                                class="px-3 py-1 bg-green-400 text-green-900 text-sm font-bold rounded hover:bg-green-500 transition disabled:bg-gray-300 disabled:text-gray-500" 
                                                {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                            {{ $product->stock_quantity <= 0 ? 'Out of Stock' : 'Add To Cart' }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                          
                        </div>

                     
                    </div>
       


        </div>
    </div>
</x-guest-layout>