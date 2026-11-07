<?php

namespace App\Http\Requests\Main;

use App\Models\Reservation;
use App\Rules\BookableDate;
use App\Services\ReservationSchedule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
{
    public const TAKEN_MESSAGE = 'This time is already booked. Please choose another one.';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $schedule = app(ReservationSchedule::class);

        return [
            'guest_name' => ['required', 'string', 'min:3', 'max:255'],
            'reservation_date' => ['required', 'string', new BookableDate($schedule)],
            'reservation_slot' => ['required', 'string', Rule::in($schedule->slotTimes())],
            'guest_count' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'guest_name.required' => 'Please enter a name for the reservation.',
            'guest_name.min' => 'The name must be at least :min characters.',
            'reservation_date.required' => 'Please choose a date.',
            'reservation_slot.required' => 'Please choose a time.',
            'reservation_slot.in' => 'Please choose one of the available times.',
        ];
    }

    /**
     * Checks that need both the date and the slot, run only when each of them is valid.
     *
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->hasAny(['reservation_date', 'reservation_slot'])) {
                    return;
                }

                $schedule = app(ReservationSchedule::class);
                $moment = $schedule->parseDate($this->input('reservation_date'))
                    ->setTimeFromTimeString($this->input('reservation_slot'));

                if (! $schedule->isBookable($moment)) {
                    $validator->errors()->add('reservation_slot', 'This time has already passed. Please choose a later one.');
                } elseif (Reservation::where('reservation_time', $moment)->exists()) {
                    $validator->errors()->add('reservation_slot', self::TAKEN_MESSAGE);
                }
            },
        ];
    }

    /**
     * Attributes ready for Reservation::create(): date and slot are folded into reservation_time.
     *
     * @return array{guest_name: string, reservation_time: string, guest_count: string}
     */
    public function reservationData(): array
    {
        $data = $this->validated();

        return [
            'guest_name' => $data['guest_name'],
            'reservation_time' => $data['reservation_date'].' '.$data['reservation_slot'].':00',
            'guest_count' => $data['guest_count'],
        ];
    }
}
