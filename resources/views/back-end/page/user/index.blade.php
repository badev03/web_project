@extends('back-end.layouts.partials.master')
@push('style')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .table thead tr th {
            text-align: left;
        }
    </style>
@endpush
@section('content')
    <div class="col-sm-12">
        <div class="card card-table">
            <div class="card-body">
                <div class="title-header option-title">
                    <h5>Danh sách tài khoản</h5>
                    <form class="d-inline-flex">
                        <a href="{{route('users.create')}}" class="align-items-center btn btn-theme d-flex">
                            <i data-feather="plus"></i>Thêm mới
                        </a>
                    </form>
                </div>

                <div class="table-responsive table-product">
                    <table class="table all-package theme-table" id="table_id">
                        <thead>
                            <tr>
                                <th style="text-align: left">Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    {{-- <td>
                                        <div class="table-image">
                                            <img src="{{ $user->avatar ?: '..' }}" class="img-fluid" alt="">
                                        </div>
                                    </td> --}}

                                    <td>
                                        <div class="user-name">
                                            <span>{{ $user->name }}</span>

                                        </div>
                                    </td>

                                    <td>{{ $user->phone }}</td>

                                    <td>{{ $user->email }}</td>
                                    
                                    @if ($user->status == 1)
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
                                                <a href="{{ route('users.edit', ['user' => $user->id]) }}">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                            </li>

                                            <li>
                                                {{-- <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalToggle">
                                            <i class="ri-delete-bin-line"></i>
                                        </a> --}}
                                                <form
                                                    action="{{ route('updateStatusUser', ['userId' => $user->id]) }}"
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
