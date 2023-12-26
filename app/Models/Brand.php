<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'status_id', 'name'
    ];
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
