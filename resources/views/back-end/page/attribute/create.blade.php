@extends('back-end.layouts.partials.master')

@section('content')
  

    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header">{{ $title ?? 'Admin Toro' }}
            </h5>
            <div class="card-body">
                <form action="{{ route('attributes.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tên thuộc tính</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" />
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Giá trị</label>
                            <select class="form-control values select_value" id="values" multiple="multiple"
                                name="value[]">
                            </select>
                            @error('value')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                    <br> <br> <br>
                    <div class="mb-4 ">
                        <button type="submit" class="btn ms-auto theme-bg-color text-white" style="float: right">Thêm
                            thuộc tính</button>
                        <a href="{{ route('attributes.index') }}" class="btn ms-auto theme-bg-color text-white"
                            style="float: left">Quay lại</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-3"></div>

@endsection

@push('script')
    {{-- <script>
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
    </script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("select.select_value").select2({
                tags: true,
                tokenSeparators: [',', ' '],
            }).on('select2:selecting', function(e) {
                // Khi người dùng đang thêm một giá trị mới
                var value = e.params.args.data.id.trim().toLowerCase();

                // Lấy danh sách các giá trị đã được chọn
                var selectedValues = $(this).val() || [];
                selectedValues = selectedValues.map(v => v.trim().toLowerCase());

                // Kiểm tra xem giá trị mới có trùng với bất kỳ giá trị nào đã được chọn chưa
                if (selectedValues.indexOf(value) > -1) {
                    // Nếu giá trị đã tồn tại, hủy bỏ việc thêm giá trị mới
                    e.preventDefault();
                    // Cập nhật lại Select2 để hiển thị đúng giá trị đã chọn
                    $(this).val(selectedValues).trigger('change.select2');
                }
            });
        });
    </script>
@endpush
