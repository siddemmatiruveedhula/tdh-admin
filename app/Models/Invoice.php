<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    const CREATED_AT = 'dtCreatedOn';
    const UPDATED_AT = 'dtModifiedOn';
    
    use HasFactory;
    protected $guarded = [];

    public function customer(){
        return $this->belongsTo(Customer::class,'iCustomerID','id');
    } 

    public function order(){
        return $this->belongsTo(Order::class,'iOrderID','id');
    }

    public function supervisor(){
        return $this->belongsTo(User::class,'isupervisor_id','id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'ivehicle_id','id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class,'iSupplierID','id');
    }
} 
 