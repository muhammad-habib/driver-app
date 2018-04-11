<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'batches';
    protected $fillable = [
        'driver_id',
        'company_id',
    ];


    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
