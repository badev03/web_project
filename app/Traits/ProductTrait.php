<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\Attribute_value;
use Illuminate\Support\Facades\Request;
const STATUS = 1;

trait ProductTrait
{
    
    public function getProducts()
    {
        return Product::select('id', 'name', 'slug', 'price', 'sale_price', 'image', 'status')
            ->where('status',STATUS)
            ->get();
    }
    public function detail($slug)
    {
        return Product::where('slug', $slug)->where('status',STATUS)->firstOrFail();
    }
    public function getCateProduct()
    {
        return  Category::with(['products' => function ($query) {
            $query->where('status',STATUS);
        }])
            ->select('id', 'name', 'slug', 'parent_id', 'status')
            ->where('status',STATUS)
            ->where('parent_id', 0)
            ->withCount('products')
            ->get();
    }
    public function getBrandProduct()
    {
        return Brand::with(['products' => function ($query) {
            $query->where('status',STATUS); // Lọc sản phẩm có trạng thái làSTATUS
        }])
            ->select('id', 'name', 'slug', 'status')
            ->where('status',STATUS)
            ->withCount('products') // Lấy số lượng sản phẩm của mỗi thương hiệu
            ->get();
    }
    public function getAttributeValues()
    {
        return Attribute::with('values')->select('id', 'name')->get();
    }
    public function getProductNew(){
        return Product::select('id', 'name', 'slug', 'price', 'sale_price', 'image', 'status')
            ->where('status',STATUS)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
    }
}
