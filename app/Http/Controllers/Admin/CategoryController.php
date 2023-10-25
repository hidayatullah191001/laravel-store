<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('pages.admin.category.index', [
            'categories' =>Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->file('photo')->store('assets/category');
        $validateData = $request->validate([
            'name' => 'required|string',
            'photo' => 'image|file|max:1024',
            'slug' => 'required|unique:categories',
        ]);

        if($request->file('photo')){
            $validateData['photo'] = $request->file('photo')->store('assets/category');
        }
        Category::create($validateData);

        return redirect()->route('category.index')->with('success', 'Category successfully created!');

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
    public function edit(Category $category)
    {
        return view('pages.admin.category.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [ 
            'name' => 'required|string',
            'photo' => 'image|file|max:1024',
        ];

        if ($request->slug != $category->slug) {
            $rules['slug'] = 'required|unique:categories';
        }

        $validateData = $request->validate($rules);

        if ($request->file('photo')) {
            if($request->oldImage){
                Storage::delete($request->oldImage);
            }
            $validateData['photo'] = $request->file('photo')->store('assets/category');
        }

        Category::where('id', $category->id)->update($validateData);
        return redirect()->route('category.index')->with('success', 'Category successfully updated!');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        Category::destroy($category->id);
        Storage::delete($category->photo);
        return redirect()->route('category.index')->with('success', 'Category successfully deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
