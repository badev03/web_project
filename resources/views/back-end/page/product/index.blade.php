@extends('back-end.layouts.partials.master')
@push('style')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .table thead tr th {
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>{{ $title ?? '' }}</h5>
                        <form class="d-inline-flex">
                            <a href="{{ route('products.create') }}" class="align-items-center btn btn-theme d-flex">
                                <i data-feather="plus-square"></i>Thêm mới
                            </a>
                        </form>
                    </div>



                </div>
                <div class="table-responsive">
                    {{-- css cho tbody thẳng hàng với thead --}}

                    <table class="table all-package theme-table table-product" id="table_id">
                        <thead>

                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá khuyến mãi</th>
                                <th>Giá</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $key => $item)
                                <tr>

                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="table-image">
                                            @if ($item->image == null)
                                                ...
                                            @else
                                                <img src="{{ $item->image }}" width="100px" alt="">
                                            @endif
                                        </div>
                                    </td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->brand_id ? $item->brand->name : 'Trống' }}</td>
                                    <td>
                                        <div class="td-price">
                                            <span>{{ number_format($item->sale_price, 0, ',', '.') }}</span>
                                        </div>
                                    </td>


                                    <td class="td-price">{{ number_format($item->price, 0, ',', '.') }}</td>

                                    @if ($item->status == 1)
                                        <td class="status-success">
                                            <span>Active</span>
                                        </td>
                                    @else
                                        <td class="status-danger">
                                            <span>Pending</span>
                                        </td>
                                    @endif



                                    <td>
                                        <ul>
                                            <li>
                                                <a href="order-detail.html">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="{{ route('products.edit', ['product' => $item->id]) }}">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            </li>

                                            <li>
                                                {{-- <a href="javascript:void(0)" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModalToggle">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a> --}}
                                                <form action="{{ route('updateStatusProduct', ['productId' => $item->id]) }}"
                                                    method="post">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item" style="left:100px"
                                                        onclick="return confirm('bạn có có chắc chắn muốn xóa không')">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>

                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
@push('script')
   
  
    <script>
        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Xác nhận xóa',
                text: `Bạn có chắc chắn muốn xóa không?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ngăn chặn gửi form mặc định
                    event.preventDefault();

                    // Thực hiện chuyển hướng sau khi xác nhận
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
@endpush
