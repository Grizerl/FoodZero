<?php

namespace App\Http\Controllers;

use App\Http\Requests\Main\ReservationRequest;
use App\Http\Requests\Main\ReservationSlotsRequest;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Reservation;
use App\Services\ReservationSchedule;
use Illuminate\Contracts\View\View;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Summary of index
     */
    public function index(): View
    {
        return view('index', [
            'posts' => Post::latest()->take(2)->get(),
            'dishes' => Menu::orderByDesc('price')->take(4)->get(),
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
            'starters' => Menu::where('category_id', 1)->take(4)->get(),
            'mains' => Menu::where('category_id', 2)->take(4)->get(),
            'pastries_And_Drinks' => Menu::where('category_id', 3)->take(4)->get(),
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
    public function reservation(ReservationRequest $request): RedirectResponse|JsonResponse
    {
        try {
            Reservation::create($request->reservationData());
        } catch (UniqueConstraintViolationException) {
            // Someone booked the same slot between validation and insert; the unique index decides.
            throw ValidationException::withMessages(['reservation_slot' => ReservationRequest::TAKEN_MESSAGE]);
        }

        $message = 'Your reservation has been successfully added.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $message], 201);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Free and taken slots of one date, for the reservation form.
     */
    public function reservationSlots(ReservationSlotsRequest $request, ReservationSchedule $schedule): JsonResponse
    {
        $date = $schedule->parseDate($request->validated('date'));

        return response()
            ->json(['date' => $date->format('Y-m-d'), 'slots' => $schedule->slotsFor($date)])
            ->header('Cache-Control', 'no-store');
    }
}
