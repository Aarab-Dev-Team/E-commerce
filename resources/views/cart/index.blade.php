<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Your Shopping Cart</h1>

            @if (session("error"))
                <p class="bg-red-300 text-red-900">{{session('error')}}</p>
                
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="pb-4">Product</th>
                            <th class="pb-4 text-center">Price</th>
                            <th class="pb-4 text-center">Quantity</th>
                            <th class="pb-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp

                        {{-- Use the variable $cart passed from the controller --}}
                        @forelse($cart as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4 flex items-center">
                                    <img src="{{ asset('storage/' . $details['image']) }}" class="w-12 h-12 rounded mr-4 object-cover">
                                    <span class="font-medium">{{ $details['name'] }}</span>
                                </td>
                                <td class="py-4 text-center">${{ number_format($details['price'], 2) }}</td>
                                <td class="py-4 text-center">{{ $details['quantity'] }}</td>
                                <td class="py-4 text-right font-bold">
                                    ${{ number_format($details['price'] * $details['quantity'], 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-500">
                                    <p class="text-lg">Your cart is empty.</p>
                                    <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Continue Shopping</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if(count($cart) > 0)
                    <div class="mt-8 flex justify-between items-center">
                        <div class="text-gray-600">
                            {{ count($cart) }} Items in your basket
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Total Amount:</p>
                            <p class="text-3xl font-bold text-indigo-600">${{ number_format($total, 2) }}</p>
                            
                            {{-- This link will trigger the Login/Checkout flow --}}

                            <form action="{{ route('orders.store') }}" method="POST">
                                    <div class="flex flex-col">

                                    <textarea name="address" placeholder="your address .." class="form-control"></textarea>
                                    @error("address")
                                        <p class="text-bold text-red-800">{{$message}}</p>
                                    @enderror
                                    <button
                                    class="mt-4 inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-indigo-700 transition"
                                    type="submit">

                                        Proceed to Checkout
                                    </button>
                                    </div>
                            </form>
                     
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>