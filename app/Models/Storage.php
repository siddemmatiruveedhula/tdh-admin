<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "storages";

    public function storagetype(){
        return $this->belongsTo(StorageType::class,'storage_type_id','id');
    }
}
