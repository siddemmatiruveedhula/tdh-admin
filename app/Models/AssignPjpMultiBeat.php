<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignPjpMultiBeat extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "assign_pjps_beat";
    // protected $fillable = [
    //     'assign_pjp_id',
    //     'beat_id',
    // ];

}
