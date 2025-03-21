<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Posts\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $storePostRequest)
    {
       $post = Post::create($storePostRequest->all());
       return response()->json([
        'post' => $post,
       ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $storePostRequest, Post $post)
    {
       $post->update($storePostRequest->all());

       return response()->json([
            'post' => $post,
       ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post remove'
        ], 204);
    }
}
