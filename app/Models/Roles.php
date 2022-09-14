<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    const ADMIN = 1;
    const SALES_MANAGER = 2;
    const OPERATION_MANAGER = 3;
    const CUSTOMER = 4;
}
