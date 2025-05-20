<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    protected $fillable =
        [
            'guest_name',
            'reservation_time',
            'guest_count',
        ];
}
