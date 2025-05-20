<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index(): View
    {
        $post = Post::paginate(15);
        return view('admin.posts.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \App\Http\Requests\Admin\PostRequest $postRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $postRequest): RedirectResponse
    {
        Post::create(
            [
                'title' => $postRequest->title,
                'description' => $postRequest->description,
                'images' => '/'.$postRequest->blog_images,
                'clients' => $postRequest->name,
                'clients_img' => '/'.$postRequest->customer_photo,
            ]
        );

        return redirect()->back()->with('success', 'Your post has been created successfully');
    }

    /**
     * Display the specified resource.
     * @return mixed|RedirectResponse
     */
    public function show(): RedirectResponse
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param \App\Models\Post $post
     * @return View
     */
    public function edit(Post $post): View
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * param \App\Http\Requests\Admin\PostRequest $postRequest
     * @param int $id
     * @return RedirectResponse
     */
    public function update(PostRequest $postRequest, int $id)
    {
        $post = Post::findOrFail($id);

        if (!$post) {
            return redirect()->back()->with('success', 'Unable to find the post');
        }

        $post->update(
            [
                'title' => $postRequest->title,
                'description' => $postRequest->description,
                'images' => $postRequest->blog_images ? (strpos($postRequest->blog_images, '/') === 0 ? $postRequest->blog_images : '/' . $postRequest->blog_images) : null,
                'clients' => $postRequest->name,
                'clients_img' => $postRequest->customer_photo ? (strpos($postRequest->customer_photo, '/') === 0 ? $postRequest->customer_photo : '/' . $postRequest->customer_photo) : null,
            ]
        );

        return redirect()->back()->with('success', 'The post was successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Post::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Post deleted successfully');
    }
}
