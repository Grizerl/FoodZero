<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\ReservationRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends Controller
{
    /**
     * Summary of index
     */
    public function index(): View
    {
        return view('index', [
            'posts' => Post::latest()->take(2)->get(),
        ]);
    }

    /**
     * Summary of about
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Summary of menu
     */
    public function menu(): View
    {
        return view('pages.menu', [
            'starters' => Menu::where('category_id', 1)->take(3)->get(),
            'mains' => Menu::where('category_id', 2)->take(3)->get(),
            'pastries_And_Drinks' => Menu::where('category_id', 3)->take(3)->get(),
        ]);

    }

    /**
     * Summary of fullMenu
     */
    public function fullMenu(): View
    {
        $categories = Category::with('menu')->get();

        return view('pages.full-menu', compact('categories'));
    }

    /**
     * Summary of blog
     */
    public function blog(): View
    {
        $post = Post::paginate(6);

        return view('pages.sectionBlog.blog', compact('post'));
    }

    /**
     * Summary of show
     */
    public function show(int $id): View
    {
        $post = Post::findOrFail($id);
        $related_posts = Post::inRandomOrder()->take(2)->get();

        return view('pages.sectionBlog.post_detail', compact('post', 'related_posts'));
    }

    /**
     * Summary of contact
     */
    public function contact(): View
    {
        return view('pages.contact');
    }

    /**
     * Summary of reservation
     */
    public function reservation(ReservationRequest $request): RedirectResponse
    {
        Reservation::create($request->validated());

        return redirect()->back()->with('success', 'Your reservation has been successfully added.');
    }
}
