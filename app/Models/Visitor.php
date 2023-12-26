<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "visitors";

    public function vehicleType(){
        return $this->belongsTo(VehicleType::class,'vehicle_type_id','id');
    }
}
