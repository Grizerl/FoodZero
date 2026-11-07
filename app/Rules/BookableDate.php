<?php

namespace App\Rules;

use App\Services\ReservationSchedule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BookableDate implements ValidationRule
{
    public function __construct(private readonly ReservationSchedule $schedule) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $date = $this->schedule->parseDate(is_string($value) ? $value : null);

        if ($date === null) {
            $fail('Please choose a valid date.');

            return;
        }

        if ($date < $this->schedule->today()) {
            $fail('This date has already passed.');

            return;
        }

        if ($date > $this->schedule->lastDate()) {
            $fail('Tables can be reserved up to '.config('reservations.horizon_days').' days ahead.');

            return;
        }

        if (! $this->schedule->isOpenDay($date)) {
            $fail('We are closed on '.$date->format('l').'s. Please choose another day.');
        }
    }
}
