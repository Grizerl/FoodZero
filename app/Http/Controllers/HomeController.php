<?php

namespace App\Http\Controllers;

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
        $item = Menu::all();
        return view('pages.menu',compact('item'));
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
