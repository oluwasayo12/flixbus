## Technical Test
    Reserve & Cancel spots on a trip
    
## Setup
   - Database is using sqlite. Create a file with name "database.sqlite" in folder "database" before proceeding
   - Clone Repository
   - Run "composer install"
   - Copy .env.example content to .env
   - To run tests "php artisan test" 

## Files Created & Edited
- [**]Controller
    - TripController 
    - TripReservationController
    - CancelSpotReservationController

- [**]Interfaces
    - ReserveSpotInterface
    - CancelSpotInterface

- [**]Models
    - Trips Model
    - TripReservation Model

- [**]Services
    - ReserveSpotService
    - CancelSpotService

- [**]Migrations
    - [**]Routes/api.php
    - [**]Providers/AppServiceProvider.php

- [**]Tests
    - TripCreationTest
    - TripReservationTest
    - TripReservationCancellationTest

- [**]Http/Traits
    - ApiResponse












    
