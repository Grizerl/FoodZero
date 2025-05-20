<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\MenuRequest\MenuStoreRequest;
use App\Models\Menu;

class MenuController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Menu::all(), 200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Api\Admin\MenuRequest\MenuStoreRequest $menuStoreRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(MenuStoreRequest $menuStoreRequest)
    {
        $menu = Menu::create($menuStoreRequest->all());

        return response()->json([
            'menu' => $menu,
        ], 201);
    }

    /**
     * Summary of show
     * @param \App\Models\Menu $menu
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Menu $menu)
    {
        return response()->json($menu, 200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Api\Admin\MenuRequest\MenuStoreRequest $menuStoreRequest
     * @param \App\Models\Menu $menu
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(MenuStoreRequest $menuStoreRequest, Menu $menu)
    {
        $menu->update($menuStoreRequest->all());

        return response()->json([
             'menu' => $menu,
        ], 200);
    }


    /**
     * Summary of destroy
     * @param \App\Models\Menu $menu
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json([
            'message' => 'Category remove'
        ], 204);
    }
}
