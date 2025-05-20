<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
    * Summary of dashboard
    * @return View
    */
    public function home(): View
    {
        return view('admin.dashboard')->with([
           'count_user' => User::count(),
           'count_menu' => Menu::count(),
           'count_blog' => Post::count(),
           'count_reservation' => Reservation::count()
     ]);

    }
}
