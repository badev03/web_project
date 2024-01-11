@extends('back-end.layouts.partials.master')

@section('content')

<div class="col-12">
    <div class="row">
        <div class="col-sm-8 m-auto">
            <div class="card">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>Thêm tài khoản mới</h5>
                    </div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-home"
                                type="button">Tài khoản</button>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab"
                                data-bs-toggle="pill" data-bs-target="#pills-profile"
                                type="button">Pernission</button>
                        </li> --}}
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
                            <form class="theme-form theme-form-2 mega-form" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header-1">
                                    <h5>THông tin tài khoản</h5>
                                </div>

                                <div class="row">
                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Ảnh
                                            </label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="file" name="avatar"
                                            value="{{ old('avatar') }}">
                                            @error('avatar')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Tên
                                            </label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="text" name="name" placeholder="name"
                                            value="{{ old('name') }}">
                                            @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Email
                                            </label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="text" name="email" placeholder="email"
                                            value="{{ old('email') }}">
                                            @error('email')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Phone
                                            </label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="text" name="phone" placeholder="phone"
                                            value="{{ old('phone') }}">
                                            @error('phone')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Địa chỉ</label>
                                            <div class="col-md-9 col-lg-10">
                                                <input class="form-control" type="text" name="address" placeholder="address"
                                                value="{{ old('address') }}">
                                                @error('address')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            </div>
                                    </div>

                                    <div class="mb-4 row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Mật khẩu</label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="password" name="password" placeholder="password"
                                            value="{{ old('password') }}">
                                            @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <label
                                            class="col-lg-2 col-md-3 col-form-label form-label-title">Nhập lại mật khẩu</label>
                                        <div class="col-md-9 col-lg-10">
                                            <input class="form-control" type="password"  name="confirm-password"placeholder="confirm-password" value="{{ old('password') }}">
                                            @error('confirm-password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        </div>
                                    </div>
                                </div>
                                <br> <br>
                                <div class="mb-4 ">
                                    <button type="submit" class="btn ms-auto theme-bg-color text-white" id="oke"
                                        style="float: right">Thêm
                                        sản phẩm</button>
                                    <a href="{{ route('products.index') }}" class="btn ms-auto theme-bg-color text-white"
                                        style="float: left">Quay lại</a>
                                </div>
                            </form>
                        </div>

                        {{-- <div class="tab-pane fade" id="pills-profile" role="tabpanel">
                            <div class="card-header-1">
                                <h5>Product Related Permition</h5>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Add Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Update Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Delete Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Apply Discount</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="card-header-1">
                                <h5>Category Related Permition</h5>
                            </div>
                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Add Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Update Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Delete Product</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>

                            <div class="mb-4 row align-items-center">
                                <label class="col-md-2 mb-0">Apply Discount</label>
                                <div class="col-md-9">
                                    <form class="radio-section">
                                        <label>
                                            <input type="radio" name="opinion" checked>
                                            <i></i>
                                            <span>Allow</span>
                                        </label>

                                        <label>
                                            <input type="radio" name="opinion" />
                                            <i></i>
                                            <span>Deny</span>
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection