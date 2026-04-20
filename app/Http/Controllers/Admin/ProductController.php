<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product ; 
use App\Models\Category ;

class ProductController extends Controller
{
        
        //show all products
        public function index(){

                $products = Product::with("categories")->get() ; 

                return view('admin.products.index', compact('products')) ; 
        }


        //show a from to create new product 
        public function create(){
            
            $categories = Category::pluck("name" , "id") ; 
            return view('admin.products.create' , compact('categories')) ; 
        }

        public function store(Request $request){
                
                $validated = $request->validate([
                        'cat_id'=>'required|exists:categories,id' , 
                        'name'=>'required|string|min:10' , 
                        "price"=>"required|numeric|between:10,500" , 
                        "description"=>"nullable|string|max:255" , 
                        "stock_quantity"=>"required|numeric|min:0|max:500" , 
                        "image"=>"nullable|image" , 
                        "is_active"=>"required|boolean" , 

                ]) ; 
                
                $validated['slug'] = str($request->name)->slug() ; 

                if($request->hasFile("image")){
                        $path = $request->file('image')->store('products',"public") ;
                        $validated["image"]= $path ; 
                }

                Product::create($validated) ; 
                
                return redirect()->route('admin.products.index')->with('success' , "Product created!")  ; 

        }


        public function edit($id){

                $product = Product::findOrFail($id) ; 
                $categories = Category::pluck('name' , "id")  ;
                return view('admin.products.edit' , compact('product' , 'categories')) ; 

        }

        public function update(Request $request  , Product $product){
                
                $validated = $request->validate([
                        'cat_id'=>'required|exists:categories,id' , 
                        'name'=>'required|string|min:10' , 
                        "price"=>"required|numeric|between:10,500" , 
                        "description"=>"nullable|string|max:255" , 
                        "stock_quantity"=>"required|numeric|min:0|max:500" , 
                        "image"=>"nullable|image" , 
                        "is_active"=>"required|boolean" , 

                ]) ; 
                
                $validated['slug']= str($request->name)->slug() ; 

                if($request->hasFile('image')){
                        $path = $request->file('image')->store('products' , "public") ; 
                        $validated['image'] = $path ; 
                }

                $product->update($validated) ; 
                return redirect()->route('admin.products.index')->with('success', "Product updated successfully!");
        }


        public function destroy (Product $product){
                $product->delete() ;
                return redirect()->route('admin.products.index')->with('success' , "Product Deleted!") ;
        }
}
