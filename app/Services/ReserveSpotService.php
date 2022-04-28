<?php

namespace App\Services;

use App\Interfaces\ReserveSpotInterface;
use App\Models\TripReservation;
use App\Models\Trips;
use Illuminate\Http\Response;
use stdClass;

class ReserveSpotService implements ReserveSpotInterface
{

    public function __construct()
    {
        $this->response = new stdClass();
    }

    public function create(array $payload)
    {
        $user_request_trip_spots = abs($payload['trip_no_of_spots']);
        $tripId = $payload['trip_id'];

        $available_spot_value = Trips::where('id', $tripId)->value('trp_available_spots');
        if ($available_spot_value == 0) {
            $this->response->message = TripReservation::SOLD_OUT;
            $this->response->code = Response::HTTP_UNPROCESSABLE_ENTITY;
            return $this->response;
        }
    

        if ($user_request_trip_spots > $available_spot_value) {
            $this->response->message = TripReservation::NOT_ENOUGH_SPOT;
            $this->response->code = Response::HTTP_UNPROCESSABLE_ENTITY;
            return $this->response;
        }

        $reserve_slot =  new TripReservation();
        $reserve_slot->trip_id = $tripId;
        $reserve_slot->tr_user_name = $payload['trip_user_name'];
        $reserve_slot->tr_no_of_reserved_spots = abs($payload['trip_no_of_spots']);
        $reserve_slot->tr_status = TripReservation::RESERVED;
        $reserve_slot->save();

        $remaining_available_spot = $available_spot_value - $user_request_trip_spots;
        Trips::where('id', $tripId)->update(['trp_available_spots' => $remaining_available_spot]);

        $this->response->message = TripReservation::SUCCESS;
        $this->response->code = Response::HTTP_CREATED;
        return $this->response;
    }
}
