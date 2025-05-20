<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ReservationController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index(): View
    {
        $reservations = Reservation::paginate(15);
        return view('admin.reservation.index', compact('reservations'));
    }

    /**
     * Summary of destroy
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Reservation::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Reservation successfully delete');
    }
}
