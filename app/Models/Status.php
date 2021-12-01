<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    const STATUS_REQUEST = 1;
    const STATUS_APPROVE = 2;
    const STATUS_BORROWED = 3;
    const STATUS_RETURNED = 4;
    const STATUS_CANCELLED = 5;
}
