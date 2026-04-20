<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order ; 

class OrderController extends Controller
{
    

        public function index(){

            $order = Order::with("user")->latest()->paginate(6) ; 

            return view('admin.orders.index' , compact("order")) ; 

        }


        public function updateStatus(Request $resuest , Order $order){

                $validated = $request->validate([
                    'status' => "required|in:pending,completed,canceled",
                ]) ; 

                // $order->status = $request->status ; 

                // $order->save()  ; 

                $order->update(["status"=>$request->status]) ; 


                return redirect()->back()->with('success', "order status updated successfully!") ; 


        }

        


}
