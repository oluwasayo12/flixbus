<?php

namespace App\Http\Controllers;

use App\Http\Requests\CancelTripReservationRequest;
use App\Interfaces\CancelSpotInterface;
use App\Models\TripReservation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CancelSpotReservationController extends Controller
{

    protected $spot;

    public function __construct(CancelSpotInterface $spot)
    {
        $this->spot = $spot;
    }

    public function cancelSpotReservation(CancelTripReservationRequest $request)
    {
        try {
            $response = $this->spot->cancel($request->all());

            return $this->jsonResponse($response->message, $response->code);
        } catch (Exception $e) {
            Log::error($e->getMessage(), $request->toArray());
            return $this->badRequestAlert(TripReservation::CANCELLATION_ERROR);
        }
    }
}
