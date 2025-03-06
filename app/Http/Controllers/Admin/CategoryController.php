<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Categories;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Categories::all();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Categories $categories)
    {
        return view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $categoryRequest)
    {
        Categories::create([
            'name'=>$categoryRequest->title,
            'images_category'=> '/'.$categoryRequest->category_img,
        ]);

        return redirect()->back()->with('success','The category has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories=Categories::findOrFail($id);
        return view('admin.category.edit',compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $categoryRequest,$id)
    {
        $categories=Categories::findOrFail($id);
    
        if (!$categories) {
            return redirect()->back()->with('error', 'Category not available.');
        }

        $categories->update([
            'name' => $categoryRequest->title,
            'images_category'=> '/'.$categoryRequest->category_img,
        ]);
    
        return redirect()->back()->with('success', 'The category has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categories=Categories::findOrFail($id);
        $categories->delete();
        return redirect()->back()->with('success','Category successfully delete');
    }
}
