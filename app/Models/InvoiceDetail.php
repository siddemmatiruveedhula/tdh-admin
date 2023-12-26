<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    const CREATED_AT = 'dtCreatedOn';
    const UPDATED_AT = 'dtModifiedOn';

    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class, 'iProductID', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'iCategoryID', 'id');
    }
}
