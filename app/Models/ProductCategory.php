<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = ['product_id', 'category_id','sub_category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
