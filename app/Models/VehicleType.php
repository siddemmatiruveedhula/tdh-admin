<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;
    protected $fillable = [
        'status','name'
     ];
     public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
