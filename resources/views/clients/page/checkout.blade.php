@extends('clients.layouts.master')

@section('content')
    <?php
    $headershop = true;
    ?>
    <!--Checkout page section-->
    <div class="Checkout_section" id="accordion">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="user-actions">
                        <h3>
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            Returning customer?
                            <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_login"
                                aria-expanded="true">Click here to login</a>

                        </h3>
                        <div id="checkout_login" class="collapse" data-bs-parent="#accordion">
                            <div class="checkout_info">
                                <p>If you have shopped with us before, please enter your details in the boxes below. If you
                                    are a new customer please proceed to the Billing & Shipping section.</p>
                                <form action="#">
                                    <div class="form_group">
                                        <label>Username or email <span>*</span></label>
                                        <input type="text">
                                    </div>
                                    <div class="form_group">
                                        <label>Password <span>*</span></label>
                                        <input type="text">
                                    </div>
                                    <div class="form_group group_3 ">
                                        <button type="submit">Login</button>
                                        <label for="remember_box">
                                            <input id="remember_box" type="checkbox">
                                            <span> Remember me </span>
                                        </label>
                                    </div>
                                    <a href="#">Lost your password?</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="user-actions">
                        <h3>
                            <i class="fa fa-file-o" aria-hidden="true"></i>
                            Returning customer?
                            <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_coupon"
                                aria-expanded="true">Click here to enter your code</a>

                        </h3>
                        <div id="checkout_coupon" class="collapse" data-bs-parent="#accordion">
                            <div class="checkout_info">
                                <form action="#">
                                    <input placeholder="Coupon code" type="text">
                                    <button type="submit">Apply coupon</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('checkoutStore') }}" method="POST" id="formCheckout">

                <div class="checkout_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">

                            @csrf
                            <h3>Billing Details</h3>
                            <div class="row">

                                <div class="col-lg-6 mb-20">
                                    <label>Name <span>*</span></label>
                                    @if(Auth::check())
                                    <input type="text" name="name" value="{{ $data['name'] ?? old('name')}}">
                                    @else
                                    <input type="text" name="name" value="{{  old('name') }}">
                                    @endif
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 mb-20">
                                    <label>provinces <span>*</span></label>
                                    <select class="provinces" name="province" data-province="{{ $province ?? '' }}">
                                        <option selected value="">--Chọn Tỉnh/Thành phố--</option>

                                    </select>
                                    @error('provinces')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>

                                <div class="col-12 mb-20">
                                    <label>Distric <span>*</span></label>
                                    <select class="districs" name="district" data-district="{{ $district ?? '' }}">
                                        <option value="">Chọn Huyện</option>
                                    </select>
                                    @error('distric')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror


                                </div>

                                <div class="col-12 mb-20">
                                    <label>Wards <span>*</span></label>
                                    <select class="wards" name="ward" data-ward="{{ $ward ?? '' }}">
                                        <option value="">--Chọn Thôn--</option>

                                    </select>
                                    @error('wards')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-12 mb-20">
                                    <label>Street address <span>*</span></label>
                             
                                        @if(Auth::check())
                                        <input placeholder="House number and street name" type="text" name="number_add"
                                        value="{{ $data['number_add'] ?? old('number_add') }}">
                                        @else
                                        <input placeholder="House number and street name" type="text" name="number_add"
                                        value="{{old('number_add') }}">
                                        @endif
                                    @error('number_add')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-lg-6 mb-20">
                                    <label>Phone<span>*</span></label>
                                    @if(Auth::check())
                                    <input type="text" name="phone" value="{{ $data['phone'] ?? old('phone') }}">

                                    @else
                                    <input type="text" name="phone" value="{{old('phone') }}">

                                    @endif
                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                <div class="col-lg-6 mb-20">
                                    <label> Email Address </label>
                                    @if(Auth::check())
                                    <input type="email" name="email" value="{{ $data['email'] ?? old('email') }}">

                                    @else
                                    <input type="email" name="email" value="{{ old('email') }}">

                                    @endif
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror

                                </div>
                                @if (!Auth::check())
                                    <div class="col-12 mb-20">
                                        <input id="account" name ="create_account" type="checkbox"
                                            data-bs-target="createp_account" />
                                        <label for="account" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                            aria-controls="collapseOne">Create an account?</label>

                                        <div id="collapseOne" class="collapse one" data-bs-parent="#accordion">
                                            <div class="card-body1">
                                                <label> Account password <span>*</span></label>
                                                <input placeholder="password" type="password" name="password">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="order-notes">
                                        <label for="order_note">Order Notes</label>
                                        <textarea name="note" id="order_note" placeholder="Notes about your order, e.g. special notes for delivery.">{{old('note')}}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-6 col-md-6">

                            <h3>Your order</h3>
                            @if (session('cart'))
                                <div class="order_table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cart as $id => $item)
                                                <tr>
                                                    <td> {{ $item['name'] . ' (' . $item['attribute'] . ')' }}<strong> ×
                                                            {{ $item['quantity'] }}</strong></td>
                                                    <td>{{ number_format($item['quantity'] * $item['sale_price'], 0, ',', '.') . ' ₫' }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cart Subtotal</th>
                                                <td><strong>{{ number_format($totalPrice, 0, ',', '.') . ' ₫' }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td><strong>30.000 ₫</strong></td>
                                            </tr>
                                            <tr class="order_total">
                                                <th>Order Total</th>
                                                <td><strong>{{ number_format($totalPrice + 30000, 0, ',', '.') . ' ₫' }}</strong>
                                                </td>

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @else
                                Chưa có sản phẩm nào
                            @endif

                            <div class="payment_method">
                                <div class="panel-default">


                                    <div class="order_button">
                                        <!-- Form thanh toán VNPay -->


                                        <ul>
                                            <li>
                                                <label>
                                                    <input type="radio" name="payment_method" value="cash" checked id="tienmat">

                                                    <span>Thanh toán khi nhận hàng</span>

                                                </label>
                                            </li>
                                            <li>
                                                <label>
                                                    <input type="radio" name="payment_method" value="Vnpay" id="vnpay">
                                                    <img src="{{ asset('template/vnpay.png') }}" style="width: 50px; "
                                                        alt="VNPay">

                                                    <span>Thanh toán qua ví điện tử Vnpay</span>

                                                </label>
                                            </li>


                                        </ul>
                                        <button type="submit"  class="btn btn-primary btn-checkout">Thanh toán</button>

                                    </div>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--Checkout page section end-->

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        $('body').on('change','#tienmat',function(){
            if($(this).is(':checked')){
               $('#formCheckout').attr('action','{{ route('checkoutStore') }}')
               $('.btn-checkout').attr('name','checkout')
            }
        })
        $('body').on('change','#vnpay',function(){
            if($(this).is(':checked')){
               $('#formCheckout').attr('action','{{ route('vnpay') }}')
               $('.btn-checkout').attr('name','redirect')
            }
        })
    
    });

</script>
<script src="{{ asset('provinces.js') }}"></script>
