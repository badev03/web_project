<?php

namespace App\Http\Controllers\Admin;

use App\Models\Attribute;
use App\Models\Attribute_value;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const BASE_URL  = 'back-end.page';

    public function index()
    {
        $attributes = Attribute::all();
        return view(Self::BASE_URL . '.attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Thêm mới thuộc tính';
        return view(Self::BASE_URL . '.attribute.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $attribute = Attribute::create(['name' => $request->name]);


        foreach ($request->value as $value) {
            $attribute->values()->create(['value' => $value]);
        }

        return redirect()->route('attributes.index');
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
        $attribute = Attribute::find($id);
        $values = $attribute->values;
        $title = 'Cập nhật thuộc tính';
        return view(Self::BASE_URL . '.attribute.edit', compact('attribute', 'title', 'values'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attribute = Attribute::find($id);

        if ($attribute->name != $request->name) {
            $attribute->update(['name' => $request->name]);
        }

        // dd($request->value);
        if ($request->has('value') && is_array($request->value) && count($request->value) > 0) {
            foreach ($request->value as $value) {
                $existingValue = Attribute_value::where('attribute_id', $attribute->id)
                    ->where('value','!=',$value)
                    ->first();
                    // dd($existingValue);

                if ($existingValue) {

                    // Có giá trị thay đổi, cập nhật nếu giá trị mới khác giá trị hiện tại
                    if ($existingValue->value != $value) {

                        Attribute_value::where('attribute_id', $attribute->id)
                            ->where('value', $value)
                            ->update(['value' => $value]);
                    }
                } else {
                    // Tạo mới giá trị
                    $attribute->values()->create(['value' => $value]);
                }
            }
        } else {
            // Xử lý trường hợp không có giá trị được truyền vào
            // Ví dụ: log hoặc thông báo về việc không có giá trị được truyền vào
        }
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = Attribute::find($id);
        $attribute->delete();
        return redirect()->back();
    }

    public function deleteAttributeValue($id)
    {

        $attributeValue = Attribute_value::find($id);
        $attributeValue->delete();
        return redirect()->back();
    }
}
