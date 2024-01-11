<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Attribute;
use App\Traits\AdminTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use AdminTrait;
    /**
     * Display a listing of the resource.
     */
    const BASE_URL  = 'back-end.page';

    public function index()
    {
        $products = Product::where('status', 1)->latest()->get();

        $title = 'Danh sách sản phẩm';
        return view(Self::BASE_URL . '.product.index', compact('products', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::select('id', 'name')->where('status', 1)->latest()->get();
        $parentCategories = Category::where('parent_id', 0)->where('status', 1)->get();
        $attributes = Attribute::select('id', 'name')->latest()->get();
        return view(Self::BASE_URL . '.product.create', compact('brands', 'parentCategories', 'attributes'));
    }

    public function getSubCategories($categoryId)
    {
        $subCategories = Category::select('id', 'name', 'parent_id', 'status')->where('status', 1)->where('parent_id', $categoryId)->get();
        if (!$subCategories) {
            return response()->json(['error' => 'Không tìm thấy danh mục con']);
        }
        return response()->json($subCategories);
    }
    public function getAttributeValues($attributeId)
    {

        $attribute = Attribute::find($attributeId);

        if (!$attribute) {
            return response()->json(['error' => 'Không tìm thấy thuộc tính']);
        }

        $values = $attribute->values; // Giả sử có mối quan hệ 'values' trong model Attribute

        return response()->json($values);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // dd($request->all());
        $this->validateProduct($request);


        try {

            $product = new Product();
            $request->merge(['slug' => Str::slug($request->name) . '.html']);
            $product->fill($request->except(['_token', 'image']));

            $product->save();
            if (is_array($request->sub_category_id)) {

                $categoryId = $request->category_id;
                // Lặp qua mảng sub_category_id và thêm vào bảng liên kết
                foreach ($request->sub_category_id as $subCategoryId) {
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => $categoryId,
                        'sub_category_id' => $subCategoryId,
                    ]);
                }
            }
            if ($request->attribute_value_id) {
                foreach ($request->attribute_value_id as $key => $attribute_value_id) {
                    $variant = new Variant();
                    $variant->product_id = $product->id;
                    $variant->attribute_value_id = $attribute_value_id;
                    // dùng vòng lặp để lưu số lượng vào bảng variant
                    if (isset($request->quantity[$key])) {
                        $variant->quantity = $request->quantity[$key];
                    }
                    $variant->save();
                }
            }



            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image')->store('images/products');
                Storage::disk('s3')->setVisibility($image, 'public');
                $url = Storage::disk('s3')->url($image);
                $product->image = $url;
            } else {
                $product->image = null;
            }
            if ($request->hasFile('image_path')) {
                foreach ($request->file('image_path') as $image) {
                    $image = $image->store('images/detail/products');
                    Storage::disk('s3')->setVisibility($image, 'public');
                    $url = Storage::disk('s3')->url($image);
                    $product->images()->create([
                        'image_path' => $url,
                    ]);
                }
            }


            $product->save();


            return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            // hiển thị lỗi
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function validateProduct(Request $request)
    {
        $validate = $request->validate([
            'sku' => 'required|unique:products,sku',
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            // 'quantity' => 'required|numeric|min:1',
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'brand_id' => 'required',
            'attribute_id' => 'required',
            'attribute_value_id' => 'required',
            'image' => 'required',
        ], [
            'sku.required' => 'Mã sản phẩm không được để trống',
            'sku.unique' => 'Mã sản phẩm đã tồn tại',
            'name.required' => 'Tên sản phẩm không được để trống',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'price.min' => 'Giá sản phẩm phải lớn hơn 0',
            'sale_price.required' => 'Giá khuyến mãi sản phẩm không được để trống',
            'sale_price.numeric' => 'Giá khuyến mãi sản phẩm phải là số',
            'sale_price.min' => 'Giá khuyến mãi sản phẩm phải lớn hơn 0',
            // 'quantity.required' => 'Số lượng sản phẩm không được để trống',
            // 'quantity.numeric' => 'Số lượng sản phẩm phải là số',
            // 'quantity.min' => 'Số lượng sản phẩm phải lớn hơn 0',
            'category_id.required' => 'Danh mục sản phẩm không được để trống',
            'sub_category_id.required' => 'Danh mục con sản phẩm không được để trống',
            'brand_id.required' => 'Thương hiệu sản phẩm không được để trống',
            'attribute_id.required' => 'Thuộc tính sản phẩm không được để trống',
            'attribute_value_id.required' => 'Giá trị thuộc tính sản phẩm không được để trống',
            'image.required' => 'Ảnh sản phẩm không được để trống',


        ]);
        return $validate;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm');
        }
        $this->validateProduct($request);
        try {
            $product->fill($request->except(['_token', 'image']));
            $product->save();
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image')->store('images/products');
                Storage::disk('s3')->setVisibility($image, 'public');
                $url = Storage::disk('s3')->url($image);
                $product->image = $url;
            } else {
                $product->image = null;
            }
            $product->save();
            return redirect()->route('products.index')->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            // hiển thị lỗi
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateStatus($id)
    {
        $results = $this->status($id, Product::class);
        if (isset($results['error'])) {
            return redirect()->back()->with('error', $results['error']);
        }
        return redirect()->back()->with('success', $results['success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
