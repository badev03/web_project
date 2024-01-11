    @extends('clients.layouts.master')


    @section('content')
        <!--product section area start-->
        <section class="product_section womens_product">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_title">
                            <h2>Our Products</h2>
                            <p>Contemporary, minimal and modern designs embody the Lavish Alice handwriting</p>
                        </div>
                    </div>
                </div>

                <div class="product_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="product_tab_button">
                                <ul class="nav" role="tablist">


                                    @foreach ($categories as $key => $category)
                                        <li>
                                            <a class="{{ $key == 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                                href="#{{ $category->slug }}" role="tab"
                                                aria-controls="{{ $category->slug }}"
                                                aria-selected="true">{{ $category->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        @foreach ($categories as $key => $category)
                            <div class="tab-pane fade{{ $key == 0 ? ' show active' : '' }}" id="{{ $category->slug }}"
                                role="tabpanel">
                                <div class="product_container">

                                    <div class="row product_column4">
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-3">
                                                <div class="single_product">
                                                    <div class="product_thumb">
                                                        <a class="primary_img"
                                                            href="{{ route('productDetail', ['slug' => $product->slug]) }}">
                                                            <img src="{{ $product->image }}" alt=""></a>

                                                        <div class="product_action">
                                                            <div class="hover_action">
                                                                <a href="#"><i class="fa fa-plus"></i></a>
                                                                <div class="action_button">
                                                                    <ul>

                                                                        <li><a title="add to cart" href="cart.html"><i
                                                                                    class="fa fa-shopping-basket"
                                                                                    aria-hidden="true"></i></a></li>
                                                                        <li><a href="wishlist.html"
                                                                                title="Add to Wishlist"><i
                                                                                    class="fa fa-heart-o"
                                                                                    aria-hidden="true"></i></a></li>

                                                                        <li><a href="compare.html" title="Add to Compare"><i
                                                                                    class="fa fa-sliders"
                                                                                    aria-hidden="true"></i></a></li>

                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="quick_button">
                                                            <a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#modal_box" title="quick_view">+ quick
                                                                view</a>
                                                        </div>

                                                        <div class="product_sale">
                                                            <span>-7%</span>
                                                        </div>
                                                    </div>
                                                    <div class="product_content">
                                                        <h3><a href="product-details.html">{{ $product->name }}</a>
                                                        </h3>
                                                        <span
                                                            class="current_price">£{{ number_format($product->sale_price, 0, ',', '.') }}</span>
                                                        <span
                                                            class="old_price">£{{ number_format($product->price, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>

            @include('clients.page.home.banner')
            @include('clients.page.home.new-product')
            @include('clients.page.home.blog')
        </section>
        <!--product section area end-->
    @endsection
