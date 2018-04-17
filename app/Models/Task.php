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

    private $id;
    private $address;
    private $awb;
    private $lat;
    private $long;
    private $driver_id;
    private $bulk_id;
    private $company_id;
    private $customer_name;
    private $customer_phone;
    private $city;
    private $area;
    private $country;
    private $street_number;
    private $street_name;
    private $complete_after;
    private $complete_before;
    private $pick_up_address;
    private $pick_up_lat;
    private $pick_up_long;



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
