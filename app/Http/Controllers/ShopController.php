<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class ShopController extends Controller
{

    public function index()
    {
        return view('shop.products', [
            'products' => Product::all(),
        ]);
    }



}
