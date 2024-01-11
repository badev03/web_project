<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from htmldemo.net/reid/reid/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Oct 2023 04:19:52 GMT -->
@include('clients.layouts.head')

<body>

    @if (!isset($headershop))
        @include('clients.layouts.header')
    @else
        @include('clients.layouts.header-shop')
    @endif
    @yield('content')


    @include('clients.layouts.footer')


</body>


<!-- Mirrored from htmldemo.net/reid/reid/index-3.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 31 Oct 2023 04:19:57 GMT -->

</html>
