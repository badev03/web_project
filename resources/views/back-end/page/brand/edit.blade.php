@extends('back-end.layouts.partials.master')
@section('content')
    <!-- Form controls -->
    <form action="{{ route('brands.update', ['brand' => $brand->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ $title ?? 'Admin Toro' }}
                </h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Ảnh</label>
                        <input type="file" class="form-control" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="logo">
                        <br>
                        {{-- Hiển thị ảnh cũ khi đang chỉnh sửa --}}
                        @if (isset($brand) && $brand->logo)
                            <div class="input-group">
                                <img id="image" src="{{ $brand->logo }}" alt="" width="200px" />
                            </div>
                        @else
                            {{-- Hiển thị ảnh vừa chọn khi thêm mới --}}
                            <div class="input-group">
                                <img id="image" style="display: none;" src="" alt="" width="200px" />
                            </div>
                        @endif

                        @error('logo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên thương hiệu</label>
                        <input type="text" class="form-control" name="name"
                            placeholder="{{ $brand->name == '' ? 'Chưa có dữ liệu' : '' }}"
                            value="{{ $brand->name ? $brand->name : old('name') }}" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Mô Tả</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"
                            placeholder="{{ $brand->description == '' ? 'Chưa có dữ liệu' : '' }}">{{ old('description', $brand->description) }}
</textarea>



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


               
                    <div class="mb-4 ">
                        <button type="submit" class="btn ms-auto theme-bg-color text-white" style="float: right">Sửa
                            thương hiệu</button>
                        <a href="{{ route('brands.index') }}" class="btn ms-auto theme-bg-color text-white"
                            style="float: left">Quay lại</a>
                    </div>
                </div>
            </div>
    </form>
@endsection
@push('scripts')
@push('script')
        <script>
            $(document).ready(function() {
                $('#inputGroupFile04').change(function() {
                    readURL(this);
                    // Hiển thị div khi có sự kiện change
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