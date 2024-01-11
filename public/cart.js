$(document).ready(function () {
    $("#cartproduct").on("click", function (e) {
        e.preventDefault();

        var productDetails = $(this).closest(".product_details");
        var productId = productDetails.find(".product_id").val();
        var quantity = productDetails.find(".quanlity").val();
        var variant = productDetails.find(".variant").data("variant-value");

        var attribute = productDetails
            .find(".niceselect_option.attribute option:selected")
            .val();
        var price = $(".current_price").data("price");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: "/add-to-cart/" + productId,
            method: "POST",
            data: {
                product_id: productId,
                quantity: quantity,
                variant: variant,
                attribute: attribute,
                sale_price: price,
            },
            success: function (response) {
                // Xử lý thành công
                console.log(response);
                $(".cart_link").html(response.miniCartHtml);

                $("#errorContainer").hide();
            },
            error: function (xhr) {
                // Xử lý lỗi

                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = "<ul>";
                    $.each(errors, function (index, error) {
                        errorHtml += "<li>" + error + "</li>";
                    });
                    errorHtml += "</ul>";
                    $("#errorContainer").html(errorHtml).show();
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $("#errorContainer").html(xhr.responseJSON.message).show();
                } else {
                    $("#errorContainer")
                        .html("Có lỗi xảy ra trong quá trình xử lý yêu cầu.")
                        .show();
                }
            },
        });
    });

    $(document).on("click", ".cart_remove a", function (e) {
        e.preventDefault();
        var ele = $(this);
        var variant = ele.closest(".cart_item").data("variant"); // Lấy data-id của sản phẩm
        if (confirm("Are you sure you want to remove this item?")) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.ajax({
                url: "/remove-cart",
                method: "DELETE",
                data: {
                    variant: variant, // Truyền id của sản phẩm cần xóa
                },
                success: function (response) {
                    // Nếu xóa thành công, làm mới trang để cập nhật giỏ hàng
                    window.location.reload();
                    $(".cart_link").html(response.miniCartHtml);
                },
                error: function (xhr) {
                    // Xử lý lỗi
                    console.error(xhr);
                    alert("Something went wrong!");
                },
            });
        }
    });
});

$(function () {
    $(".quantity-input").on("change", function () {
        var row = $(this).closest("tr");
        var productId = row.find(".remove-item").data("product-id");
        var quantity = $(this).val();
        var price = row.find(".product-price").data("price");
        var variant = row.find(".variant-input").data("variant");
        var attribute = row.find(".attribute-input").data("attribute");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        if (
            quantity !== undefined &&
            variant !== undefined &&
            attribute !== undefined
        ) {
            $.ajax({
                url: "/update-cart/" + productId,
                method: "POST",
                data: {
                    quantity: quantity,
                    variant: variant,
                    attribute: attribute,
                    product_id: productId,
                },
                success: function (response) {
                    console.log(response);
                    var total = quantity * price;
                    var formattedtotal = total.toLocaleString("vi-VN", {
                        style: "currency",
                        currency: "VND",
                    });
                    $(".cart_link").html(response.miniCartHtml);
                    row.find(".product_total").html(formattedtotal);
                    subtotal = response.totalPrice;
                    var formattedtotalSub = subtotal.toLocaleString("vi-VN", {
                        style: "currency",
                        currency: "VND",
                    });
                    $(".sub").text(formattedtotalSub);
                    var totalall = parseFloat(response.totalPrice) + 30000;
                    // Add 30000 to the value
                    var formattedtotalAll = totalall.toLocaleString("vi-VN", {
                        style: "currency",
                        currency: "VND",
                    });
                    $(".su").text(formattedtotalAll);
                    $("#errorContainer").hide();
                },
                error: function (xhr) {
                    // Hiển thị message lỗi được truyền từ bên controller bằng alert

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = "<ul>";

                        $.each(errors, function (index, error) {
                            errorHtml += "<li>" + error + "</li>";
                        });

                        errorHtml += "</ul>";

                        $("#errorContainer").html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Kiểm tra nếu tồn tại message
                        $("#errorContainer")
                            .html(xhr.responseJSON.message)
                            .show();
                    } else {
                        $("#errorContainer")
                            .html(
                                "Có lỗi xảy ra trong quá trình xử lý yêu cầu."
                            )
                            .show();
                    }
                },
            });
        } else {
            alert("lỗi");
        }
    });
});



// $(function () {
//     $("#provinces").on("click", function () {
//         alert("ok");

        // $.ajax({
        //     url: "/provinces",
        //     method: "GET",
        //     success: function (data) {
        //         // Xóa các option cũ nếu có
        //         $("#province").empty();

        //         // Thêm option mới từ dữ liệu nhận được
        //         for (var i = 0; i < data.length; i++) {
        //             $("#province").append(
        //                 '<option value="' +
        //                     data[i].gso_id +
        //                     '">' +
        //                     data[i].name +
        //                     "</option>"
        //             );
        //         }
        //     },
        //     error: function (xhr) {
        //         console.log(xhr);
        //     },
    //     });
    // });

    // $("#provinces").on("change", function () {
    //     var provinceId = $(this).val();
    //     $.ajax({
    //         url: "/districts/" + provinceId,
    //         method: "GET",
    //         success: function (data) {
    //             $("#districts").html(data);
    //         },
    //     });
    // });
