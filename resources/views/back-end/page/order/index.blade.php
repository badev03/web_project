@extends('back-end.layouts.partials.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-table">
                <div class="card-body">
                    <div class="title-header option-title">
                        <h5>Order List</h5>
                        <a href="#" class="btn btn-solid">Download all orders</a>
                    </div>
                    <div>
                        <div class="table-responsive">
                            <table class="table all-package order-table theme-table" id="table_id">
                                <thead>
                                    <tr>
                                        <th>Order Code</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Delivery Status</th>
                                        <th>Amount</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>

                                <tbody>




                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table End -->

        <!-- footer start-->
        <div class="container-fluid">
            <footer class="footer">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright 2022 © Fastkart theme by pixelstrap</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection

@push('script')
    <script>
        var table = $('.order-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('order.getData') }}",
                "type": "GET",
            },
            "columns": [{
                    "data": "order_code"
                },
                {

                    "data": "created_at",
                    "render": function(data) {
                        // Định dạng ngày tháng từ dữ liệu UNIX timestamp
                        var date = new Date(data);
                        return date.toLocaleDateString('en-US', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
                    }

                },

                {
                    "data": "payment_method"
                },
                {
                    "data": "status",
                    "render": function(data) {
                        if (data == 0) {
                            return '<span class="badge badge-warning">Pending</span>';
                        } else if (data == 1) {
                            return '<span class="badge badge-info">Processing</span>';
                        } else if (data == 2) {
                            return '<span class="badge badge-success">Completed</span>';
                        } else if (data == 3) {
                            return '<span class="badge badge-danger">Cancelled</span>';
                        }
                    }
                },
                {
                    "data": "total_amount",
                    "render": function(data) {
                        // Định dạng số tiền
                        return parseFloat(data).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                    }
                },
                {
                    "data": "action"
                },
            ],
        });
    </script>
@endpush
