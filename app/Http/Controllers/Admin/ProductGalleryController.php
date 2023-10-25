<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\User;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('pages.admin.product-gallery.index', [
            'productGalleries' =>ProductGallery::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.product-gallery.create', [
            'products'=>Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->file('photo')->store('assets/product');

        $validateData = $request->validate([
            'products_id' =>'required|exists:products,id',
            'photos' =>'required|image', 
        ]);
        
        if($request->file('photos')){
            $validateData['photos'] = $request->file('photos')->store('assets/photos');
        }
        
        ProductGallery::create($validateData);

        return redirect()->route('product-gallery.index')->with('success', 'Product Gallery successfully created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductGallery $product_gallery)
    {
        ProductGallery::destroy($product_gallery->id);
        Storage::delete($product_gallery->photos);
        return redirect()->route('product-gallery.index')->with('success', 'Product Gallery successfully deleted!');
    }

}
