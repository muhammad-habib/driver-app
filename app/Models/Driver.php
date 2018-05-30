<?php

namespace App\Models;

use App\Enums\Task\ATaskStatus;
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
        'user_name',
        'password',
        'token',
        'mobile',
        'image'
    ];
    private $name;
    private $awb;
    private $company_id;
    private $active;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function readyTasks()
    {
        return $this->hasMany(Task::class)->where('task_status_id', '=', ATaskStatus::READY);
    }

    public function shifts()
    {
        return $this->hasMany(DriverShift::class);
    }

    public function teams()
    {
        $this->belongsToMany(Team::class, 'driver_team', 'driver_id', 'team_id');
    }
}
