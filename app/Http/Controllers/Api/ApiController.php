<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;

class ApiController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function menu()
    {
        return response()->json([
            'starters' => Menu::where('category_id', 1)->take(3)->get(),
            'mains' => Menu::where('category_id', 2)->take(3)->get(),
            'pastries_And_Drinks' => Menu::where('category_id', 3)->take(3)->get(),
        ], 200);
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function fullmenu()
    {
        $categories = Category::with('menu')->get();

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'Категорії меню не знайдені'
            ], 404);
        }

        return response()->json($categories, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function blog()
    {
        $post = Post::paginate(6);

        if ($post->isEmpty()) {
            return response()->json([
                'message' => 'Пости не знайдені'
            ], 404);
        }

        return response()->json($post, 200);
    }

    /**
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function post(int $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return response()->json([
                'message' => 'Post is not found.'
            ], 404);
        }

        $related_posts = Post::inRandomOrder()->take(2)->get();

        return response()->json([
            'post' => $post,
            'related_posts' => $related_posts,
        ], 200);
    }

}
