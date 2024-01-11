<div class="col-lg-3 col-md-12">
    <!--sidebar widget start-->
    <div class="sidebar_widget">
        <div class="widget_list widget_categories">
            <h2>Danh mục</h2>
            <ul>
                @foreach ($categories as $category)
                    <li><a href="javascript:void(0)" class="filter-link" data-type="category"
                            data-value="{{ $category->id }}">{{ $category->name }}<span>{{ $category->products_count }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="widget_list widget_categories">
            <h2>Thương hiệu</h2>
            <ul>
                @foreach ($brands as $brand)
                    <li><a href="#" class="filter-link" data-type="brand"
                            data-value="{{ $brand->id }}">{{ $brand->name }}<span>{{ $brand->products_count }}</span></a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="widget_list widget_categories">
            <h2>Tìm thuộc tính</h2>
            <div class="main_menu">
                <nav>
                    <ul>
                        @foreach ($attributes as $attribute)
                            <li>
                                <a href="#" class="filter-link" data-type="attribute"
                                    data-value="{{ $attribute->id }}">{{ $attribute->name }} <i
                                        class="fa fa-angle-down"></i></a>
                                <ul class="sub_menu">
                                    @foreach ($attribute->values as $value)
                                        <li><a href="#" class="filter-link" data-type="attribute_value"
                                                data-value="{{ $value->id }}">{{ $value->value }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!--sidebar widget end-->
</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




    {{-- <script>
        $(document).ready(function() {
            $('.filter-link').click(function() {
                console.log('ok');
                var type = $(this).data('type');
                var value = $(this).data('value');
            
                $.ajax({
                    url: "{{ route('filterProducts', ['type' => 'dummy', 'value' => 'dummy']) }}".replace('dummy', type).replace('dummy', value),
                    method: "GET",
                    data: {
                        type: type,
                        value: value
                    },

                    success: function(data) {
                        console.log(data);
                        // $('.shop_wrapper').html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }

                })
            })
        });
    </script> --}}
@endpush
