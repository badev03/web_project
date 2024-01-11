    <!-- latest js -->
    <script src="{{asset('template/back-end/assets/js/jquery-3.6.0.min.js')}}"></script>

    <!-- Bootstrap js -->
    <script src="{{asset('template/back-end/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>

    <!-- feather icon js -->
    <script src="{{asset('template/back-end/assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/icons/feather-icon/feather-icon.js')}}"></script>

    <!-- scrollbar simplebar js -->
    <script src="{{asset('template/back-end/assets/js/scrollbar/simplebar.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/scrollbar/custom.js')}}"></script>

    <!-- Sidebar jquery -->
    <script src="{{asset('template/back-end/assets/js/config.js')}}"></script>

    <!-- tooltip init js -->
    <script src="{{asset('template/back-end/assets/js/tooltip-init.js')}}"></script>

    <!-- Plugins JS -->
    <script src="{{asset('template/back-end/assets/js/sidebar-menu.js')}}"></script>
    {{-- <script src="{{asset('template/back-end/assets/js/notify/bootstrap-notify.min.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/notify/index.js')}}"></script> --}}

    <!-- Apexchar js -->
    {{-- <script src="{{asset('template/back-end/assets/js/chart/apex-chart/apex-chart1.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/chart/apex-chart/moment.min.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/chart/apex-chart/apex-chart.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/chart/apex-chart/stock-prices.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/chart/apex-chart/chart-custom1.js')}}"></script> --}}


    <!-- slick slider js -->
    <script src="{{asset('template/back-end/assets/js/slick.min.js')}}"></script>
    <script src="{{asset('template/back-end/assets/js/custom-slick.js')}}"></script>

    <!-- customizer js -->
    <script src="{{asset('template/back-end/assets/js/customizer.js')}}"></script>

    <!-- ratio js -->
    <script src="{{asset('template/back-end/assets/js/ratio.js')}}"></script>

    <!-- sidebar effect -->
    <script src="{{asset('template/back-end/assets/js/sidebareffect.js')}}"></script>

    <!-- Theme js -->
    <script src="{{asset('template/back-end/assets/js/script.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

 
    <script>
     $(document).ready(function() {
         $('#table_id').DataTable();
     });
 </script>
    @stack('script')