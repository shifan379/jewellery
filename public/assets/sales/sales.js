// scan barcode button functionality

document
    .getElementById("scan-barcode-btn")
    .addEventListener("click", function () {
        // You can open a modal, trigger a scanner, or call a function here
        alert(
            "Open barcode scanner or activate input focus for barcode device."
        );
    });

// Add Sound
function successSound() {
    const audio = document.getElementById("successBeep");
    audio.play();
}

// Reusable click sound function
function payTouchpadClick() {
    const audio = document.getElementById("click");
    audio.play();
}

// Append value to input field
function appendToInput(inputId, value) {
    payTouchpadClick();
    const input = document.getElementById(inputId);
    if (input) input.value += value;
    changeAmount(input.value);
}

function addcashBook(value) {
    changeAmount(value);
}
function appendToQuickInput(inputId, value) {
    payTouchpadClick();
    const input = document.getElementById(inputId);
    if (input) input.value = parseFloat(input.value || 0) + parseFloat(value);
    changeAmount(input.value);
}

// Clear input field
function clearInput(inputId) {
    payTouchpadClick();
    const input = document.getElementById(inputId);
    if (input) input.value = "";
}

// Pay-In functions
function payINAmount(value) {
    appendToInput("payin", value);
}

function payINclearAmount() {
    clearInput("payin");
}

// Pay-Out functions
function payOutAmount(value) {
    appendToInput("payoutamount", value);
}

function payOutclearAmount() {
    clearInput("payoutamount");
}

// Cash Book functions
function cashBook(value) {
    appendToInput("received_amount", value);
}

function quickCashBook(value) {
    appendToQuickInput("received_amount", value);
}

function clearBook() {
    clearInput("received_amount");
}


function changeAmount(value) {
    const total = parseFloat(($(".main_total").val() || "").replace(/,/g, "").trim()) || 0;
    const totalWithBalance = parseFloat($('.total_with_balance').val()) || total;
    const change = value - totalWithBalance;


    const phone = $('#phone_number').val();
    const name = $('#customer_name').val();



    const $changeAmount = $(".change_amount");
    const $balance = $(".balance");
    const $balanceDiv = $(".balance_div");
    const $paymentCompleted = $('.payment-completed');
    const $showError = $('.show-error');
    const $advancePayment = $('.advance_payment');
    const $changeLable = $('.changeLable');

    // Reset common states
    $showError.html('');
    $advancePayment.addClass('d-none');

    if (change < 0) {
        if (phone && name) {
            $changeAmount.val(0);
            $balanceDiv.removeClass('d-none');
            $balance.val(change);
            $paymentCompleted.prop('disabled', false);
        } else {
            $changeAmount.val(0);
            $balanceDiv.addClass('d-none');
            $balance.val(null);
            $showError.html('Please add customer details before proceeding.');
            //toastr.error("Please add customer details.");
            $paymentCompleted.prop('disabled', true);
        }
    }
    else if (value > total) {
        if(phone && name){
            $changeAmount.val(change);
            $balance.val(null);
            $balanceDiv.addClass('d-none');
            $paymentCompleted.prop('disabled', false);
            $advancePayment.removeClass('d-none');
            $changeLable.html('Account settled with this balance.');

        }else{
            $changeAmount.val(change);
            $balance.val(null);
            $balanceDiv.addClass('d-none');
            $paymentCompleted.prop('disabled', false);
        }

    }
    else{
        $changeAmount.val(change);
        $balance.val(null);
        $balanceDiv.addClass('d-none');
        $paymentCompleted.prop('disabled', false);

    }
}

// General save function for PayIn and PayOut
function savePayTransaction(type) {
    payTouchpadClick();

    const amount = $(`#${type === "payin" ? "payin" : "payoutamount"}`).val();
    const reson = $(
        `#${type === "payin" ? "summernote2" : "summernote3"}`
    ).val();
    const modalId = type === "payin" ? "#payIN" : "#payout";

    if (!amount || parseFloat(amount) <= 0) {
        toastr.error("Minimum amount should be more than 0");
        return;
    }

    sendPostRequest(
        routes.payin,
        {
            _token: csrfToken,
            amount,
            reson,
            type,
        },
        function (response) {
            if (response.error) {
                toastr.error(response.error);
                return;
            }
            $("#payin").val("");
            $("#payoutamount").val("");
            $("#summernote2").val("");
            $("#summernote3").val("");
            $(modalId).modal("hide");
            toastr.success(response.message);
            speakSuccess("Payment Added");
        }
    );
}

// Specific handlers
function savePayIn() {
    savePayTransaction("payin");
}

function savePayOut() {
    savePayTransaction("payout");
}
// Main Discount Calculator function
function getCartSubtotal() {
    const rawValue = $(".main_subtotal").val()?.trim().replace(/,/g, "");
    return parseFloat(rawValue) || 0;
}

function updateDiscountFields(changedField) {
    const subtotal = getCartSubtotal();
    if (!subtotal) return;

    const isPercent = changedField.hasClass("discount_percent_total");
    const value = parseFloat(changedField.val()) || 0;

    if (isPercent) {
        $(".discount_amount_total").val(((value / 100) * subtotal).toFixed(2));
    } else {
        $(".discount_percent_total").val(((value / subtotal) * 100).toFixed(2));
    }
}

// Submit discount
function submitDiscount() {
    const data = {
        _token: csrfToken,
        discount_percent: parseFloat($(".discount_percent_total").val()) || 0,
        discount_amount: parseFloat($(".discount_amount_total").val()) || 0,
        orderID: $(".classorderID").val(),
    };

    sendPostRequest(routes.discount, data, function (res) {
        $("#showdiscount").modal("hide");
        $("#cart-body2").html(res.card);
        $("#amount").html(res.amount);
        toastr.success("Discount active.");
        speakSuccess("Discount active.");
    });

    return false;
}

function returnModel() {
    $("#return").modal("show");
        $('.customerNIC').removeClass('d-none');
        $('#customer_nic').prop('required', true);
    $("#return")
        .off("shown.bs.modal")
        .on("shown.bs.modal", function () {
            $(".scan_bill").trigger("focus");
    });
}

// Unified function for scanning or selecting product
function handleBarcodeScan(barcode) {
    const orderID = $('#orderID').val();
    // const salesType = $("#sales_type").val();
    if (!barcode) return;



    sendPostRequest(routes.scan, {
        _token: csrfToken,
        barcode: barcode,
        orderID: orderID,
        // sales_type: salesType,
    }, function (response) {
        if (response.error) {
            toastr.error(response.error);
            speakSuccess(response.error);
            return;
        }

        if (response.multiple) {
            $('#barcode .model-row').html(response.productListHtml);
            $('#barcode').modal('show');
            return;
        }

        successSound();
        $('#barcodeInput').val('').focus();
        $('#product-list tbody').html(response.card);
        $('#amount').html(response.amount);
        toastr.success('Product added successfully');
    });
}

$(document).ready(function () {
    // Clear focused input fields
    // $(document).on("focus", ".form-control", function () {
    //     $(this).val("");
    // });

    $(".discount_percent_total, .discount_amount_total").on(
        "input",
        function () {
            updateDiscountFields($(this));
        }
    );

    // Open discount modal
    $(document).on("click", ".applyDiscount", function () {
        $(".discount_percent_total, .discount_amount_total").val("");
        $("#showdiscount").modal("show");
    });

    // Active Return Session
    $(document).on("click", ".return-session", function () {
        sendPostRequest(
            routes.returnActive,
            {
                _token: csrfToken,
            },
            function (response) {
                if (response.error) {
                    toastr.error(response.error);
                    speakSuccess(response.error);
                    return;
                }

                // If single product
                successSound();
                toastr.success(response.success);
                location.reload();
            }
        );
    });

    // open cash book model
    $(document).on('click', '.payment-cash, .payment-card', function () {
        const total = $('.main_total').val() || 0;
        const return_amount = $('.main_return_amount').val() || 0;
        const custNumber = $('.phone_number').val() || '';
        const typeCust = $('.typeCust').val() || '';
        const custAmount = $('.custAmount').val() || 0;
        $('.total_amount').val(total);
        $('.valueCustomer').val(custNumber);
        $('.TotalwithBalance').addClass('d-none');


        if (total < 1 && return_amount > 1) {
            toastr.error('Cannot proceed. Please add items before selecting a payment method.');
            speakSuccess('Please add items.');
            return
        }

        if(typeCust == 'DR Amount'){
            $('.TotalwithBalance').removeClass('d-none');
            $('.total_with_balance').val(parseFloat(total) + parseFloat(custAmount));
        }else{
            $('.total_with_balance').val(0);
        }

        const isCash = $(this).hasClass('payment-cash');

        // Always show #payment-cash modal
        $('#payment-cash').modal('show').one('shown.bs.modal', function () {
            const focusInput = isCash ? '#received_amount' : '#credit_card_number';
            $(focusInput).trigger('focus');
        });

        // Set payment type
        $('.select-payment').val(isCash ? 'cash' : 'credit').trigger('change');
        // Toggle div visibility
        $('.received_div').toggleClass('d-none', !isCash);
        $('.change_div').toggleClass('d-none', !isCash);
        $('.card_div').toggleClass('d-none', isCash);
    });


    // return money to customer
    $(document).on("click", ".return-cash", function () {
        const custname = $("#customer_name").val() || "";
        const custNumber = $("#phone_number").val() || "";
        const address = $("#address").val() || "";
        const customer_nic = $("#customer_nic").val();
        const orderID = $("#orderID").val();

        if (!customer_nic){
            toastr.error("Please Enter Customer NIC.");
            speakSuccess("Please Enter Customer N I C");
            return
        }

        sendPostRequest(
            routes.returnSalesSave,
            {
                _token: csrfToken,
                phone_number: custNumber,
                orderID: orderID,
                customer_name: custname,
                customer_nic: customer_nic,
                address: address,
            },
            function (response) {
                $("#payment-completed").modal("show");
                $("#completedOrderID").val(response.order_id);
                toastr.success("Order Successfuly Completed.");
                speakSuccess("Order Successfuly Completed");
            },
            function (xhr) {
                $(".form-error").remove();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = form.find('[name="' + field + '"]');
                        input.after(
                            '<div class="text-danger form-error">' +
                                messages[0] +
                                "</div>"
                        );
                    });
                } else {
                    toastr.error("Something went wrong. Please try again.");
                }
            }
        );
    });

    // Scan barcode and add product
    $(document).ready(function () {
        let typingTimer;
        const typingInterval = 6000; // Wait 1 second after typing

        // Search on typing
        $(document).on('keyup', '.barcodeInput', function () {
            const query = $(this).val().toLowerCase().trim();
            clearTimeout(typingTimer);

            if (query.length === 0) {
                $('.search-productsList').addClass('d-none');
                return;
            }

            $('.search-productsList').removeClass('d-none');

            $('#productData li').each(function () {
                const name = $(this).text().toLowerCase().trim();
                $(this).toggle(name.includes(query));
            });

            typingTimer = setTimeout(() => {
                $('.search-productsList').addClass('d-none');
            }, typingInterval);
        });

        // Scan when Enter key is pressed (for barcode scanner)
        $(document).on('keydown', '#barcodeInput', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Stop form submit if any
                const code = $(this).val().trim();
                if (code !== '') {
                    handleBarcodeScan(code);
                }
            }
        });

        // Click on search result
        $(document).on('click', '.add-product', function () {
            const code = $(this).data('code');
            if (code) {
                $('#barcodeInput').val('');
                handleBarcodeScan(code);
                $('.search-productsList').addClass('d-none');
            }
        });

        // multiple products select barcode
        $(document).on("click", ".select-product", function () {
            const productId = $(this).data("id");
            const orderID = $("#orderID").val();

            sendPostRequest(
                routes.addProductById,
                {
                    _token: csrfToken,
                    product_id: productId,
                    orderID: orderID,
                    sales_type: $("#sales_type").val(),
                },
                function (response) {
                    $("#barcode").modal("hide");
                    successSound();
                    $("#barcodeInput").val("").focus();
                    $("#product-list tbody").html(response.card);
                    $("#amount").html(response.amount);
                    toastr.success("Product added successfully");
                }
            );
        });

        $(document).on("keyup", ".search_items", function () {
            const query = $(this).val().toLowerCase().trim();

            $(".model-row .product-card").each(function () {
                const name = $(this).data("name");
                if (name.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(document).on("keyup", ".search_by_mark", function () {
            const query = $(this).val().toLowerCase().trim();

            $(".model-row .product-card").each(function () {
                const name = $(this).data("mark");
                if (name.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Return Function
        $(".scan_bill")
            .off("change")
            .on("change", function () {
                const bill_num = $(this).val().trim();

                if (!bill_num) return;

                sendPostRequest(
                    routes.billTake,
                    {
                        _token: csrfToken,
                        bill_num: bill_num,
                    },
                    function (response) {
                        if (response.error) {
                            toastr.error(response.error);
                            speakSuccess(response.error);
                            return;
                        }

                        // If single product
                        successSound();
                        $("#search_items").val("").focus();
                        $("#return .show-bill").html(response.billHtml);
                    }
                );
            });

        // Update quantity visually and in backend
        $(document).on("click", ".increase, .decrease", function () {
            payTouchpadClick();
            const isIncrease = $(this).hasClass("increase");
            const input = $(this).siblings("input");
            const current = parseInt(input.val()) || 1;
            const newQty = isIncrease ? current + 1 : current - 1;

            input.val(Math.max(1, newQty));

            const $row = $(this).closest("tr");
            const productId = $row.data("product-id");
            const orderId = $row.data("order-id");

            sendPostRequest(
                isIncrease ? routes.increase : routes.decrease,
                {
                    product_id: productId,
                    order_id: orderId,
                    _token: csrfToken,
                },
                function (res) {
                    $("#cart-body2").html(res.card);
                    $("#amount").html(res.amount);
                    toastr.success("Cart updated successfully.");
                }
            );
        });

        // Edit cart product
        $(document).on("click", ".editCart", function () {
            payTouchpadClick();
            var row = $(this).closest("tr");

            $('#edit-product input[name="orderId"]').val(row.data("order-id"));
            $('#edit-product input[name="productId"]').val(
                row.data("product-id")
            );
            $('#edit-product input[name="product_name"]').val(
                row.data("product-name")
            );
            $('#edit-product input[name="product_price"]').val(
                row.data("product-price")
            );
            $('#edit-product input[name="discount"]').val(row.data("discount"));
            $('#edit-product input[name="qty"]').val(row.data("qty"));
            let discountType = row.data("discount-type") || "Flat";
            $('#edit-product select[name="discount_type"]')
                .val(discountType)
                .trigger("change");
            $("#edit-product").modal("show");
        });

        // Submit edit cart form
        $(document).on("submit", "#edit-cart-form", function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr("action");
            let formData = form.serialize();

            sendPostRequest(
                url,
                formData,
                function (response) {
                    $("#cart-body2").html(response.card);
                    $("#amount").html(response.amount);
                    $("#edit-product").modal("hide");
                    toastr.success("Cart updated successfully.");
                    speakSuccess("Cart updated successfully.");
                },
                function (xhr) {
                    $(".form-error").remove();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (field, messages) {
                            let input = form.find('[name="' + field + '"]');
                            input.after(
                                '<div class="text-danger form-error">' +
                                    messages[0] +
                                    "</div>"
                            );
                        });
                    } else {
                        toastr.error("Something went wrong. Please try again.");
                    }
                }
            );
        });

        // Void cart
        $(document).on("click", ".voidCart", function () {
            let orderId = $(".classorderID").val();
            $("#voidorderId").val(orderId);
            $("#reset").modal("show");
        });

        $("#restCartForm").on("submit", function (e) {
            e.preventDefault();
            sendPostRequest(
                routes.void,
                $(this).serialize(),
                function (res) {
                    $("#reset").modal("hide");
                    toastr.info(res.message);
                    location.reload();
                },
                function (xhr) {
                    toastr.error(
                        xhr.responseJSON?.message || "Error deleting product"
                    );
                }
            );
        });

        // Delete item from cart (show modal only)
        $(document).on("click", ".deleteCart", function () {
            const row = $(this).closest("tr");
            $("#deleteOrderId").val(row.data("order-id"));
            $("#deleteProductId").val(row.data("product-id"));
            $("#deleteCartModal").modal("show");
        });
        // Submit delete cart form
        $("#deleteCartForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
                url: routes.delete, // see step 4
                type: "POST",
                data: $(this).serialize(),
                success: function (res) {
                    $("#deleteCartModal").modal("hide");
                    $(
                        'tr[data-order-id="' +
                            res.orderId +
                            '"][data-product-id="' +
                            res.productId +
                            '"]'
                    ).remove();
                    // Optional: update totals
                    $("#amount").html(res.amount);
                },
                error: function (xhr) {
                    toastr.error(
                        xhr.responseJSON?.message || "Error deleting product"
                    );
                },
            });
        });

        //RETURN TABLE JS
        // Remove List for Billing invoice(Return)

        $(document).on("click", ".removewithBill", function () {
            $(this).closest("tr").remove();
        });
        // Take datas

        $(document).on("click", ".confirm-return", function () {
            let returnItems = [];
            const orderID = $("#orderID").val();

            $(".return-row:visible").each(function () {
                const $row          = $(this);
                const orderItemID   = $row.find(".orderItemID").val();
                const qty           = $row.find('input[name="qty[]"]').val();
                const weight        = $row.find('input[name="weight[]"]').val();
                const discount      = $row.find('input[name="discount[]"]').val();
                const net_price     = $row.find('input[name="net_price[]"]').val();
                const total         = $row.find('input[name="total[]"]').val();

                if (orderItemID && qty) {
                    returnItems.push({
                        orderItemID: orderItemID,
                        qty: qty,
                        weight: weight,
                        discount: discount,
                        net_price: net_price,
                        total: total,
                    });
                }
            });

            if (returnItems.length === 0) {
                toastr.error("No valid return items.");
                return;
            }

            sendPostRequest(
                routes.returnSalesCart,
                {
                    _token: csrfToken,
                    items: returnItems,
                    return: 1,
                    orderID: orderID,
                },
                function (response) {
                    if (response.error) {
                        toastr.error(response.error);
                        return;
                    }
                    $("#return .show-bill").html("");
                    $("#return").modal("hide");
                    $("#barcodeInput").val("").focus();
                    $("#product-list tbody").html(response.card);
                    $("#amount").html(response.amount);

                    toastr.success("Return items added to cart!");
                }
            );
        });
    });

    // Submit Order Main JS
    // Submit edit cart form
    // // Before submitting the payment form, copy the customer details
    // $(".payment-completed").on("click", function () {
    //     let phone = $("#phone_number").val();
    //     let name = $("#customer_name").val();

    //     // Set values in modal hidden fields
    //     $('#saveOrder input[name="phone_number"]').val(phone);
    //     $('#saveOrder input[name="customer_name"]').val(name);
    // });

    $(document).on("submit", "#saveOrder", function (e) {
        e.preventDefault();

        const address = $("#address").val();
        // Copy customer values into hidden fields
        $("#modal_phone_number").val($("#phone_number").val());
        $("#modal_customer_name").val($("#customer_name").val());
        $("#modal_customer_nic").val($("#customer_nic").val());
        $("#modal_address").val(address);

        let form = $(this);
        let url = form.attr("action");
        let formData = form.serialize();



        sendPostRequest(
            url,
            formData,
            function (response) {
                $("#payment-cash").modal("hide");

                $("#payment-completed").modal("show");
                $("#completedOrderID").val(response.order_id);
                toastr.success("Order Successfuly Completed.");
                speakSuccess("Order Successfuly Completed");
            },
            function (xhr) {
                $(".form-error").remove();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = form.find('[name="' + field + '"]');
                        input.after(
                            '<div class="text-danger form-error">' +
                                messages[0] +
                                "</div>"
                        );
                    });
                } else {
                    toastr.error("Something went wrong. Please try again.");
                }
            }
        );
    });
});
