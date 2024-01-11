@extends('clients.layouts.master')
@section('content')
    <div class="shop_area shop_reverse">
        <div class="container">
            <div class="shop_inner_area">
                <div class="row">
                    @include('clients.page.shop.filter')
                    @include('clients.page.shop.product')
                 

                </div>
            </div>

        </div>
    </div>
 
@endsection
@php
        $headershop = true;
    @endphp
