<?php

namespace App\Http\Requests\Main;

use App\Rules\BookableDate;
use App\Services\ReservationSchedule;
use Illuminate\Foundation\Http\FormRequest;

class ReservationSlotsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * This endpoint only speaks JSON, so validation errors are always a 422 and never a redirect.
     */
    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'string', new BookableDate(app(ReservationSchedule::class))],
        ];
    }
}
