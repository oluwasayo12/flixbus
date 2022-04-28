<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TripReservationCancellationTest extends TestCase
{
    use RefreshDatabase;

    private function create_trip()
    {
        $created_trip = $this->json('POST', route('trips.create'), [
            'trip_from' => 'Abuja',
            'trip_to' => 'Lagos',
            'trip_total_spots' => 10,
        ]);

        return $created_trip->getContent();
    }

    public function test_cancel_reservation()
    {
        $trip =json_decode($this->create_trip());

        $reserve_eight_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'John',
            'trip_no_of_spots' => 8,
        ]);

        $reserve_two_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Jane',
            'trip_no_of_spots' => 2,
        ]);

        $cancel_jane_two_spot = $this->json('POST', route('trip_reservation_cancellation.cancel'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Jane',
            'trip_no_of_spots_to_cancel' => 2,
        ]);
        
        $cancel_jane_two_spot
        ->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'status' => true,
            'message' => "OK"
        ]);
    }


    public function test_not_enough_spot_after_cancel_reservation()
    {
        $trip =json_decode($this->create_trip());

        $reserve_eight_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'John',
            'trip_no_of_spots' => 8,
        ]);

        $reserve_two_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Jane',
            'trip_no_of_spots' => 2,
        ]);

        $cancel_jane_two_spot = $this->json('POST', route('trip_reservation_cancellation.cancel'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Jane',
            'trip_no_of_spots_to_cancel' => 2,
        ]);

        $reserve_three_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Ronald',
            'trip_no_of_spots' => 3,
        ]);
        
        $reserve_three_spots
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
            'status' => false,
            'message' => "not enough spots"
        ]);
    }
}
