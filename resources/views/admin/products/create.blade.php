<x-app-layout>

    <x-slot  name="header">

        <h1 class="text-xl font-semibold text-gray-800">Create Product</h1>

    </x-slot>

    <div class="py-12">

        </div class="max-w-7xl mx-auto sm:px-6  ">
            <div class="bg-white p-6 shadow sm:rounded-lg   text-center  ">
                    <form action="{{route('admin.products.store')}}" method="POST" enctype="multipart/form-data">

                        @csrf 
                        <div class="mb-4">
                                <label>Product  :</label><br>
                                <input
                                type="text"
                                name="name"
                                required 
                                value = "{{old('name')}}"
                                >

                                <br>
                                @error('name')
                                    <span class="bg-red-400">{{$message}}</span>
                                @enderror

                        </div>

                        <div class="mb-4">
                            <label>Price : </label><br>

                            <input
                            type="number"
                            step="0.01"
                            name="price"
                            required 
                            value = "{{old('price')}}"
                            >

                            <br>
                            @error('price')
                                <span class="bg-red-400">{{$message}}</span>
                            @enderror

                        </div>
                        
               
                        <div class="mb-4">
                            <label>Stock Quantity : </label><br>


                            <input
                            type="number"
                            step="1"
                            name="stock_quantity"
                            required 
                            value = "{{old('stock_quantity')}}"
                            >

                            <br>
                            @error('stock_quantity')
                                <span class="bg-red-400">{{$message}}</span>
                            @enderror

                        </div>
                    
                        <select name="cat_id" value="{{ old('cat_id') }}">
                            <option value="" selected disabled>select Category</option>
                            @foreach($categories as $id=> $name)

                                <option value="{{ $id }}" >{{$name}}</option>

                            @endforeach

                             

                        </select>
                        <br>
                        @error('cat_id')
                                <span class="bg-red-400">{{$message}}</span>
                        @enderror

                        <div class="mb-4">
                            <label for="image" >Product Image : </label><br>
                            <input
                                type="file"
                                name="image"
                                id="image"
                            >

                            <br>
                            @error('image')
                                    <span class="bg-red-400">{{$message}}</span>
                            @enderror

                        </div>

                        <div class="mb-4">  

                            <input  
                                type="hidden"
                                name="is_active"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="is_active"
                                value="1" 
                            >

                        </div>

                        <button type="submit" class="bg-green-500 text-black rounded-sm p-4 " >Save</button>



                    </form>
            </div>
        </div>

    </div>




</x-app-layout>