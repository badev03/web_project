<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Traits\ProductTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    use ProductTrait;
    public function index()
    {
        $categories = $this->getCateProduct();
        $productNew = $this->getProductNew();

        $selectedCategory = $categories->isEmpty() ? null : $categories->first();
        return view('clients.page.home.product', compact('categories', 'selectedCategory', 'productNew'));
    }

    

}
