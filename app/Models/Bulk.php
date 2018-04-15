<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulk extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'bulks';
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
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    
    public function addTasks(array $tasks){
        foreach($tasks as $task){
            $task->bulk_id = $this->id;
            $task->company_id = $this->company_id;
            Task::create($task);
        }
    }
    
}
