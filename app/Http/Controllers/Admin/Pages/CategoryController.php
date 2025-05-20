<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $categories = Category::paginate(15);
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Models\Category $categories
     * @return View
     */
    public function create(Category $categories): View
    {
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\Admin\CategoryRequest $categoryRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $categoryRequest)
    {
        Category::create([
            'name' => $categoryRequest->title,
            'images_category' => '/'.$categoryRequest->category_img,
        ]);

        return redirect()->back()->with('success', 'The category has been successfully created.');
    }

    /**
     * Display the specified resource.
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function show(): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *  @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $categories = Category::findOrFail($id);
        return view('admin.category.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param \App\Http\Requests\Admin\CategoryRequest $categoryRequest
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CategoryRequest $categoryRequest, int $id): RedirectResponse
    {
        $categories = Category::findOrFail($id);

        $categories->update([
            'name' => $categoryRequest->title,
            'images_category' => '/'.$categoryRequest->category_img,
        ]);

        return redirect()->back()->with('success', 'The category has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Category successfully delete');
    }
}
