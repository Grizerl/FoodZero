<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Reservation slots
    |--------------------------------------------------------------------------
    |
    | Fixed start times (H:i) a guest can book. Derived from the "Open time"
    | strip: brunch 11:00, lunch 13:00-17:00, dinner 18:00-20:00. One table per
    | slot per date. Times are wall-clock times in the app timezone.
    |
    */

    'slots' => ['11:00', '13:00', '14:00', '15:00', '16:00', '18:00', '19:00'],

    /*
    |--------------------------------------------------------------------------
    | Open days
    |--------------------------------------------------------------------------
    |
    | Days of the week the restaurant takes reservations (0 = Sunday ... 6 =
    | Saturday). Sunday to Friday by default.
    |
    */

    'open_days' => [0, 1, 2, 3, 4, 5],

    /*
    |--------------------------------------------------------------------------
    | Booking window
    |--------------------------------------------------------------------------
    |
    | How many days ahead (counting from today) a table can be reserved.
    |
    */

    'horizon_days' => 30,

];
