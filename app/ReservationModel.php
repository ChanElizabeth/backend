<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationModel extends Model
{
    protected $table = "reservations";

    protected $fillable = [
        'name',
        'email',
        'phoneNo',
        'venue',
        'dateTime',
        'description'
    ];
}
