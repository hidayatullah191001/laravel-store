<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ADmin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('pages.admin.product.index', [
            'products' =>Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.product.create', [
            'users'=>User::all(),
            'categories'=>Category::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->file('photo')->store('assets/product');

        $validateData = $request->validate([
            'name' =>'required|max:255',
            'users_id' =>'required|exists:users,id', 
            'categories_id' =>'required|exists:categories,id', 
            'price' =>'required|integer', 
            'description' =>'required', 
            'slug' => 'required|unique:products',
        ]);
        

        Product::create($validateData);

        return redirect()->route('product.index')->with('success', 'Product successfully created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('pages.admin.product.edit', [
            'product' => $product,
            'users'=>User::all(),
            'categories'=>Category::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [ 
            'name' =>'required|max:255',
            'users_id' =>'required|exists:users,id', 
            'categories_id' =>'required|exists:categories,id', 
            'price' =>'required|integer', 
            'description' =>'required', 
        ];

        if ($request->slug != $product->slug) {
            $rules['slug'] = 'required|unique:products';
        }

        $validateData = $request->validate($rules);
        
        Product::where('id', $product->id)->update($validateData);
        return redirect()->route('product.index')->with('success', 'Product successfully updated!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        return redirect()->route('product.index')->with('success', 'Product successfully deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
