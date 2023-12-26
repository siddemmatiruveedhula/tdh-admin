<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function customerType()
    {
        return $this->belongsTo(CustomerType::class, 'customer_type', 'id');
    }

    public function customerCategoryType()
    {
        return $this->belongsTo(CustomerCategoryType::class, 'customer_category_type', 'id');
    }

    public function beat(){
        return $this->belongsTo(Beat::class,'beat_id','id');
    }

    public function communicatePerson(){
        return $this->belongsTo(Employee::class,'communicate_person','id');
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }
}
