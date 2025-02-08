<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;

class ProductController
{

    public function index()
    {
        return Product::all();
    }

}
