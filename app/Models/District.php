<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'name',
        'status',
        'country_id',
        'state_id'
     ];

     public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
     public function state()
     {
         return $this->belongsTo(State::class, 'state_id', 'id');
     }
     public function country()
     {
         return $this->belongsTo(Country::class, 'country_id', 'id');
     }
}
