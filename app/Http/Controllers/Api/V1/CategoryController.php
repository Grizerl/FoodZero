<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Category\CategoryStoreRequest;
use App\Models\Categories;

class CategoryController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Categories::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $categoryStoreRequest)
    {
       $category = Categories::create($categoryStoreRequest->all());
       return response()->json([
        'category' => $category,
       ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categories $category)
    {
        return response()->json($category,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreRequest $categoryStoreRequest, Categories $category)
    {
       $category->update($categoryStoreRequest->all());

       return response()->json([
            'category' => $category,
       ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categories $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category remove'
        ], 204);
    }
}
