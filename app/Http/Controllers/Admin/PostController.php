<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post=Post::all();
        return view('admin.posts.index',compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $postRequest)
    {
        Post::create(
            [
                'title' => $postRequest->title,
                'description' => $postRequest->description,
                'images' => $postRequest->blog_images,
                'clients' => $postRequest->name,
                'clients_img' => $postRequest->customer_photo,
            ]
        );

        return redirect()->back()->with('success', 'Your post has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $postRequest, $id)
    {
        $post=Post::findOrFail($id);

        if(!$post) 
        {
            return redirect()->back()->with('success','Unable to find the post');
        }

        $post->update(
            [
                'title' => $postRequest->title,
                'description' => $postRequest->description,
                'images' => $postRequest->blog_images,
                'clients' => $postRequest->name,
                'clients_img' => $postRequest->customer_photo,
            ]);

        return redirect()->back()->with('success', 'The post was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully');
    }
}
