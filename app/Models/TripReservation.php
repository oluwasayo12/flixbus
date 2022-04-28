<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripReservation extends Model
{
    use HasFactory;

    protected $table = 'trip_reservation';

    public const RESERVED = 'RESERVED';
    public const CANCELLED = 'CANCELLED';
    public const SUCCESS = 'OK';
    public const SOLD_OUT = 'sold out';
    public const NOT_ENOUGH_SPOT = 'not enough spots';
    public const RESERVATION_ERROR = 'Unable to complete reservation';
    public const CANCELLATION_ERROR = 'Unable to cancel reservation';
    public const INVALID_SPOT_PROVIDED = 'no of spots cannot be greater than spots already reserved';
}
