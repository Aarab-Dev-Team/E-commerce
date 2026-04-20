<x-app-layout>
    <x-slot name="header">

        <div class="flex justify-between">


            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Orders') }}
            </h2>

            <a href="{{ route('shop.index') }}"><- Go Back </a>


        </div>
   


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($orders->count() > 0)
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b text-gray-700">
                                <th class="py-4 px-2">Order ID</th>
                                <th class="py-4 px-2">Date</th>
                                <th class="py-4 px-2">Total</th>
                                <th class="py-4 px-2">Status</th>
                                <th class="py-4 px-2 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-4 px-2 font-bold text-indigo-600">#{{ $order->id }}</td>
                                    <td class="py-4 px-2 text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-2 font-semibold">${{ number_format($order->total_amount, 2) }}</td>
                                    <td class="py-4 px-2">
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ strtoupper($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500 text-lg">You haven't placed any orders yet.</p>
                        <a href="{{ route('products.index') }}" class="text-indigo-600 font-bold mt-2 inline-block">Start Shopping</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>