<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarriageRequest extends FormRequest
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
            'number' => 'required|unique:train_carriages,number,NULL,id,train_id,' . $this->route('train_id'),
        ];
    }
    public function messages()
    {
        return [
            'number.unique' => 'Этот номер уже используется для данного поезда.',
        ];
    }
}
