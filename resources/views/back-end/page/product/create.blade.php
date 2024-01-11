@extends('back-end.layouts.partials.master')
@push('style')
    <style>
        .category-item {
            margin-left: 20px;
            /* Điều chỉnh giá trị theo ý muốn của bạn */

        }

        .select2-selection__choice__remove:hover {
            background-color: red !important;

        }
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="{{ asset('template/back-end/frest-html-admin-template/assets/vendor/libs/select2/select2.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('template/back-end/frest-html-admin-template/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
@endpush
@section('content')


    <div class="col-12">
        <form id="form-create" class="theme-form theme-form-2 mega-form" action="{{ route('products.store') }}" method="post"
            enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Thông tin sản phẩm</h5>
                            </div>


                            @csrf
                            <div class="mb-4 row align-items-center">

                                <label class="form-label-title col-sm-3 mb-0">SKU</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="sku" placeholder="SKU"
                                        value="{{ old('sku') }}">
                                    @error('sku')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Tên sản phẩm</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="text" name="name" placeholder="Product Name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Danh mục chính</label>
                                <div class="col-sm-9">
                                    <select class="js-example-basic-single w-100" name="category_id" id="category">
                                        <option value="" selected>Chọn danh mục chính</option>
                                        @foreach ($parentCategories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Danh mục phụ</label>
                                <div class="col-sm-9">

                                    <select class="js-example-basic-multiple" name="sub_category_id[]" multiple="multiple"
                                        id="value_cate">

                                    </select>
                                    @error('sub_category_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Thương hiệu</label>
                                <div class="col-sm-9">
                                    <select class="js-example-basic-single w-100" name="brand_id">
                                        <option value="">Chọn thương hiệu</option>
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('brand_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('brand_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Giá sản phẩm</h5>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 form-label-title">Giá mặc định</label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number" name="price" placeholder="price"
                                        min="1" value="{{ old('price') }}">
                                    @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 form-label-title">Giá khuyến mãi
                                </label>
                                <div class="col-sm-9">
                                    <input class="form-control" type="number"min="1" name="sale_price"
                                        placeholder="sale price" value="{{ old('sale_price') }}">
                                    @error('sale_price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Sản phẩm biến thể</h5>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="form-label-title col-sm-3 mb-0">Tên biến thể</label>
                                <div class="col-sm-9">
                                    <select class="js-example-basic-singles w-100" id="attributeSelect" name="attribute_id">
                                        <option value="0">Chọn thuộc tính</option>
                                        @foreach ($attributes as $attribute)
                                            <option
                                                value="{{ $attribute->id }}"{{ old('attribute_id') == $attribute->id ? 'selected' : '' }}>
                                                {{ $attribute->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('attribute')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Giá trị biến thể</label>
                                <div class="col-sm-9">
                                    <div class="bs-example">
                                        <select class="form-control values select_value" id="values" multiple="multiple"
                                            name="attribute_value_id[]">


                                        </select>
                                        @error('attribute_value_id')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center" >
                                {{-- <label class="col-sm-3 col-form-label form-label-title">Số lượng</label>
                                <div class="col-sm-9">
                                    <div class="bs-example">
                                        <input class="form-control" type="text" name="quantity"
                                            value="{{ old('quantity', 1) }}">
                                        @error('quantity')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <table class="table variation-table table-responsive-sm" style="display:none" id="table-variation">
                                    <thead>
                                        <tr>
                                            <th scope="col">Biến thể </th>
                                    
                                  
                                            <th scope="col">Số lượng</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="variation">

                                    </tbody>
                                </table>

                                
                            </div>
          
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Mô Tả</h5>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <label class="form-label-title col-sm-3 mb-0">Mô tả sản phẩm</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="description" placeholder="description" style="height: 135px" cols="30"
                                                rows="10">{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header-2">
                                <h5>Ảnh sản phẩm</h5>
                            </div>


                            <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Ảnh</label>
                                <div class="col-sm-9">


                                    <input type="file" class="form-control" id="image"
                                        aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">
                                    <br>
                                    {{-- Hiển thị ảnh vừa chọn --}}
                                    <div class="col-4">
                                        <img style="width: 300px"
                                            src=""
                                            alt="" id="image_prev">
                                    </div>

                                </div>
                            </div>

                            <div class="row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Ảnh chi tiết</label>

                                <div class="col-sm-9">


                                    <input type="file" class="form-control" id="image_path" name="image_path[]"
                                      multiple="multiple" value="{{ old('image_path[]') }}">
                                    <br>
                              
                                    <div class="col">
                                        <div class="col-12" id="image_preview"
                                            style="display: flex; flex-direction: row; flex-wrap: wrap;"></div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>


                </div>
                <div class="mb-4 ">
                    <button type="submit" class="btn ms-auto theme-bg-color text-white" id="oke"
                        style="float: right">Thêm
                        sản phẩm</button>
                    <a href="{{ route('products.index') }}" class="btn ms-auto theme-bg-color text-white"
                        style="float: left">Quay lại</a>
                </div>
            </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('template/back-end/frest-html-admin-template/assets/js/forms-selects.js') }}"></script>

    <script src="{{ asset('template/back-end/frest-html-admin-template/assets/vendor/libs/select2/select2.js') }}">
    </script>
    <script
        src="{{ asset('template/back-end/frest-html-admin-template/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}">
    </script>




    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('products.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#oke').click(function() {
                $('#form-create').submit();
            })

        });
        var getAttributeValuesUrl = '{{ url('admin/get-attribute-values') }}/';
        var getSubCategoriesUrl = '{{ url('admin/get-sub-categories') }}/';


    </script>

@endpush
