<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskOperationType extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'task_operation_types';
    protected $fillable = [
        'title_ar',
        'title_en',
        'color'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'operation_type_id');
    }
}
