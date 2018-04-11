<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'tasks';
    protected $fillable = [
        'awb',
        'address',
        'lat',
        'long',
        'user_name',
        'driver_id',
        'batch_id',
        'company_id',
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
