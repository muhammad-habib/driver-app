<?php

namespace App\Models;

use App\Enums\Task\ATaskStatus;
use Illuminate\Database\Eloquent\Model;

class DriverShift extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'driver_shifts';
    protected $fillable = [
        'driver_id',
        'start_at',
        'end_at'
    ];

}
