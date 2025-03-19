<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Отримати меню.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function menu() {
        return response()->json([
            'starters' => Menu::where('category_id', 1)->take(3)->get(),
            'mains' => Menu::where('category_id', 2)->take(3)->get(),
            'pastries_And_Drinks' => Menu::where('category_id', 3)->take(3)->get(),
        ],200);
    }

    /**
     * Отримати повне меню, включаючи категорії та страви.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fullmenu() {
        $categories = Categories::with('menu')->get();

        if($categories->isEmpty()) {
            return response()->json([
                'message' => 'Категорії меню не знайдені'
            ],404);
        }

        return response()->json($categories,200);
    }

    /**
     * Отримати пости блогу з пагінацією.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function blog() {
        $post=Post::paginate(6);

        if($post->isEmpty()){
            return response()->json([
                'message' => 'Пости не знайдені'
            ],404);
        }

        return response()->json($post,200);
    }

    /**
     * Отримати деталі поста та пов'язані пости.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function post($id) {
        $post=Post::findOrFail($id);

        if(!$post){
            return response()->json([
                'message' => 'Пост не знайдено.'
            ],404);
        }

        $related_posts=Post::inRandomOrder()->take(2)->get();

        return response()->json([
            'post'=>$post,
            'related_posts'=>$related_posts,
        ],200);
    }


}


