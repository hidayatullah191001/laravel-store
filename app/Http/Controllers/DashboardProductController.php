<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardProductController extends Controller
{
    public function index()
    {
        $products = Product::where('users_id', Auth::user()->id)->get();
        return view('pages.dashboard-products',[
            'products' => $products,
        ]);
    }

    public function details(Product $product)
    {
        return view('pages.dashboard-products-details', [
            'product' => $product,
            'categories' => Category::all(),
        ]);
    }
    public function create()
    {
        return view('pages.dashboard-products-create', [
            'categories' => Category::all(),
        ]);
    }
    
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' =>'required|max:255',
            'users_id' =>'required|exists:users,id', 
            'categories_id' =>'required|exists:categories,id', 
            'price' =>'required|integer', 
            'description' =>'required', 
            'slug' => 'required|unique:products',
        ]);

        $product = Product::create($validateData);

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product','public'),
        ];

        ProductGallery::create($gallery);
        return redirect()->route('dashboard-products')->with('success', 'Product berhasil ditambahkan');
    }

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
        return redirect()->route('dashboard-products')->with('success', 'Product successfully updated!');
    
    }

    public function uploadGallery(Request $request)
    {
        $validateData = $request->validate([
            'products_id' =>'required|exists:products,id',
            'photos' =>'required|image', 
        ]);
        
        if($request->file('photos')){
            $validateData['photos'] = $request->file('photos')->store('assets/photos'. 'public');
        }
        
        ProductGallery::create($validateData);
        $product = Product::findOrFail($request->products_id);

        return redirect()->route('dashboard-products-details',$product->slug)->with('success', 'Product Gallery successfully created!');
    }

    public function deleteGallery(Request $request, $id)
    {
        $gallery = ProductGallery::findOrFail($id);
        $gallery->delete();
        Storage::delete($gallery->photos);
        $product = Product::findOrFail($gallery->products_id);
        return redirect()->route('dashboard-products-details', $product->slug)->with('success', 'Product Gallery successfully deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

}
