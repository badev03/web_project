@extends('back-end.layouts.partials.master')



@section('content')
    {{-- <h4 class="py-3 breadcrumb-wrapper mb-4">
        {{ $title ?? 'Admin Toro' }}

    </h4>
    <div class="d-block mx-auto" style="float: end;">
        <a type="button" class="btn btn-primary" href="{{ route('brands.create') }}">Thêm mới</a>
    </div>
    <br>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>STT</th>
                <th>Logo</th>
                <th>Tên</th>
                <th>Mô tả</th>
                <th>Ngày tạo</th>
                <th>Trạng thái</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td><img src="{{ $item->logo }}" width="100px" alt=""></td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->status == 1 ? 'Đã kích Hoạt' : 'Chưa kích hoạt' }}</td>

                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i
                                    class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <form action="{{ route('brands.destroy', ['brand' => $item->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="dropdown-item"
                                        onclick="return confirm('bạn có có chắc chắn muốn xóa không')">
                                        <i class="bx bx-trash me-1"></i> Xóa
                                    </button>

                                </form>

                                <a class="dropdown-item" href="{{ route('brands.edit', ['brand' => $item->id]) }}"><i
                                        class="bx bx-edit-alt me-1"></i> Sửa</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}






    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>{{ $title ?? '' }}</h5>
                        <form class="d-inline-flex">
                            <a href="{{route('brands.create')}}" class="align-items-center btn btn-theme d-flex">
                                <i data-feather="plus-square"></i>Thêm mới
                            </a>
                        </form>
                    </div>

                    <div class="table-responsive category-table">
                        <table class="table all-package theme-table" id="table_id">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Logo</th>
                                    <th>Tên</th>
                                    <th>Mô tả</th>
                                    <th>Ngày tạo</th>
                                    <th>Trạng thái</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($brands as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ $item->logo }}" width="100px" alt=""></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>{{ $item->status == 1 ? 'Đã kích Hoạt' : 'Chưa kích hoạt' }}</td>

                                        <td>
                                            <ul>
                                                <li>
                                                    <a href="{{ route('brands.edit', ['brand' => $item->id]) }}">
                                                        <i class="ri-pencil-line"></i>
                                                    </a>
                                                </li>

                                                <li>

                                                    <form action="{{ route('brands.destroy', ['brand' => $item->id]) }}"
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

