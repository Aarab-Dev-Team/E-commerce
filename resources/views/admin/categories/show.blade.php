@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">{{ $category->name }}</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Slug</h3>
                        <p class="text-gray-900">{{ $category->slug }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Parent Category</h3>
                        <p class="text-gray-900">
                            @if ($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-blue-500 hover:underline">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if ($category->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-600">Description</h3>
                        <p class="text-gray-900">{{ $category->description }}</p>
                    </div>
                @endif

                <hr class="my-6">

                <div class="mb-6">
                    <h3 class="text-lg font-bold mb-4">Subcategories ({{ $category->children->count() }})</h3>
                    @if ($category->children->count() > 0)
                        <ul class="list-disc list-inside">
                            @foreach ($category->children as $child)
                                <li>
                                    <a href="{{ route('admin.categories.show', $child) }}" class="text-blue-500 hover:underline">
                                        {{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No subcategories</p>
                    @endif
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4">Products ({{ $category->products->count() }})</h3>
                    @if ($category->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border-collapse border border-gray-300">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Price</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Stock</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->products as $product)
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">${{ number_format($product->price, 2) }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $product->stock_quantity }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($product->is_active)
                                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Active</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No products in this category</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
