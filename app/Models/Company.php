<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'companies';
    protected $fillable = [
        'name_ar',
        'name_en',
    ];

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function bulk()
    {
        return $this->hasMany(Bulk::class);
    }

}
