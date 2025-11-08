<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductCardController extends Controller
{

 public function index(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(4);
        
        $bgColors = [
            'bg-[#B68B4B]', 
            'bg-[#EED2A4]', 
            'bg-[#FFF4E7]', 
            'bg-[#F0EFE7]',
        ];

        return view('userPage.home',  compact('products', 'bgColors'));
    }
}

