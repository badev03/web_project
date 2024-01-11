    <!--product section area start-->
    <section class="product_section womens_product bottom">
        <div class="container">
            <div class="row">   
                <div class="col-12">
                   <div class="section_title">
                       <h2>Trending Products</h2>
                       <p>Contemporary, minimal and modern designs embody the Lavish Alice handwriting</p>
                   </div>
                </div> 
            </div>    
            <div class="product_area"> 
                 <div class="row">
                    <div class="product_carousel product_three_column4 owl-carousel">
                        <div class="col-lg-3">
                            <div class="single_product">
                                @foreach ($productNew as $item)

                                <div class="product_thumb">
                                    <a class="primary_img" href="product-details.html"><img src="{{$item->image}}" alt=""></a>
                                       
                                    <div class="product_action">
                                        <div class="hover_action">
                                           <a  href="#"><i class="fa fa-plus"></i></a>
                                            <div class="action_button">
                                                <ul>

                                                    <li><a title="add to cart" href="cart.html"><i class="fa fa-shopping-basket" aria-hidden="true"></i></a></li>
                                                    <li><a href="wishlist.html" title="Add to Wishlist"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>

                                                    <li><a href="compare.html" title="Add to Compare"><i class="fa fa-sliders" aria-hidden="true"></i></a></li>

                                                </ul>
                                            </div>
                                       </div>

                                    </div>
                                    

                                    <div class="product_sale">
                                        <span>-7%</span>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <h3><a href="product-details.html">{{$item->name}}</a></h3>
                                    <span class="current_price">{{$item->sale_price}}</span>
                                    <span class="old_price">{{$item->price}}</span>
                                </div>
                            </div>
                            @endforeach

                        </div>
                     
                    
                   
                    </div>
                </div>
            </div>
               
        </div>
    </section>
    <!--product section area end-->