<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplaintModel extends Model
{
    protected $table = "complaints";

    protected $fillable = [
        'name',
        'email',
        'phoneNo',
        'subject',
        'complaint',
    ];
}
