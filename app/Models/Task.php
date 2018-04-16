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
        'bulk_id',
        'company_id',
        'customer_name',
        'customer_phone',
        'city',
        'area',
        'country',
        'street_number',
        'street_name',
        'complete_after',
        'complete_before',
        'pick_up_address',
        'pick_up_lat',
        'pick_up_long',
        'task_status_id',


    ];

    public function bulk()
    {
        return $this->belongsTo(Bulk::class,'bulk_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }





}
