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
        'active',
        'username',
        'password',
        'token'
    ];
    private $name;
    private $awb;
    private $company_id;
    private $active;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
