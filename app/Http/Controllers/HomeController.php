<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        return view('index');
    }

    public function menu() 
    {
        return view('pages.menu', [
            'starters' => Menu::where('category_id', 1)->take(3)->get(),
            'mains' => Menu::where('category_id', 2)->take(3)->get(),
            'pastries_And_Drinks' => Menu::where('category_id', 3)->take(3)->get(),
        ]);
        
    }    

    public function fullMenu() 
    {
        $categories = Categories::with('menu')->get();
        return view('pages.full-menu',compact('categories'));
    }   

    public function blog() 
    {
        return view('pages.sectionBlog.blog');
    }

    public function about() 
    {
        return view('pages.about');
    }

    public function contact() 
    {
        return view('pages.contact');
    }
}
