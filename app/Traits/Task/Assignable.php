<?php

namespace App\Traits\Task;
use App\Models\Driver;

/**
 * Created by PhpStorm.
 * User: anoos
 * Date: 15/04/18
 * Time: 03:29 م
 */

trait Assignable
{
    /**
     * @author Anas AlSbenati
     * @since 09/08/2017
     * @param $driver
     * @version 1.0
     * @return bool
     */
    public function assignToDriver($driver) {
        if(is_numeric($driver)) {
            $driver = Driver::query()
                ->where('id', $driver)
                ->where('company_id', $this->company_id)
                ->where('on_duty', true)
                ->first();
        }

        if(!$driver)
            return false;
        if(!$driver->active || !$driver->on_duty || $driver->company_id != $this->company_id)
            return false;

        $this->driver_id = $driver->id;
        $this->save();

        event();
    }
}