$(document).ready(function () {
    // Kích hoạt Select2 cho dropdown #values
    $("select.select_value")
        .select2({
            tags: true,
            tokenSeparators: [",", " "],
        })
        .on("select2:selecting", function (e) {
            // Khi người dùng đang thêm một giá trị mới
            var value = e.params.args.data.id.trim().toLowerCase();

            // Lấy danh sách các giá trị đã được chọn
            var selectedValues = $(this).val() || [];
            selectedValues = selectedValues.map((v) => v.trim().toLowerCase());

            // Kiểm tra xem giá trị mới có trùng với bất kỳ giá trị nào đã được chọn chưa
            if (selectedValues.indexOf(value) > -1) {
                // Nếu giá trị đã tồn tại, hủy bỏ việc thêm giá trị mới
                e.preventDefault();
                // Cập nhật lại Select2 để hiển thị đúng giá trị đã chọn
                $(this).val(selectedValues).trigger("change.select2");
            }
        });

    // Sự kiện change cho dropdown #attributeSelect
    $("#attributeSelect").on("change", function () {
        // hiển thị đoạn html

        var attributeId = $(this).val();

        // Kiểm tra xem attributeId có giá trị hay không trước khi gọi Ajax
        if (attributeId) {
            $.ajax({
                type: "GET",
                url: getAttributeValuesUrl + attributeId,
                success: function (data) {
                    // Xóa tất cả các option hiện tại trong dropdown #values
                    $("#values").empty();

                    // Thêm các option mới từ dữ liệu Ajax
                    data.forEach(function (obj) {
                        $("#values").append(
                            '<option value="' +
                                obj.id +
                                '">' +
                                obj.value +
                                "</option>"
                        );
                    });
                    $("#values").on("change", function () {
                        // Clear existing content in #variation
                        // hiển thị đoạn html
                        $("#table-variation").show();
                        $("#variation").empty();

                        $("#values option:selected").each(function (
                            index,
                            value
                        ) {
                            $("#variation").append(
                                generateVariationContent($(value).text())
                            );
                        });
                    });

                    // Cập nhật lại Select2 để hiển thị giá trị mới
                    $("#values").trigger("change.select2");
                    // hiển thị đoạn html
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        }
    });

    function generateVariationContent(variant) {
        // Customize this function to generate content based on the selected option
        var content =
            "<tr>" +
            "<td>" +
            variant +
            "</td>" +
            '<td><input class="form-control" type="number" name="quantity[]" placeholder="0"></td>' +
            "<td>" +
            '<ul class="order-option">' +
            '<li><a href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal"><i class="ri-delete-bin-line"></i></a></li>' +
            "</ul>" +
            "</td>" +
            "</tr>";

        return content;
    }

    $("#category").on("change", function () {
        // hiển thị đoạn html

        var categoryId = $(this).val();

        // Kiểm tra xem attributeId có giá trị hay không trước khi gọi Ajax
        if (categoryId) {
            $.ajax({
                type: "GET",
                url: getSubCategoriesUrl + categoryId,

                success: function (data) {
                    // Xóa tất cả các option hiện tại trong dropdown #values
                    $("#value_cate").empty();

                    // Thêm các option mới từ dữ liệu Ajax
                    data.forEach(function (obj) {
                        $("#value_cate").append(
                            '<option value="' +
                                obj.id +
                                '" >' +
                                obj.name +
                                "</option>"
                        );
                    });

                    // Cập nhật lại Select2 để hiển thị giá trị mới
                    $("#value_cate").trigger("change.select2");
                },
                error: function (error) {
                    console.error("Error:", error);
                },
            });
        }
    });
});

$(document).ready(function () {
    $(".js-example-basic-multiple").select2();
});
$(document).ready(function () {
    $(".js-example-basic-singles").select2();
});
$(document).ready(function () {
    $(".basic-singless").select2();
});

$(document).ready(function () {
    $("#inputGroupFile04").change(function () {
        readURL(this);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#image").attr("src", e.target.result);
                $("#image").show(); // Hiển thị thẻ img sau khi chọn ảnh
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});

$(function () {
    function readURL(input, selector) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $(selector).attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function () {
        readURL(this, "#image_prev");
    });
});
$("#image_path").change(function () {
    $("#image_preview").append(
        '<button class="delete-btn" onclick="deleteAll(this)">Xóa hết</button>'
    );

    if (this.files && this.files[0]) {
        for (let i = 0; i < this.files.length; i++) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var imageItem =
                    '<div class="image-item" style="position: relative; margin: 10px;">';
                imageItem +=
                    '<img style="width: 200px" src="' + e.target.result + '"/>';
                imageItem +=
                    '<button class="delete-btn" onclick="deleteImage(this)"><i class="fas fa-times"></i></button>';
                imageItem += "</div>";
                $("#image_preview").append(imageItem);
            };

            reader.readAsDataURL(this.files[i]);
        }
    }
});

function deleteImage(btn) {
    if (confirm("Bạn có chắc chắn muốn xóa ảnh này không?")) {
        $(btn).parent().remove();
        $("#image_path").val('');



    }
}
function deleteAll(btn) {
    if (confirm("Bạn có chắc chắn muốn tất cả các ảnh này không?")) {
        $("#image_preview").empty();

        // Reset the value of the input file
        $("#image_path").val('');
    }
}


