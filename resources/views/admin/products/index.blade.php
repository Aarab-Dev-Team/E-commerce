<x-app-layout>


        <x-slot name="header" >

                <div class="flex justify-between">
                      <h1> All Products </h1>

                <a 
                    href="{{route('admin.products.create')}}"

                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ">
                    + Add Product 
                </a>

                </div>



        </x-slot>



        <div class="py-12">
        
        @if(isset($products) && $products->isNotEmpty())

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <table class="min-w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">Name</th>
                                <th class="border p-2">Category</th>
                                <th class="border p-2">Price</th>
                                <th class="border p-2">Stock</th>
                                <th class="border p-2">Status</th>
                                <th class="border p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="border p-2">{{ $product->name }}</td>
                                    <td class="border p-2">{{ $product->categories->name }}</td>
                                    <td class="border p-2">${{ $product->price }}</td>
                                    <td class="border p-2">{{ $product->stock_quantity }}</td>
                                    <td class="border p-2">
                                        {{ $product->is_active ? '✅ Active' : '❌ Inactive' }}
                                    </td>
                                    <td class="flex gap-2">
                                        <form action="{{ route('admin.products.destroy' , $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-400 text-red-900 p-2">Delete</button>
                                        </form>
                                        <div class="flex-1 ">
                                        <form action="{{ route('admin.products.edit' , $product->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="w-full bg-blue-400 text-blue-900 p-2">EDIT</button>
                                        </form>
                                        </div>
                                    
                                    </td>
                                </tr>
                                
                             

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @else

                <div class="mx-6 bg-yellow-400 text-center">
                    <p>There are no products currently available in this section.</p>
                </div>
        @endif

    </div>





</x-app-layout>