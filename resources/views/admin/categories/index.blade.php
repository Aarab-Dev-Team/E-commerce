@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Categories</h2>
                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        + Add Category
                    </a>
                </div>

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($categories->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Slug</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Parent</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Products</th>
                                    <th class="border border-gray-300 px-4 py-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-500 hover:underline">
                                                {{ $category->name }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $category->slug }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            @if ($category->parent)
                                                {{ $category->parent->name }}
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            {{ $category->products()->count() }}
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                @else
                    <p class="text-gray-500">No categories found. <a href="{{ route('admin.categories.create') }}" class="text-blue-500 hover:underline">Create one</a></p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
