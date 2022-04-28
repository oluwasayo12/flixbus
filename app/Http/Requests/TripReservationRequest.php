<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trip_id' => 'required|numeric',
            'trip_user_name' => 'required|string',
            'trip_no_of_spots' => 'required|numeric'
        ];
    }
}
