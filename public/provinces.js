$(document).ready(function () {
    // Lấy danh sách tỉnh thành phố từ server và đổ vào dropdown
    $.ajax({
        url: "/provinces",
        type: "GET",
        dataType: "json",
        success: function (result) {
            var province = result.provinces;
            for (var i = 0; i < province.length; i++) {
                $(".provinces").append(
                    '<option value="' +
                        province[i].id +
                        '">' +
                        province[i].name +
                        "</option>"
                );
            }
     
            var selectedProvince = $(".provinces").data("province");
            if(selectedProvince != null){
            $(".provinces").val(selectedProvince).trigger("change"); 
            }
        },
    });

    // Lấy danh sách huyện dựa trên tỉnh đã chọn
    $(".provinces").change(function () {
        var province_id = $(this).val();

        $.ajax({
            url: "/districts/" + province_id,
            type: "GET",
            dataType: "json",
            success: function (result) {
                $(".districs").empty();

                var district = result.districts;
                for (var i = 0; i < district.length; i++) {
                    $(".districs").append(
                        '<option value="' +
                            district[i].id +
                            '">' +
                            district[i].name +
                            "</option>"
                    );
                }
                var selectedDistrict = $(".districs").data("district");
                if(selectedDistrict != null){
                    $(".districs").val(selectedDistrict).trigger("change") ;// Kích hoạt sự kiện change để tự động load xã/phường

                }
            },
        });
    });

    // Lấy danh sách xã/phường dựa trên huyện đã chọn
    $(".districs").change(function () {
        var district_id = $(this).val();
        $.ajax({
            url: "/wards/" + district_id,
            type: "GET",
            dataType: "json",
            success: function (result) {
        $(".wards").empty();
              

                var wards = result.wards;
                for (var i = 0; i < wards.length; i++) {
                    $(".wards").append(
                        '<option value="' +
                            wards[i].id +
                            '">' +
                            wards[i].name +
                            "</option>"
                    );
                }
                var selectedWard = $(".wards").data("ward");
                $(".wards").val(selectedWard).trigger("change");
            },
        });
    });
});
