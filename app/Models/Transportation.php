<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;
    protected $fillable = [
        'status','name'
     ];
     protected $table = "transportations";
     public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
