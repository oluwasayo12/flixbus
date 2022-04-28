<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class TripReservationTest extends TestCase
{
    use RefreshDatabase;

    private function create_trip()
    {
        $created_trip = $this->json('POST', route('trips.create'), [
            'trip_from' => 'Abuja',
            'trip_to' => 'Lagos',
            'trip_total_spots' => '10',
        ]);

        return $created_trip->getContent();
    }

    public function test_reserve_specified_number_of_spots()
    {
        $trip =json_decode($this->create_trip());

        $trip_reservation = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'John',
            'trip_no_of_spots' => 2,
        ]);
        
        $trip_reservation
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'status' => true,
                'message' => "OK"
            ]);
    }


    public function test_reserve_one_spots_with_sold_out_response()
    {

        $trip =json_decode($this->create_trip());

        $reserve_two_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'John',
            'trip_no_of_spots' => 2,
        ]);

        $reserve_eight_spots = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Jane',
            'trip_no_of_spots' => 8,
        ]);

        $reserve_one_spot = $this->json('POST', route('trip_reservation.create'), [
            'trip_id' => $trip->data->id,
            'trip_user_name' => 'Ronald',
            'trip_no_of_spots' => 1,
        ]);

        
        $reserve_one_spot
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJson([
            'status' => false,
            'message' => "sold out"
        ]);
    }
}
