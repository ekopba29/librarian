<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function borrow()
    {
        return $this->belongsTo(Borrow::class);
    }
}
