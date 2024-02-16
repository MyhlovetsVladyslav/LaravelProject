<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class CreateTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
   /* public function authorize(): bool
    {
        return false;
    }*/

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'route' => 'required|exists:routes,id',
            'date_departure' => 'required|date|after:now',
            'date_arrival' => 'required|date|after:date_departure',
            'transport' => [
                'required',
                'exists:transports,id',
                function ($attribute, $value, $fail) {
                    $existingTrips = Trip::where('transport_id', explode('|', $value)[0])
                        ->where('departure_time', '<', request()->input('date_arrival') ?? 0)
                        ->where('arrival_time', '>', request()->input('date_departure') ?? 0)
                        ->exists();
                    if ($existingTrips) {
                        $fail('Этот транспорт уже используется в другом рейсе.');
                    }
                },
            ],
            'price_platskart' => 'nullable|required_if:subType,passenger|numeric',
            'price_coupe' => 'nullable|required_if:subType,passenger|numeric',
            'price_lux' => 'nullable|required_if:subType,passenger|numeric',
            'price_first_class' => 'nullable|required_if:subType,intercity|numeric',
            'price_second_class' => 'nullable|required_if:subType,intercity|numeric',
            'price_bus' => 'nullable|required_if:type,bus|numeric',
            'price_econom' => 'nullable|required_if:type,plane|numeric',
            'price_comfort' => 'nullable|required_if:type,plane|numeric',
            'price_bisness' => 'nullable|required_if:type,plane|numeric',
        ];
    }
}
