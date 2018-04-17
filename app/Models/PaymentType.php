<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{

    protected $primaryKey = 'id';
    protected $table = 'payment_type';
    protected $fillable = [
        'id',
        'title_ar',
        'title_en',
        'code',
        'company_id',
    ];    

    public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
