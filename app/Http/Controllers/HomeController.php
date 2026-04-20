<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product ;

class HomeController extends Controller
{
    public function index()
    {
        $newArrivals = Product::where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('newArrivals'));
    }
}
