<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tasks';
    protected $fillable = [
        'id',
        'address',
        'awb',
        'lat',
        'long',
        'driver_id',
        'batch_id',
        'company_id',
        'customer_name',
        'customer_phone',
        'city',
        'area',
        'country',
        'streetNumber',
        'streetName',
        'completeAfter',
        'completeBefore',
        'pickUpAddress',
        'pickUpLat',
        'pickUpLong',


    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }




}
