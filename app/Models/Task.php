<?php

namespace App\Models;

use App\Traits\Task\Assignable;
use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(type="object")
 */
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

    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $id;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $address;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $awb;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $lat;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $long;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $driver_id;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $bulk_id;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $company_id;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $customer_name;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $customer_phone;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $city;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $area;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $country;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $street_number;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $street_name;
    /**
     * @SWG\Property(format="date-time")
     * @var string
     */
    private $complete_after;
    /**
     * @SWG\Property(format="date-time")
     * @var string
     */
    private $complete_before;
    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $pick_up_address;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $pick_up_lat;
    /**
     * @SWG\Property(format="int64")
     * @var int
     */
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
