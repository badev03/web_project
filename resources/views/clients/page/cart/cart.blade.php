@extends('clients.layouts.master')
@section('content')
    <?php
    $headershop = true;
    $total = 0;
    ?>


    <div class="shopping_cart_area">
        <div class="container">
            <form action="#">
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>



                                        @if ($cart)
                                            @foreach ($cart as $item)
                                                <tr class="carts">
                                                    <td class="product_remove"><a href="#" class="remove-item"
                                                            data-product-id="{{ $item['id'] }}"><i
                                                                class="fa fa-trash-o"></i></a></td>
                                                    <td class="product_thumb"><a href="#"><img class="small-image"
                                                                src="{{ $item['image'] }}" alt=""
                                                                style="width: 100px; height: 100px;"></a></td>
                                                    <td class="product_name">
                                                        <a
                                                            href="#">{{ $item['name'] . ' (' . $item['attribute'] . ')' }}</a>
                                                        <input type="hidden" class="variant-input"
                                                            data-variant="{{ $item['variant'] }}">
                                                        <input type="hidden" class="attribute-input"
                                                            data-attribute="{{ $item['attribute'] }}">
                                                    </td>

                                                    <td class="product-price" data-price="{{ $item['sale_price'] }}">
                                                        {{ number_format($item['sale_price'], 0, ',', '.') }}</td>
                                                    <td class="product_quantity"><input min="1"
                                                            class="quantity-input" max="100"
                                                            value="{{ $item['quantity'] }}" type="number"></td>
                                                    <td class="product_total">
                                                        {{ number_format($item['quantity'] * $item['sale_price'], 0, ',', '.') . ' ₫' }}

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6">Không có sản phẩm nào trong giỏ hàng</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart_submit">
                                <div class="alert alert-danger" id="errorContainer" style="display: none;">
                                    <!-- Thông báo lỗi sẽ được đặt ở đây -->
                                </div>
                                <button type="submit">update cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code left">
                                <h3>Coupon</h3>
                                <div class="coupon_inner">
                                    <p>Enter your coupon code if you have one.</p>
                                    <input placeholder="Coupon code" type="text">
                                    <button type="submit">Apply coupon</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="coupon_code right">
                                <h3>Cart Totals</h3>
                                <div class="coupon_inner">
                                    @if (session('cart'))

                                    <div class="cart_subtotal">
                                        <p>Subtotal</p>
                                            @foreach ((array) session('cart') as $id => $details)
                                                @php
                                                $total += $details['sale_price'] * $details['quantity']; @endphp
                                            @endforeach

                                            <p class="cart_amount sub">{{ number_format($total, 0, ',', '.') . ' ₫' }}</p>

                                    </div>
                                    <div class="cart_subtotal ">
                                        <p>Shipping</p>
                                        <p class="cart_amount"><span>Flat Rate:</span> 30.000 ₫</p>
                                    </div>
                                    <a href="#">Calculate shipping</a>

                                    <div class="cart_subtotal">
                                        <p>Total</p>
                                        <p class="cart_amount su">{{ number_format($total + 30000, 0, ',', '.') . ' ₫' }}</p>
                                    </div>
                                @else
                                    <div class="cart_subtotal">
                                        <p>Subtotal</p>



                                        <p class="cart_amount sub"></p>

                                    </div>
                                    <div class="cart_subtotal ">
                                        <p>Shipping</p>
                                        <p class="cart_amount"><span>Flat Rate:</span></p>
                                    </div>
                                    <div class="cart_subtotal">
                                        <p>Total</p>
                                        <p class="cart_amount su"></p>
                                    </div>
                                    @endif

                                    <div class="checkout_btn">
                                        <a href="{{route('checkout')}}">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->

            </form>
        </div>
    </div>

@endsection
