<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripReservationRequest;
use App\Interfaces\ReserveSpotInterface;
use App\Models\TripReservation;
use Exception;
use Illuminate\Support\Facades\Log;

class TripReservationController extends Controller
{
    protected $reserveSpot;

    public function __construct(ReserveSpotInterface $reserveSpot)
    {
        $this->reserveSpot = $reserveSpot;
    }

    /**
     * Reserve spot
     *
     * @param TripReservationRequest $request
     * @return mixed
     */
    public function create(TripReservationRequest $request)
    {
        try {
            $response = $this->reserveSpot->create($request->all());

            return $this->jsonResponse($response->message, $response->code);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $request->toArray());
            return $this->badRequestAlert(TripReservation::RESERVATION_ERROR);
        }
    }
}
