<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCategoryType extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "customer_category_types";
}
