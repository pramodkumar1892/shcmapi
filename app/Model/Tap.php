<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tap extends Model
{
    protected $fillable = [
        'tap_parent_id', 'tap_collection_id', 'user_id', 'tap_in', 'tap_out', 'type_date', 'type_day', 'reason',
    ];
}
