<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const BASE_URL  = 'back-end.page';

    public function index()
    {
        $title = 'Danh sách danh mục';
        $categories = Category::all();
        return view(Self::BASE_URL . '.category-products.index', compact('categories', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới danh mục';
        // $parentCategories = Category::where('parent_id', 0)->get();
        $parentCategories = Category::all();
 
        return view(Self::BASE_URL . '.category-products.create', compact('title', 'parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $this->validateStore($request);
        $request->merge(['slug' => Str::slug($request->name)]);
        $model = new Category();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('images/categories');
            // Get the public URL of the uploaded file on S3
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $url = Storage::disk('s3')->url($imagePath);

            $model->image = $url;
        }else{
            $model->image = null;
        }
        $model->fill($request->except('image'));
        $model->save();
        return redirect()->route('categories.index')->with('success', 'Thành công');

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
        $title = 'Cập nhật danh mục';
        $category = Category::findOrfail($id);
        $parentCategories = Category::all();
        
       
        return view(Self::BASE_URL . '.category-products.edit', compact('category', 'title', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

       $category = Category::findOrFail($id);
         $request->validate([
                'name' => 'required|unique:categories,name,'.$category->id.'|max:255',
                'description' => 'max:255',
                'parent_id' => 'required|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status' => 'required|numeric',
          ], [
                'name.required' => 'Tên danh mục không được để trống',
                'name.unique' => 'Tên danh mục đã tồn tại',
                'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
                'description.max' => 'Mô tả không được vượt quá 255 ký tự',
                'parent_id.required' => 'Danh mục cha không được để trống',
                'parent_id.numeric' => 'Danh mục cha phải là số',
                'image.image' => 'Ảnh không đúng định dạng',
                'image.mimes' => 'Ảnh phải có định dạng jpeg,png,jpg,gif,svg',
                'image.max' => 'Ảnh không được vượt quá 2048 ký tự',
                'status.required' => 'Trạng thái không được để trống',
                'status.numeric' => 'Trạng thái phải là số',
    
          ]);
          $request->merge(['slug' => Str::slug($request->name)]);
          if ($request->hasFile('image') && $request->file('image')->isValid()) {
                if($category->image){
                 Storage::disk('s3')->delete($category->image);
                }
                $imagePath = $request->file('image')->store('images/categories');
                Storage::disk('s3')->setVisibility($imagePath, 'public');
                $url = Storage::disk('s3')->url($imagePath);
                $category->image = $url;
          }
          $category->update($request->except('image'));
          return redirect()->route('categories.index')->with('success', 'Cập nhật thành công');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if($category->image){
            Storage::disk('s3')->delete($category->image);
        }
        if($category->parent_id == 0){
            $category->children()->parent_id =0;
        }
        $category->delete();

        return redirect()->route('categories.index');
    }
    public function validateStore(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'description' => 'max:255',
            'parent_id' => 'required|numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|numeric',
        ], [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự',
            'parent_id.required' => 'Danh mục cha không được để trống',
            'parent_id.numeric' => 'Danh mục cha phải là số',
            'image.image' => 'Ảnh không đúng định dạng',
            'image.mimes' => 'Ảnh phải có định dạng jpeg,png,jpg,gif,svg',
            'image.max' => 'Ảnh không được vượt quá 2048 ký tự',
            'status.required' => 'Trạng thái không được để trống',
            'status.numeric' => 'Trạng thái phải là số',

        ]);
    }
}
