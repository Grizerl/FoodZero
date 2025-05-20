<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Posts\StorePostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Post::all(), 200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Api\Admin\Posts\StorePostRequest $storePostRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $storePostRequest)
    {
        $post = Post::create($storePostRequest->all());
        return response()->json([
         'post' => $post,
        ], 201);
    }

    /**
     * Summary of show
     * @param \App\Models\Post $post
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Api\Admin\Posts\StorePostRequest $storePostRequest
     * @param \App\Models\Post $post
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(StorePostRequest $storePostRequest, Post $post)
    {
        $post->update($storePostRequest->all());

        return response()->json([
             'post' => $post,
        ], 200);
    }


    /**
     * Summary of destroy
     * @param \App\Models\Post $post
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json([
            'message' => 'Post remove'
        ], 204);
    }
}
