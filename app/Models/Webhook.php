<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'webhooks';
    protected $fillable = [
        'name',
        'code',
        'description_en',
        'description_ar'
    ];
}
