<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTripRequest;
use App\Interfaces\TripsInterface;
use App\Models\Trips;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{

    /**
     * create_trip
     *
     * @param  mixed $request
     * @return mixed
     */
    public function create(CreateTripRequest $request)
    {
        try {
            $create_trip =  new Trips;
            $create_trip->trp_from = $request->trip_from;
            $create_trip->trp_to = $request->trip_to;
            $create_trip->trp_total_spots = abs($request->trip_total_spots);
            $create_trip->trp_available_spots = abs($request->trip_total_spots);

            if ($create_trip->save()) {
                return $this->createdResponse(Trips::CREATE_SUCCESS, $create_trip);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage(), $request->toArray());
            return $this->badRequestAlert(Trips::CREATE_ERROR);
        }
    }
    
    /**
     * get_trip_details
     *
     * @param  mixed $tripId
     * @return mixed
     */
    public function list(int $tripId)
    {
        try {
            $trip_data = Trips::where('id', $tripId)->firstOrFail();
            return $this->successResponse(Trips::FETCH_SUCCESS, $trip_data);
        } catch (Exception $e) {
            Log::error($e->getMessage(), ['trip_id'=> $tripId]);
            return $this->badRequestAlert(Trips::FETCH_ERROR);
        }
    }
}
