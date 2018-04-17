<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Task\ATaskStatus;
use App\Models\PaymentType;

class Bulk extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'bulks';
    protected $fillable = [
        'driver_id',
        'company_id',
        'awb',
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
            $task['bulk_id'] = $this->id;
            $payment_type = PaymentType::where('code',$task['payment_type_id'])
                                          ->where('company_id',$this->company_id)->first(); 
            $task['payment_type_id'] = $payment_type->id;
            $task['task_status_id'] = ATaskStatus::NEW;
            $task['company_id'] = $this->company_id;
            Task::create($task);
        }
    }
    
}
