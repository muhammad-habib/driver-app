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
        'company_id',
        'active'
    ];
    public $name;
    public $awb;
    public $company_id;
    public $active;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
