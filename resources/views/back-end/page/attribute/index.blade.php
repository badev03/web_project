@extends('back-end.layouts.partials.master')
@push('style')



    @section('content')
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body">
                        <div class="title-header option-title">
                            <h5>{{ $title ?? '' }}</h5>
                            <form class="d-inline-flex">
                                <a href="{{ route('attributes.create') }}" class="align-items-center btn btn-theme d-flex">
                                    <i data-feather="plus-square"></i>Thêm mới
                                </a>
                            </form>
                        </div>


                        <div class="table-responsive category-table">
                            <table class="table all-package theme-table" id="table_id">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Giá trị</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Hành Động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attributes as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->name }}</td>

                                           
                                            <td> @foreach ($item->values as $value)
                                                {{ $value->value }}
                                                {{ !$loop->last ? ', ' : '' }}
                                            @endforeach</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>{{ $item->status == 1 ? 'Đã kích Hoạt' : 'Chưa kích hoạt' }}</td>
                                            <td>
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('attributes.edit', ['attribute' => $item->id]) }}">
                                                        <i class="ri-pencil-line"></i>
                                                        </a>
                                                    </li>
                                                    
                                                    <li>

                                                        <form
                                                            action="{{ route('attributes.destroy', ['attribute' => $item->id]) }}"
                                                            method="post">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="dropdown-item"
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
