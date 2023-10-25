<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(20);
        return view('pages.category',[
            'categories' => $categories,
            'products' => $products,
        ]);
    }
    public function detail(Request $request, $slug)
    {
        $categories = Category::all();

        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::where('categories_id', $category->id)->paginate(20);
        return view('pages.category',[
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
