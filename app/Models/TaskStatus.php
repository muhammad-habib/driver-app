<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    //
    protected $primaryKey = 'id';
    protected $table = 'tasks';
    protected $fillable = [
        'id',
        'title_ar',
        'title_en',
        'color'   ,
        'priority',    
    ];    
    
}
