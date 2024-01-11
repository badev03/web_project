<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    const BASE_URL  = 'back-end.page';
    public function index(Request $request)
    {
        $title = 'Danh sách thương hiệu';

        $brands = Brand::latest()->get();
        return view(Self::BASE_URL . '.brand.index', compact('brands', 'title'));
    }
    public function create()
    {
        $title = 'Thêm mới thương hiệu';
        return view(Self::BASE_URL . '.brand.create', compact('title'));
    }
    public function store(Request $request)
    {
        // dd($request->all());

        $this->validateStore($request);
        $request->merge(['slug' => Str::slug($request->name)]);
        $model = new Brand();
        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $imagePath = $request->file('logo')->store('images/brands');
            Storage::disk('s3')->setVisibility($imagePath, 'public');

            $url = Storage::disk('s3')->url($imagePath);

            $model->fill($request->except('logo'));
            $model->logo = $url;
            $model->save();
        } else {

            $model->fill($request->except('logo'));
            $model->save();
            return redirect()->route('brands.index')->with('message', 'Thêm mới thành công');
        }
    }


    public function edit($id)
    {
        $title = 'Cập nhật thương hiệu';
        $brand = Brand::findOrfail($id);
        return view(Self::BASE_URL . '.brand.edit', compact('brand', 'title'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id . '|max:255',
            'description' => 'max:255',
        ], [
            'name.required' => 'Tên thương hiệu không được để trống',
            'name.unique' => 'Tên thương hiệu đã tồn tại',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự',
        ]);
        $request->merge(['slug' => Str::slug($request->name)]);


        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($brand->logo) {
                Storage::disk('s3')->delete($brand->logo);
            }
            $imagePath = $request->file('logo')->store('images/brands');
            Storage::disk('s3')->setVisibility($imagePath, 'public');
            $url = Storage::disk('s3')->url($imagePath);
            $brand->logo = $url;
        }
        $brand->update($request->except('logo'));

        return redirect()->route('brands.index')->with('message', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if ($brand->image) {
            Storage::disk('s3')->delete($brand->image);
        }
        $brand->delete();

        return redirect()->route('brands.index');
    }

    public function validateStore(Request $request)
    {
        $rules = [
            'name' => 'required|unique:brands|max:255',
            'description' => 'max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $messages = [
            'name.required' => 'Tên thương hiệu không được để trống',
            'name.unique' => 'Tên thương hiệu đã tồn tại',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự',

            'logo.image' => 'Logo không đúng định dạng',
            'logo.mimes' => 'Logo phải có định dạng jpeg,png,jpg,gif,svg',
            'logo.max' => 'Logo không được vượt quá 2048 ký tự',

        ];

        $request->validate($rules, $messages);
    }
}
