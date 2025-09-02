

// Add Sound
function successSound() {
    const audio = document.getElementById('successBeep');
    audio.play();
}

// Reusable click sound function
function payTouchpadClick() {
    const audio = document.getElementById('click');
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
    if (input) input.value = '';
}

// Pay-In functions
function payINAmount(value) {
    appendToInput('payin', value);
}

function payINclearAmount() {
    clearInput('payin');
}

// Pay-Out functions
function payOutAmount(value) {
    appendToInput('payoutamount', value);
}

function payOutclearAmount() {
    clearInput('payoutamount');
}

// Cash Book functions
function cashBook(value) {
    appendToInput('received_amount', value);
}

function quickCashBook(value) {
    appendToQuickInput('received_amount', value);
}

function clearBook() {
    clearInput('received_amount');
}

// change amount money
function changeAmount(value) {
    const total = parseFloat($('.main_total').val()?.replace(/,/g, '').trim()) || 0;
    const change = value - total;

    $('.change_amount').val(change);

    if (change < 0) {
        $('.payment-completed').prop('disabled', true); // Replace with your actual button ID
    } else {
        $('.payment-completed').prop('disabled', false);
    }

}
// General save function for PayIn and PayOut
function savePayTransaction(type) {
    payTouchpadClick();

    const amount = $(`#${type === 'payin' ? 'payin' : 'payoutamount'}`).val();
    const reson = $(`#${type === 'payin' ? 'summernote2' : 'summernote3'}`).val();
    const modalId = type === 'payin' ? '#payIN' : '#payout';

    if (!amount || parseFloat(amount) <= 0) {
        toastr.error('Minimum amount should be more than 0');
        return;
    }

    sendPostRequest(routes.payin, {
        _token: csrfToken,
        amount,
        reson,
        type,
    }, function (response) {
        if (response.error) {
            toastr.error(response.error);
            return;
        }
        $('#payin').val('');
        $('#payoutamount').val('');
        $('#summernote2').val('');
        $('#summernote3').val('');
        $(modalId).modal('hide');
        toastr.success(response.message);
        speakSuccess('Payment Added');
    });
}

// Specific handlers
function savePayIn() {
    savePayTransaction('payin');
}

function savePayOut() {
    savePayTransaction('payout');
}
// Main Discount Calculator function
function getCartSubtotal() {
    const rawValue = $('.main_subtotal').val()?.trim().replace(/,/g, '');
    return parseFloat(rawValue) || 0;
}

function updateDiscountFields(changedField) {
    const subtotal = getCartSubtotal();
    if (!subtotal) return;

    const isPercent = changedField.hasClass('discount_percent_total');
    const value = parseFloat(changedField.val()) || 0;

    if (isPercent) {
        $('.discount_amount_total').val(((value / 100) * subtotal).toFixed(2));
    } else {
        $('.discount_percent_total').val(((value / subtotal) * 100).toFixed(2));
    }
}

// Submit discount
function submitDiscount() {
    const data = {
        _token: csrfToken,
        discount_percent: parseFloat($('.discount_percent_total').val()) || 0,
        discount_amount: parseFloat($('.discount_amount_total').val()) || 0,
        orderID: $('.classorderID').val()
    };

    sendPostRequest(routes.discount, data, function (res) {
        $('#discount').modal('hide');
        $('#cart-body').html(res.cartHtml);
        $('#amount-section').html(res.amountHtml);
        toastr.success('Discount active.');
        speakSuccess('Discount active.');
    });

    return false;
}

// append customer phone number in to inputfiled
function addnumber(val) {
    $('#searchInput').val('');
    $('#searchInput').val(val);
}

// return modle show funtion
function returnModel() {


    $('#return').modal('show');
    $('#return').off('shown.bs.modal').on('shown.bs.modal', function () {
        $('.scan_bill').trigger('focus');
    });

}




// Unified function for scanning or selecting product
function handleBarcodeScan(barcode) {
    const orderID = $('#orderID').val();
    if (!barcode) return;

    sendPostRequest(routes.scan, {
        _token: csrfToken,
        barcode: barcode,
        orderID: orderID
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
        $('#product-list tbody').html(response.cartHtml);
        $('#amount-section').html(response.amountHtml);
        toastr.success('Product added successfully');
    });
}



$(document).ready(function () {

    // Clear focused input fields
    $(document).on('focus', '.form-control', function () {
        $(this).val('');
    });

    $('.discount_percent_total, .discount_amount_total').on('input', function () {
        updateDiscountFields($(this));
    });

    // Open discount modal
    $(document).on('click', '.applyDiscount', function () {
        $('.discount_percent_total, .discount_amount_total').val('');
        $('#discount').modal('show');
    });

    // Active Return Session
    $(document).on('click', '.return-session', function () {


        sendPostRequest(routes.returnActive, {
            _token: csrfToken,

        }, function (response) {
            if (response.error) {
                toastr.error(response.error);
                speakSuccess(response.error);
                return;
            }

            // If single product
            successSound();
            toastr.success(response.success);
            location.reload();

        });
    });

    // open cash book model
    $(document).on('click', '.payment-cash, .payment-card', function () {
        const total = $('.main_total').val() || 0;
        const return_amount = $('.main_return_amount').val() || 0;
        const custNumber = $('.customer_number').val() || '';
        $('.total_amount').val(total);
        $('.valueCustomer').val(custNumber);

        if (total < 1 && return_amount > 1) {
            toastr.error('Cannot proceed. Please add items before selecting a payment method.');
            speakSuccess('Please add items.');
            return
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
    $(document).on('click', '.return-cash', function () {
        const custNumber = $('.customer_number').val() || '';
        const orderID = $('#orderID').val();

        sendPostRequest(routes.returnSave, {
            _token: csrfToken,
            customer_number: custNumber,
            orderID: orderID
        }, function (response) {
            $('#payment-completed').modal('show');
            $('#completedOrderID').val(response.order_id);
            toastr.success('Order Successfuly Completed.');
            speakSuccess('Order Successfuly Completed');

        }, function (xhr) {
            $('.form-error').remove();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    let input = form.find('[name="' + field + '"]');
                    input.after('<div class="text-danger form-error">' + messages[0] + '</div>');
                });
            } else {
                toastr.error('Something went wrong. Please try again.');
            }
        });


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
        $(document).on('click', '.select-product', function () {
            const productId = $(this).data('id');
            const orderID = $('#orderID').val();

            sendPostRequest(routes.addProductById, {
                _token: csrfToken,
                product_id: productId,
                orderID: orderID
            }, function (response) {
                $('#barcode').modal('hide');
                successSound();
                $('#barcodeInput').val('').focus();
                $('#product-list tbody').html(response.cartHtml);
                $('#amount-section').html(response.amountHtml);
                toastr.success('Product added successfully');
            });
        });



        $(document).on('keyup', '.search_items', function () {
            const query = $(this).val().toLowerCase().trim();

            $('.model-row .product-card').each(function () {
                const name = $(this).data('name');
                if (name.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(document).on('keyup', '.search_by_mark', function () {
            const query = $(this).val().toLowerCase().trim();

            $('.model-row .product-card').each(function () {
                const name = $(this).data('mark');
                if (name.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        $(document).on('keyup', '#searchInput', function () {
            const query = $(this).val().toLowerCase().trim();

            $('#productList li').each(function () {
                const phone = $(this).text().toLowerCase().trim();

                if (phone.includes(query)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });


        // Return Function
        $('.scan_bill').off('change').on('change', function () {
            const bill_num = $(this).val().trim();

            if (!bill_num) return;

            sendPostRequest(routes.billTake, {
                _token: csrfToken,
                bill_num: bill_num,

            }, function (response) {
                if (response.error) {
                    toastr.error(response.error);
                    speakSuccess(response.error);
                    return;
                }

                // If single product
                successSound();
                $('#search_items').val('').focus();
                $('#return .show-bill').html(response.billHtml);
            });
        });


        // Update quantity visually and in backend
        $(document).on('click', '.increase, .decrease', function () {
            payTouchpadClick();
            const isIncrease = $(this).hasClass('increase');
            const input = $(this).siblings('input');
            const current = parseInt(input.val()) || 1;

            const newQty = isIncrease ? current + 1 : current - 1;

            input.val(Math.max(1, newQty));

            const $row = $(this).closest('tr');
            const productId = $row.data('product-id');
            const orderId = $row.data('order-id');

            sendPostRequest(
                isIncrease ? routes.increase : routes.decrease,
                {
                    product_id: productId,
                    order_id: orderId,
                    _token: csrfToken
                },
                function (res) {
                    $('#cart-body').html(res.cartHtml);
                    $('#amount-section').html(res.amountHtml);
                    toastr.success('Cart updated successfully.');
                }
            );
        });

        document.addEventListener('DOMContentLoaded', function () {
            var qtyInputs = document.querySelectorAll('.cart-qty-input');

            qtyInputs.forEach(function (input) {
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' && this.dataset.unit === 'kg') {
                        e.preventDefault(); // Stop default Enter action
                        this.closest('form').submit();
                    }
                });
            });
        });


        $(document).on('submit', '.qty-form', function (e) {
            payTouchpadClick();
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            sendPostRequest(url, formData, function (res) {
                $('#cart-body').html(res.cartHtml);
                $('#amount-section').html(res.amountHtml);
                toastr.success('Cart updated successfully.');
            }, function (xhr) {
                    toastr.error('Something went wrong. Please try again.');
            });
        });

        // remove current qty when click cart-qty-input
        $(document).on('click', '.remove-text', function () {
            $(this).val('');
        });

        // Edit cart product
        $(document).on('click', '.editCart', function () {
            payTouchpadClick();
            var row = $(this).closest('tr');

            $('#edit-product input[name="orderId"]').val(row.data('order-id'));
            $('#edit-product input[name="productId"]').val(row.data('product-id'));
            $('#edit-product input[name="product_name"]').val(row.data('product-name'));
            $('#edit-product input[name="product_price"]').val(row.data('product-price'));
            $('#edit-product input[name="discount"]').val(row.data('discount'));
            $('#edit-product input[name="qty"]').val(row.data('qty'));
            let discountType = row.data('discount-type') || 'Flat';
            $('#edit-product select[name="discount_type"]')
                .val(discountType)
                .trigger('change');
            $('#edit-product').modal('show');
        });

        // Submit edit cart form
        $(document).on('submit', '#edit-cart-form', function (e) {
            e.preventDefault();
            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            sendPostRequest(url, formData, function (response) {
                $('#cart-body').html(response.cartHtml);
                $('#amount-section').html(response.amountHtml);
                $('#edit-product').modal('hide');
                toastr.success('Cart updated successfully.');
                speakSuccess('Cart updated successfully.');
            }, function (xhr) {
                $('.form-error').remove();
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = form.find('[name="' + field + '"]');
                        input.after('<div class="text-danger form-error">' + messages[0] + '</div>');
                    });
                } else {
                    toastr.error('Something went wrong. Please try again.');
                }
            });
        });

        // Void cart
        $(document).on('click', '.voidCart', function () {
            let orderId = $('.classorderID').val();
            $('#voidorderId').val(orderId);
            $('#reset').modal('show');
        });

        $('#restCartForm').on('submit', function (e) {
            e.preventDefault();
            sendPostRequest(routes.void, $(this).serialize(), function (res) {
                $('#reset').modal('hide');
                toastr.info(res.message);
                location.reload();
            }, function (xhr) {
                toastr.error(xhr.responseJSON?.message || 'Error deleting product');
            });
        });

        // Delete item from cart (show modal only)
        $(document).on('click', '.deleteCart', function () {
            const row = $(this).closest('tr');
            $('#deleteOrderId').val(row.data('order-id'));
            $('#deleteProductId').val(row.data('product-id'));
            $('#deleteCartModal').modal('show');
        });
        // Submit delete cart form
        $('#deleteCartForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: routes.delete, // see step 4
                type: "POST",
                data: $(this).serialize(),
                success: function (res) {
                    $('#deleteCartModal').modal('hide');
                    $('tr[data-order-id="' + res.orderId + '"][data-product-id="' + res.productId + '"]').remove();
                    // Optional: update totals
                    $('#amount-section').html(res.amountHtml);
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Error deleting product');
                }
            });
        });

        //RETURN TABLE JS
        // Remove List for Billing invoice(Return)

        $(document).on('click', '.removewithBill', function () {
            $(this).closest('tr').remove();
        });
        // Take datas

        $(document).on('click', '.confirm-return', function () {
            let returnItems = [];
            const orderID = $('#orderID').val();

            $('.return-row:visible').each(function () {
                const $row = $(this);
                const orderItemID = $row.find('.orderItemID').val();
                const qty = $row.find('input[name="qty[]"]').val();

                if (orderItemID && qty) {
                    returnItems.push({

                        orderItemID: orderItemID,
                        qty: qty
                    });
                }
            });

            if (returnItems.length === 0) {
                toastr.error("No valid return items.");
                return;
            }

            sendPostRequest(routes.returnCart, {
                _token: csrfToken,
                items: returnItems,
                return: 1,
                orderID: orderID,
            }, function (response) {
                if (response.error) {
                    toastr.error(response.error);
                    return;
                }
                $('#return .show-bill').html('');
                $('#return').modal('hide');
                $('#barcodeInput').val('').focus();
                $('#product-list tbody').html(response.cartHtml);
                $('#amount-section').html(response.amountHtml);
                toastr.success('Return items added to cart!');
            });
        });



    });


    // Submit Order Main JS
    // Submit edit cart form
    $(document).on('submit', '#saveOrder', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let formData = form.serialize();

        sendPostRequest(url, formData, function (response) {

            $('#payment-cash').modal('hide');

            $('#payment-completed').modal('show');
            $('#completedOrderID').val(response.order_id);
            toastr.success('Order Successfuly Completed.');
            speakSuccess('Order Successfuly Completed');

        }, function (xhr) {
            $('.form-error').remove();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function (field, messages) {
                    let input = form.find('[name="' + field + '"]');
                    input.after('<div class="text-danger form-error">' + messages[0] + '</div>');
                });
            } else {
                toastr.error('Something went wrong. Please try again.');
            }
        });
    });



});
