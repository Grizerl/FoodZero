<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRulesRequest;
use App\Models\Categories;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options= Menu::all();
        return view('admin.menu.index',compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Categories::all();
        return view('admin.menu.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuRulesRequest $menuRequest)
    {
        Menu::create([
            'name'=>$menuRequest->name,
            'description'=>$menuRequest->description,
            'price'=>$menuRequest->price,
            'category_id' => $menuRequest->category_id,
            'images'=> '/'.$menuRequest->images,
        ]);

        return redirect()->back()->with('success','The dish has been successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories=Categories::all();
        return view('admin.menu.edit',compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuRulesRequest $menuRequest, $id)
    {
        $menu = Menu::findOrFail($id);
    
        if (!$menu) {
            return redirect()->back()->with('error', 'Dish not available.');
        }

        $menu->update([
            'name' => $menuRequest->name,
            'description' => $menuRequest->description,
            'price' => $menuRequest->price,
            'category_id' => $menuRequest->category_id,
            'images' => $menuRequest->images ? (strpos($menuRequest->images, '/') === 0 ? $menuRequest->images : '/' . $menuRequest->images) : $menu->images,
        ]);
    
        return redirect()->back()->with('success', 'The dish has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->back();
    }
}
