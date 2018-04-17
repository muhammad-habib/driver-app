<?php

namespace App\Models;

use App\Traits\Task\Assignable;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use Assignable;
    protected $primaryKey = 'id';
    protected $table = 'tasks';
    protected $fillable = [
        'id',
        'address',
        'awb',
        'lat',
        'long',
        'driver_id',
        'bulk_id',
        'company_id',
        'customer_name',
        'customer_phone',
        'city',
        'area',
        'country',
        'street_number',
        'street_name',
        'complete_after',
        'complete_before',
        'pick_up_address',
        'pick_up_lat',
        'pick_up_long',
        'task_status_id',
        'total_price',
        'payment_type_id'

    ];
    public $id;
    public $address;
    public $awb;
    public $lat;
    public $long;
    public $driver_id;
    public $bulk_id;
    public $company_id;
    public $customer_name;
    public $customer_phone;
    public $city;
    public $area;
    public $country;
    public $street_number;
    public $street_name;
    public $complete_after;
    public $complete_before;
    public $pick_up_address;
    public $pick_up_lat;
    public $pick_up_long;

    public function bulk()
    {
        return $this->belongsTo(Bulk::class, 'bulk_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }    
    public function payment()
    {
        return $this->belongsTo(PaymentType::class);
    }




}
