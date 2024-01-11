<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    use ProductTrait;

    public function index()
    {
        $products = $this->getProducts();
        $brands = $this->getBrandProduct();
        $categories = $this->getCateProduct();
        $attributes = $this->getAttributeValues();
        return view('clients.page.shop.index', compact('products', 'brands', 'categories', 'attributes'));
    }
    public function filterProducts(Request $request)
    {
        dd($request->type);
        // lọc sản phẩm theo thương hiệu danh mục sản phẩm sau đó return response về cho ajax
        $products = Product::with(['brand', 'categories'])->where('status', 1);
        if ($request->type && $request->value) {
            if ($request->type == 'brand') {
                $products = $products->whereHas('brand', function ($query) use ($request) {
                    $query->where('name', $request->value);
                });
            }
            if ($request->type == 'category') {
                $products = $products->whereHas('categories', function ($query) use ($request) {
                    $query->where('name', $request->value);
                });
            }
            if ($request->type == 'attribute') {
                $products = $products->whereHas('attributeValues', function ($query) use ($request) {
                    $query->where('value', $request->value);
                });
            }
        }
        $products = $products->get();
        return response()->json($products);
    }
}
