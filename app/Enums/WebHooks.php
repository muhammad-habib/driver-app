<?php

/*
|--------------------------------------------------------------------------
| WebHooks Enum
|--------------------------------------------------------------------------
|
| Here is we can find webhooks names and it's codes, these values are 
| representation for table (webhooks). Detailed description for each value 
| can be found in the table
|
*/

namespace App\Enums;


abstract class WebHooks
{
    const TASK_CREATED 	 = 1;
    const TASK_ASSIGNED  = 2;
    const TASK_STARTED 	 = 3;
    const TASK_REFUSED 	 = 4;
    const TASK_UPDATED 	 = 5;
    const TASK_ARRIVED 	 = 6;
    const TASK_DELIVERED = 7;
    const TASK_FAILED	 = 8;
}