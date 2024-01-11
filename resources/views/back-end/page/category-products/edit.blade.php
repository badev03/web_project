@extends('back-end.layouts.partials.master')

@section('content')
    <!-- Form controls -->
    <form action="{{ route('categories.update',['category'=>$category->id]) }}" method="post" enctype="multipart/form-data">
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
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image">
                        <br>
                        {{-- Hiển thị ảnh cũ khi đang chỉnh sửa --}}
                        @if(isset($category) && $category->image)
                            <div class="input-group">
                                <img id="image" src="{{ $category->image }}" alt=""
                                    width="200px" />
                            </div>
                        @else
                            {{-- Hiển thị ảnh vừa chọn khi thêm mới --}}
                            <div class="input-group">
                                <img id="image" style="display: none;" src="" alt=""
                                    width="200px" />
                            </div>
                        @endif
                    
                        @error('image')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" name="name" placeholder="Quần..."
                            value="{{ $category->name ? $category->name : old('name') }}" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label">Mô Tả</label>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" placeholder="Mô tả">{{ $category->description ? $category->description : old('description') }}</textarea>
                        @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Danh mục cha</label>
                        <select class="form-select" id="exampleFormControlSelect1" name="parent_id">
                            <option value="0">Trống</option>

                            @foreach ($parentCategories as $item)
                            @if($category->parent_id == 0)
                            <option value="{{$item->id}}" >{{$item->name}}</option>

                            @endif
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


                    <div class="col-12">
                        <button type="submit" class="btn btn-success me-1 mb-1">
                           Cập nhật
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Hủy</a>
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
