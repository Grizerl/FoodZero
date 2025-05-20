<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Category\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Summary of index
     * @return JsonResponse|mixed
     */
    public function index(): JsonResponse
    {
        return response()->json(Category::all(), 200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Api\Admin\Category\CategoryStoreRequest $categoryStoreRequest
     * @return JsonResponse|mixed
     */
    public function store(CategoryStoreRequest $categoryStoreRequest)
    {
        $category = Category::create($categoryStoreRequest->all());
        return response()->json([
         'category' => $category,
        ], 201);
    }

    /**
     * Summary of show
     * @param \App\Models\Category $category
     * @return JsonResponse|mixed
     */
    public function show(Category $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Api\Admin\Category\CategoryStoreRequest $categoryStoreRequest
     * @param \App\Models\Category $category
     * @return JsonResponse|mixed
     */
    public function update(CategoryStoreRequest $categoryStoreRequest, Category $category)
    {
        $category->update($categoryStoreRequest->all());

        return response()->json([
             'category' => $category,
        ], 200);
    }


    /**
     * Summary of destroy
     * @param \App\Models\Category $category
     * @return JsonResponse|mixed
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category remove'
        ], 204);
    }
}
