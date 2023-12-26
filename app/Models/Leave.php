<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'created_by','id');
    } 
    public function approved(){
        return $this->belongsTo(User::class,'updated_by','id');
    } 
    public function leavetype(){
        return $this->belongsTo(LeaveType::class,'leave_type_id','id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
