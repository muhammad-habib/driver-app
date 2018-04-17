<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskOperation extends Model
{
    protected $primaryKey = 'id';
    protected $table = "task_operations";
    protected $fillable = [
        'description',
        'operation_type_id',
        'task_id',
        'created_by'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function type()
    {
        return $this->belongsTo(TaskOperationType::class, 'operation_type_id');
    }
}
