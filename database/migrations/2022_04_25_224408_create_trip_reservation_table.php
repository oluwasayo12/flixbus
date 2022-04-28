<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_reservation', function (Blueprint $table) {
            $table->id('tr_id');
            $table->foreignId('trip_id')->constrained('trips');
            $table->string('tr_user_name');
            $table->integer('tr_no_of_reserved_spots');
            $table->string('tr_status')->default('reserved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_reservation');
    }
}
