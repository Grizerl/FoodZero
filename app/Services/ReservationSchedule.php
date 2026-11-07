<?php

namespace App\Services;

use App\Models\Reservation;
use Carbon\CarbonImmutable;

/**
 * Single source of truth for reservation slots: which dates can be booked,
 * which slots exist and which of them are free on a given date.
 */
class ReservationSchedule
{
    /**
     * @return list<string> Slot start times in H:i.
     */
    public function slotTimes(): array
    {
        return array_values(config('reservations.slots'));
    }

    public function today(): CarbonImmutable
    {
        return now()->toImmutable()->startOfDay();
    }

    public function lastDate(): CarbonImmutable
    {
        return $this->today()->addDays((int) config('reservations.horizon_days'));
    }

    /**
     * Parse a strict Y-m-d string into the start of that day, or null.
     */
    public function parseDate(?string $value): ?CarbonImmutable
    {
        if ($value === null || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return null;
        }

        $date = CarbonImmutable::createFromFormat('!Y-m-d', $value);

        return $date !== false && $date->format('Y-m-d') === $value ? $date : null;
    }

    public function isOpenDay(CarbonImmutable $date): bool
    {
        return in_array($date->dayOfWeek, config('reservations.open_days'), true);
    }

    /**
     * Is the date inside the booking window and on a day the restaurant is open.
     */
    public function isBookableDate(CarbonImmutable $date): bool
    {
        $date = $date->startOfDay();

        return $date >= $this->today()
            && $date <= $this->lastDate()
            && $this->isOpenDay($date);
    }

    /**
     * Is the exact moment a configured slot on a bookable date that has not started yet.
     */
    public function isBookable(CarbonImmutable $moment): bool
    {
        return in_array($moment->format('H:i'), $this->slotTimes(), true)
            && $this->isBookableDate($moment)
            && $moment > now();
    }

    public function firstOpenDate(): CarbonImmutable
    {
        $date = $this->today();

        // A day with every slot already gone is skipped, so the form never opens on a dead day.
        for ($i = 0; $i <= (int) config('reservations.horizon_days'); $i++, $date = $date->addDay()) {
            if ($this->isBookableDate($date) && collect($this->slotsFor($date))->contains('available', true)) {
                return $date;
            }
        }

        return $this->today();
    }

    /**
     * Days of the week the restaurant is closed, for the date field hint.
     *
     * @return list<int>
     */
    public function closedDays(): array
    {
        return array_values(array_diff(range(0, 6), config('reservations.open_days')));
    }

    /**
     * Every slot of the date with its availability. A slot is unavailable only on the
     * date it is booked on (or once it has started), so the next day it is free again.
     *
     * @return list<array{time: string, label: string, available: bool}>
     */
    public function slotsFor(CarbonImmutable $date): array
    {
        $date = $date->startOfDay();

        $booked = Reservation::query()
            ->whereBetween('reservation_time', [$date, $date->endOfDay()])
            ->pluck('reservation_time')
            ->map(fn ($time) => substr((string) $time, 11, 5))
            ->all();

        $now = now();

        return array_map(function (string $time) use ($date, $booked, $now): array {
            $start = $date->setTimeFromTimeString($time);

            return [
                'time' => $time,
                'label' => $time,
                'available' => ! in_array($time, $booked, true) && $start > $now,
            ];
        }, $this->slotTimes());
    }
}
