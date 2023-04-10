<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('back.index', [
            'cafeCount' => Cafe::all()->count(),
            'categoryCount' => Category::all()->count(),
            'productCount' => Product::all()->count()
        ]);
    }
}
