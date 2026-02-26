<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController 
{
    /**
     * Display the home page with featured products.
     */
    public function index()
    {
        $latestProducts = Product::with('user')
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('latestProducts'));
    }
}
