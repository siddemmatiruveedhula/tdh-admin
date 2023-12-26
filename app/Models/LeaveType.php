<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "leave_types";
    
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
