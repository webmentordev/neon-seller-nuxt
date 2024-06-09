<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'price'
    ];
    
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
