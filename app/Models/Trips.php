<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    use HasFactory;

    public const CREATE_ERROR = 'Unable to create trip record';
    public const CREATE_SUCCESS = 'Trip Record Created';

    public const FETCH_ERROR = 'Unable to fetch trip record';
    public const FETCH_SUCCESS = 'Trip record';


    public function tripReservations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TripReservation::class);
    }
}
