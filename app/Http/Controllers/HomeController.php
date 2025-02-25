<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() 
    {
        return view('index');
    }

    public function menu() 
    {
        return view('pages.menu');
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
