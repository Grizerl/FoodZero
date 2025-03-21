<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\MenuRequest\MenuStoreRequest;
use App\Models\Menu;

class MenuController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Menu::all(),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $menuStoreRequest)
    {
        $menu = Menu::create($menuStoreRequest->all());
        
        return response()->json([
            'menu' => $menu,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return response()->json($menu, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MenuStoreRequest $menuStoreRequest, Menu $menu)
    {
       $menu->update($menuStoreRequest->all());

       return response()->json([
            'menu' => $menu,
       ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Category remove'
        ], 204);
    }
}
