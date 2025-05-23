<?php

namespace App\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'guest_name' => ['required', 'string', 'min:3', 'max:255'],
            'reservation_time' => ['required', 'date', 'unique:reservations,reservation_time'],
            'guest_count' => ['required', 'string'],
        ];

    }

    public function messages(): array
    {
        return [
            'reservation_time.unique' => ['Please choose another time!'],
        ];
    }

}
