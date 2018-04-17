<?php
/**
 * Created by PhpStorm.
 * User: kazafy
 */

namespace App\Enums\Task;

abstract class ATaskStatus{

    const NEW = 1;
    const READY = 2;
    const INTRANSIT = 3;
    const SUCCESSFUL = 4;
    const FAILED = 5;
}