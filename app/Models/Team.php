<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'teams';
    protected $fillable = [
        'name',
        'active',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'driver_team', 'team_id', 'driver_id');
    }

}
