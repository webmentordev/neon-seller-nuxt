<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'stripe_id',
        'name',
        'slug',
        'description',
        'seo',
        'body',
        'image',
        'category_id',
        'is_active',
        'is_feature'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}