@extends('back-end.layouts.partials.master')
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('template/back-end/assets/css/vendors/dropzone.css') }}">
@endpush
@section('content')
    <!-- Form controls -->
    {{-- <form action="{{route('brands.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ $title ?? 'Admin Toro' }}
                </h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" value="{{old('logo')}}" aria-label="Upload" name="logo">
                        <br>
                        <div class="input-group">
                            <img id="image" style=" display: none;" src="" alt="" width="300px" height="300px" />
                        </div>
                        
                        @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên thương hiệu</label>
                        <input type="text" class="form-control" name="name" placeholder="Nike" value="{{old('name')}}" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Mô Tả</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Mô tả">{{old('description')}}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="status">
                            <option value="1">Kích Hoạt</option>
                            <option value="2">Không kích hoạt</option>
                        </select>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-success me-1 mb-1">
                         Thêm mới
                          </button>
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </div>
            </div>
    </form> --}}
    <div class="row">
        <div class="col-sm-8 m-auto">
            <div class="card">
                <div class="card-body">
                    <div class="card-header-2">
                        <h5>{{ $title ?? '' }}</h5>
                    </div>

                    <form class="theme-form theme-form-2 mega-form" action="{{ route('brands.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Tên thương hiệu</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" name="name" placeholder="Brand Name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger" style="color: white;background-color: rgb(231, 79, 79)">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-3 mb-0">Mô tả</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Mô tả">{{old('description')}}</textarea>
                                @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            </div>
                        </div>


                        <div class="mb-4 row align-items-center">
                            <label class="col-sm-3 col-form-label form-label-title">
                                Ảnh</label>
                            <div class="form-group col-sm-9">
                                <div class="dropzone-wrapper">
                                    <div class="dropzone-desc">
                                        <i class="ri-upload-2-line"></i>
                                        <p>Chọn ảnh hoặc kéo vào đây</p>
                                    </div>
                                    <input type="file" class="dropzone" name="logo" id="inputGroupFile04">
                                    @error('logo')
                                        <div class="alert alert-danger" style="color: white;background-color: rgb(231, 79, 79)">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <br> <br> <br>
                        <div class="mb-4 ">
                            <button type="submit" class="btn ms-auto theme-bg-color text-white" style="float: right">Thêm
                                thương hiệu</button>
                            <a href="{{ route('brands.index') }}" class="btn ms-auto theme-bg-color text-white"
                                style="float: left">Quay lại</a>
                        </div>





                    </form>
                </div>
            </div>
        </div>
        {{-- hiển thị thẻ img sau khi chọn ảnh --}}

        <div class="col-sm-4 m-auto" style="display: none;" id="imageContainer">
            <label>Preview Image</label>
            <div class="input-group">
                <img id="image" style=" display: none;" src="" alt="" width="300px" height="300px" />
            </div>
        </div>
    @endsection
    @push('script')
        <script>
            $(document).ready(function() {
                $('#inputGroupFile04').change(function() {
                    readURL(this);
                    // Hiển thị div khi có sự kiện change
                    $('#imageContainer').show();
                });

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#image').attr('src', e.target.result);
                            $('#image').show(); // Hiển thị thẻ img sau khi chọn ảnh
                        };

                        reader.readAsDataURL(input.files[0]);
                    }
                }

            });
        </script>
        <script src="{{ asset('template/back-end/assets/js/dropzone/dropzone.js') }}"></script>
        <script src="{{ asset('template/back-end/assets/js/dropzone/dropzone-script.js') }}"></script>
    @endpush
