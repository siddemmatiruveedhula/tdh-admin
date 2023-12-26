<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function payment(){
        return $this->belongsTo(Payment::class,'id','order_id');
    }

     public function order_details(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function paymentDetail(){
        return $this->belongsTo(PaymentDetail::class,'id','order_id');
    }
    public function invoices(){
        return $this->hasMany(Invoice::class,'iOrderID','id');
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }
}
