<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRulesRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return View
     */
    public function index(): View
    {
        $options = Menu::paginate(15);
        return view('admin.menu.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Admin\MenuRulesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuRulesRequest $request): RedirectResponse
    {
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'images' => '/'.$request->images,
        ]);

        return redirect()->back()->with('success', 'The dish has been successfully created.');
    }

    /**
     * Summary of show
     * @return mixed|RedirectResponse
     */
    public function show(): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Summary of edit
     * @param \App\Models\Menu $menu
     * @return View
     */
    public function edit(Menu $menu): View
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Admin\MenuRulesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(MenuRulesRequest $request, int $id): RedirectResponse
    {
        $menu = Menu::findOrFail($id);

        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'images' => $request->images ? (strpos($request->images, '/') === 0 ? $request->images : '/' . $request->images) : $menu->images,
        ]);

        return redirect()->back()->with('success', 'The dish has been successfully updated.');
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return mixed|RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Menu::findOrFail($id)->delete();
        return redirect()->back();
    }
}
