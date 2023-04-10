<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * @param Cafe $cafe
     * @return Application|Factory|View
     */
    public function index(Cafe $cafe)
    {
        $cafes = Cafe::all();
        $categories = Category::where('cafe_id', $cafe->id)->get();

        return view('index', [
            'cafes' => $cafes,
            'categories' => $categories
        ]);
    }

    /**
     * @param Cafe $cafe
     * @return Application|Factory|View
     */
    public function cafeDetail(Cafe $cafe)
    {
        $categories = Category::where('cafe_id', $cafe->id)->get();
        return view('menu.index', [
            'cafe' => $cafe,
            'categories' => $categories
        ]);
    }

    /**
     * @param Cafe $cafe
     * @return Application|Factory|View
     */
    public function cafeMenu(Cafe $cafe)
    {
        $categories = Category::where('cafe_id', $cafe->id)->with('products')->get();

        return view('menu.menu', [
            'cafe' => $cafe,
            'categories' => $categories
        ]);
    }

    /**
     * @param Cafe $cafe
     * @param string $productSlug
     * @return Application|Factory|View
     */
    public function cafeProduct(Cafe $cafe, string $productSlug)
    {
        $product = Product::where('user_id', $cafe->user_id)->where('slug', $productSlug)->firstOrFail();

        return view('menu.detail', [
            'product' => $product
        ]);
    }
}
