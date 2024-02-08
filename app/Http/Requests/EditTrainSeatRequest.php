<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTrainSeatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'seat_number' => 'required|unique:train_seats,seat_number,' . $this->route('seat')->id . ',id,carriage_id,' . $this->route('carriage_id'),
        ];
    }
}
