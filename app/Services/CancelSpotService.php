<?php

namespace App\Services;

use App\Interfaces\CancelSpotInterface;
use App\Models\TripReservation;
use App\Models\Trips;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class CancelSpotService implements CancelSpotInterface
{
    public function __construct()
    {
        $this->response = new stdClass();
    }

    public function cancel(array $payload)
    {
        try {
            $spots_for_cancellation = abs($payload['trip_no_of_spots_to_cancel']);
            $trip_id = $payload['trip_id'];


            $no_of_reserved_spots = TripReservation::where(['trip_id'=>$trip_id, 'tr_user_name'=>$payload['trip_user_name']])->value('tr_no_of_reserved_spots');
            $current_trip_available_spots = Trips::where('id', $trip_id)->value('trp_available_spots');

            if ($spots_for_cancellation > $no_of_reserved_spots) {
                $this->response->message = TripReservation::INVALID_SPOT_PROVIDED;
                $this->response->code = Response::HTTP_UNPROCESSABLE_ENTITY;
                return $this->response;
            }

            $new_reserved_spot_by_user = $no_of_reserved_spots - $spots_for_cancellation;
            $new_trip_available_spots = $current_trip_available_spots + $spots_for_cancellation;

            TripReservation::where(['trip_id' => $trip_id, 'tr_user_name'=>$payload['trip_user_name']])->update(['tr_no_of_reserved_spots' => $new_reserved_spot_by_user]);
            Trips::where('id', $trip_id)->update(['trp_available_spots' => $new_trip_available_spots]);

            $this->response->message = TripReservation::SUCCESS;
            $this->response->code = Response::HTTP_OK;
            return $this->response;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $payload);
        }
    }
}
