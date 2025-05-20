<?php

namespace App\Http\Requests\Api\Admin\Reservation;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'guest_name' => 'required|string|max:255',
           'reservation_time' => 'required',
           'guest_count' => 'required',
        ];
    }
}
