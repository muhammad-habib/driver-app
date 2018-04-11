<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'drivers';
    protected $fillable = [
        'name',
        'awb',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
