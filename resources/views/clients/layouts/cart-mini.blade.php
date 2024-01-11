@php
    $total = 0;
    $quantity = 0;
@endphp

@foreach ((array) session('cart') as $id => $details)
    @php
        $total += $details['sale_price'] * $details['quantity'];
        $quantity += $details['quantity'];
    @endphp
@endforeach

<div class="cart_link">
    <a href="#"><i class="fa fa-shopping-basket"></i>{{ $quantity > 0 ? $quantity . ' item' : 'item' }}</a>
    <!--mini cart-->

    @if (!empty(session('cart')))
        <div class="mini_cart">
            @foreach (session('cart') as $id => $cartItem)
                <div class="cart_item top" data-id="{{ $id }}" data-variant="{{ $cartItem['variant'] }}">
                    <div class="cart_img">
                        <a href="{{route('productDetail',['slug'=> $cartItem['slug']])}}"><img src="{{ $cartItem['image'] }}" alt=""></a>
                    </div>
                    <div class="cart_info">
                        <a href="{{route('productDetail',['slug'=> $cartItem['slug']])}}">{{ $cartItem['name'] }}</a>
                        ({{ $cartItem['attribute'] }})
                        <span>{{ $cartItem['quantity'] }}x {{ number_format($cartItem['sale_price'], 0, ',', '.') }}</span>
                    </div>
                    <div class="cart_remove">
                        <a><i class="ion-android-close"></i></a>
                    </div>
                </div>
            @endforeach

            <div class="cart__table">
                <table>
                    <tbody>
                        {{-- Display the subtotal --}}
                        <tr>
                            <td class="text-left">Sub-Total :</td>
                            <td class="text-right">${{ number_format($total, 0, ',', '.') }}</td>
                        </tr>

                        {{-- Display the total --}}
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right">${{ number_format($total+30000, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cart_button view_cart">
                <a href="{{route('cart')}}">View Cart</a>
            </div>
            <div class="cart_button checkout">
                <a href="checkout.html">Checkout</a>
            </div>
        </div>
        @else
        <div class="mini_cart">
            chưa có sản phẩm nào trong giỏ hàng

            <div class="cart__table">
                <table>
                    <tbody>
                        <tr>
                            <td class="text-left">Sub-Total :</td>
                        </tr>

                        <tr>
                            <td class="text-left">Total :</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="cart_button view_cart">
                <a href="{{route('cart')}}">View Cart</a>
            </div>
            <div class="cart_button checkout">
                <a href="checkout.html">Checkout</a>
            </div>
        </div>
    @endif
</div>

