<?php

namespace App\Models;

use App\Models\Variant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ["sku","name", "description", "price", "image",'sale_price', "brand_id", "slug","status"];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function variants()
    {
        return $this->hasMany(Variant::class, 'product_id');
    }
    
    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');
    }
    
    
}
