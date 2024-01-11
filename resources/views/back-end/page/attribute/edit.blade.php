@extends('back-end.layouts.partials.master')

@section('content')
    <!-- Form controls -->
    <form action="{{ route('attributes.update', ['attribute' => $attribute->id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ $title ?? 'Admin Toro' }}
                </h5>
                <div class="card-body">


                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên thuộc tính</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ $attribute->name ? $attribute->name : old('name') }}" />
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="row" id="attributes-container">
                            <label for="exampleFormControlInput1" class="form-label">Giá trị </label>

                            <!-- Template Row -->
                            @foreach ($values as $item)
                                <div class="col-12" class="attribute-row">
                                    <div class="row">

                                        <div class="col-6 col-md-3">
                                            <div class="mb-3">
                                                <input type="text" class="form-control expiry-date-mask" name="value[]"
                                                    value="{{ $item->value }}" placeholder="Giá trị" />
                                            </div>
                                        </div>

                            

                                        <div class="col-6 col-md-1">
                                            <div class="mb-3">
                                                <a href="{{ route('deleteAttributeValue', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-remove"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                     X
                                                 </a>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            @endforeach

                            <!-- End of Template Row -->

                            <div class="col-6 col-md-4">
                                <button type="button" class="btn btn-success add-attribute  theme-bg-color text-white">Thêm
                                    giá trị</button>
                            </div>
                        </div>
                    </div>




                    <div class="mb-4 ">
                        <button type="submit" class="btn ms-auto theme-bg-color text-white" style="float: right"> Cập
                            nhật</button>
                        <a href="{{ route('attributes.index') }}" class="btn ms-auto theme-bg-color text-white"
                            style="float: left">Quay lại</a>
                    </div>
                </div>
            </div>
    </form>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const attributesContainer = document.getElementById('attributes-container');
            const addAttributeButton = document.querySelector('.add-attribute');

            addAttributeButton.addEventListener('click', function() {
                const newAttributeRow = document.createElement('div');
                newAttributeRow.classList.add('attribute-row');
                newAttributeRow.innerHTML =
                    `        <div class="row">
                               
                                    <div class="col-6 col-md-3">
                                        <div class="mb-3">
                                            <input type="text" class="form-control expiry-date-mask" name="value[]"
                                                placeholder="giá trị" />
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1">
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-danger btn-remove"
                                                onclick="removeAttributeRow(this)">X</button>
                                        </div>
                                    </div>
                                </div>`;
                attributesContainer.insertBefore(newAttributeRow, addAttributeButton.parentElement);
            });
        });

        function removeAttributeRow(button) {
            button.closest('.attribute-row').remove();
        }
    </script>

@endpush
