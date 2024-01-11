@extends('back-end.layouts.partials.master')

@section('content')
    <!-- Form controls -->
    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ $title ?? 'Admin Toro' }}
                </h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Ảnh</label>
                        <input type="file" class="form-control" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">
                        <br>
                        {{-- Hiển thị ảnh vừa chọn --}}
                        <div class="input-group">
                            <img id="image" style=" display: none;" src="" alt="" width="300px"
                                height="300px" />
                        </div>

                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" placeholder="Quần..." value="{{old('name')}}" />
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
                        <label for="exampleFormControlSelect1" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="parent_id">
                            <option value="0" selected>Trống</option>

                            @foreach ($parentCategories as $item)
                               

                                <option  value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach


                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Trạng Thái</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="status">
                            <option value="1">Kích Hoạt</option>
                            <option value="2">Không kích hoạt</option>
                        </select>
                    </div>


                    <br> <br> <br>
                    <div class="mb-4 ">
                        <button type="submit" class="btn ms-auto theme-bg-color text-white" style="float: right">Thêm
                            thương hiệu</button>
                        <a href="{{ route('categories.index') }}" class="btn ms-auto theme-bg-color text-white"
                            style="float: left">Quay lại</a>
                    </div>
                </div>
            </div>
    </form>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#inputGroupFile04').change(function() {
                readURL(this);
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
@endpush
