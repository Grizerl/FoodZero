<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Reservation\ReservationStoreRequest;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Reservation::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationStoreRequest $reservationStoreRequest)
    {
       $reservation = Reservation::create($reservationStoreRequest->all());
       return response()->json([
        'reservation' => $reservation,
       ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return response()->json($reservation,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationStoreRequest $reservationStoreRequest, Reservation $reservation)
    {
       $reservation->update($reservationStoreRequest->all());

       return response()->json([
            'reservation' => $reservation,
       ], 200);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'message' => 'reservation remove'
        ], 204);
    }
}
