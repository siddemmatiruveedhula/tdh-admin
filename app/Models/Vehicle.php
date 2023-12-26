<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "vehicles";

    public function vehicleType(){
        return $this->belongsTo(VehicleType::class,'vehicle_type_id','id');
    }
    public function transportation(){
        return $this->belongsTo(Transportation::class,'transportation_id','id');
    }
}
