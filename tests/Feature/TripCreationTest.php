<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TripCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_validation_error_if_all_fields_are_empty()
    {
        $response = $this->json('POST', route('trips.create'), []);
        $response
        ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure([
            'status',
            'message',
            'error'
        ])
        ->assertJson([
            'status' => false,
            'message' => "Validation error occurred",
            'error' =>  [
                "The trip from field is required.",
                "The trip to field is required.",
                "The trip total spots field is required."
            ]
        ]);
    }

    public function test_trip_is_created_with_ten_spots()
    {
        $response = $this->json('POST', route('trips.create'), [
            'trip_from' => 'Abuja',
            'trip_to' => 'Lagos',
            'trip_total_spots' => 10,
        ]);
        $response
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'trp_from',
                    'trp_to',
                    'trp_total_spots',
                    'trp_available_spots',
                    'updated_at',
                    'created_at',
                    'id',
                ]
            ]);
    }
}
