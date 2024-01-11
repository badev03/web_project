<header class="header_area header_shop">
    <!--header top start-->
    <div class="header_top">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-7 col-md-12">
                    <div class="welcome_text">
                        <ul>
                            <li><span>Free Delivery:</span> Take advantage of our time to save event</li>
                            <li><span>Free Returns *</span> Satisfaction guaranteed</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="top_right text-right">
                        <ul>
                            <li class="top_links"><a href="#">My Account <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_links">
                                    <li><a href="wishlist.html">My Wish List </a></li>
                                    <li><a href="my-account.html">My Account </a></li>
                                    <li><a href="#">Sign In</a></li>
                                    <li><a href="compare.html">Compare Products </a></li>
                                </ul>
                            </li>
                            <li class="language"><a href="#"><img src="assets/img/logo/language.png"
                                        alt=""> English <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_language">
                                    <li><a href="#"><img src="assets/img/logo/cigar.jpg" alt="">
                                            French</a></li>
                                    <li><a href="#"><img src="assets/img/logo/language2.png"
                                                alt="">German</a></li>
                                </ul>
                            </li>
                            <li class="currency"><a href="#">USD <i class="ion-chevron-down"></i></a>
                                <ul class="dropdown_currency">
                                    <li><a href="#">EUR</a></li>
                                    <li><a href="#">BRL</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--header top start-->

    <!--header middel start-->
    <div class="header_middel">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-5">
                    <div class="logo">
                        <a href="index.html"><img src="assets/img/logo/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="search_bar">
                        <form action="#">
                            <select class="select_option" name="select">
                                <option selected value="1">All Categories</option>
                                <option value="2">Accessories</option>
                                <option value="3">Bridge</option>
                                <option value="4">Hub</option>
                                <option value="5">Repeater</option>
                                <option value="6">Switch</option>
                                <option value="7">Video Games</option>
                                <option value="8">PlayStation 3</option>
                                <option value="9">PlayStation 4</option>
                                <option value="10">Xbox 360</option>
                                <option value="11">Xbox One</option>
                            </select>
                            <input placeholder="Search entire store here..." type="text">
                            <button type="submit"><i class="ion-ios-search-strong"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 offset-md-6 offset-lg-0">
                    <div>
                        @include('clients.layouts.login')

                    </div>
                    <div class="cart_area">

                        @include('clients.layouts.cart-mini')


                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--header middel end-->

    <!--header bottom satrt-->
    
   @include('clients.layouts.menu')
    <!--header bottom end-->
</header>




<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li>/</li>
                        <li>shop</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
