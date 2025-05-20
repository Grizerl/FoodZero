<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Reservation\ReservationStoreRequest;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Reservation::all(), 200);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Api\Admin\Reservation\ReservationStoreRequest $reservationStoreRequest
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(ReservationStoreRequest $reservationStoreRequest)
    {
        $reservation = Reservation::create($reservationStoreRequest->all());
        return response()->json([
         'reservation' => $reservation,
        ], 201);
    }

    /**
     * Summary of show
     * @param \App\Models\Reservation $reservation
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show(Reservation $reservation)
    {
        return response()->json($reservation, 200);
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\Api\Admin\Reservation\ReservationStoreRequest $reservationStoreRequest
     * @param \App\Models\Reservation $reservation
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(ReservationStoreRequest $reservationStoreRequest, Reservation $reservation)
    {
        $reservation->update($reservationStoreRequest->all());

        return response()->json([
             'reservation' => $reservation,
        ], 200);
    }


    /**
     * Summary of destroy
     * @param \App\Models\Reservation $reservation
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'message' => 'reservation remove'
        ], 204);
    }
}
