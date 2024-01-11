

<div class="col-lg-9 col-md-12">
    <!--shop wrapper start-->
    <!--shop toolbar start-->
    <div class="shop_title">
        <h1>shop</h1>
    </div>
    <div class="shop_toolbar_wrapper">
        <div class="shop_toolbar_btn">

            <button data-role="grid_3" type="button" class="active btn-grid-3" data-bs-toggle="tooltip" title="3"></button>

            <button data-role="grid_4" type="button"  class=" btn-grid-4" data-bs-toggle="tooltip" title="4"></button>

            <button data-role="grid_5" type="button"  class="btn-grid-5" data-bs-toggle="tooltip" title="5"></button>

            <button data-role="grid_list" type="button"  class="btn-list" data-bs-toggle="tooltip" title="List"></button>
        </div>
        <div class=" niceselect_option">

            <form class="select_option" action="#">
                <select name="orderby" id="short">

                    <option selected value="1">Sort by average rating</option>
                    <option  value="2">Sort by popularity</option>
                    <option value="3">Sort by newness</option>
                    <option value="4">Sort by price: low to high</option>
                    <option value="5">Sort by price: high to low</option>
                    <option value="6">Product Name: Z</option>
                </select>
            </form>


        </div>
        <div class="page_amount">
            <p>Showing 1–9 of 21 results</p>
        </div>
    </div>
     <!--shop toolbar end-->
    
     <div class="row shop_wrapper">
        @foreach ($products as $item)
        <div class="col-lg-4 col-md-4 col-12 ">
          
    
                
        
            <div class="single_product">
                <div class="product_thumb">
                    <a class="primary_img" href="{{route('productDetail',['slug'=>$item->slug])}}"><img src="{{$item->image}}" alt=""></a>
                    <a class="secondary_img" href="product-details.html"><img src="assets/img/product/product16.jpg" alt=""></a>
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
                  
                    <div class="double_base">
                        <div class="product_sale">
                            <span>-7%</span>
                        </div>
                        <div class="label_product">
                            <span>new</span>
                        </div>
                    </div>
                </div>
                
                <div class="product_content grid_content">
                    <h3><a href="product-details.html">{{$item->name}}</a></h3>
                    <span class="current_price">{{number_format($item->sale_price,0,',','.')}}</span>
                    <span class="old_price">{{number_format($item->price,0,',','.')}}</span>
                </div>
                
                
                <div class="product_content list_content">
                    <h3><a href="product-details.html"></a></h3>
                    <div class="product_ratting">
                        <ul>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                            <li><a href="#"><i class="fa fa-star"></i></a></li>
                        </ul>
                    </div>
                    <div class="product_price">
                        <span class="current_price">{{$item->sale_price}}</span>
                        <span class="old_price">{{$item->price}}</span>
                    </div>
                    <div class="product_desc">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nobis ad, iure incidunt. Ab consequatur temporibus non eveniet inventore doloremque necessitatibus sed, ducimus quisquam, ad asperiores eligendi quia fugiat minus doloribus distinctio assumenda pariatur, quidem laborum quae quasi suscipit. Cupiditate dolor blanditiis rerum aliquid temporibus, libero minus nihil, veniam suscipit? Autem repellendus illo, amet praesentium fugit, velit natus? Dolorum perferendis reiciendis in quam porro ratione eveniet, tempora saepe ducimus, alias?</p>
                    </div>

                </div>
                
            </div>
         
        </div>
        @endforeach
      
    </div>
  
    <div class="shop_toolbar t_bottom">
        <div class="pagination">
            <ul>
                <li class="current">1</li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li class="next"><a href="#">next</a></li>
                <li><a href="#">>></a></li>
            </ul>
        </div>
    </div>
    <!--shop toolbar end-->
    <!--shop wrapper end-->
</div>
