<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eod extends Model
{
    use HasFactory;
    protected $dates = ['date'];

    public function employee(){
        return $this->belongsTo(Employee::class,'employee_id','id');
    } 

    public function attendance(){
        return $this->belongsTo(Attendance::class,'attendance_id','id');
    }
}
