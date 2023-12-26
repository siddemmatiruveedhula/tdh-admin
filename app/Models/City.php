<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class City extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "cities";
    protected $fillable = [
        'state_id', 'name', 'status',
        'country_id', 'district_id'
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
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }
}
