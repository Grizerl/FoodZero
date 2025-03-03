<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reserv=Reservation::all();
        return view('admin.reservation.index',compact('reserv'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'data_time' => 'required|date|unique:reservations,reservation_time', 
            'quantity' => 'required',
        ], [
            'data_time.unique' => 'Please choose another time!',
        ]);

        Reservation::create([
            'guest_name' => $validatedData['name'],  
            'reservation_time' => $validatedData['data_time'],
            'guest_count' => $validatedData['quantity'],
        ]);

        return redirect()->back()->with('success', 'Your reservation has been successfully added.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->back()->with('success','Reservation successfully delete');
    }
}
