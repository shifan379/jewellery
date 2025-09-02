<x-app-layout>
    @section('title', 'Print Barcode')

    @push('css')
        <style>

        </style>
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4 class="fw-bold">Print Barcode</h4>
                        <h6>Manage your barcodes</h6>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <ul class="table-top-head">
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                    class="ti ti-refresh"></i></a>
                        </li>
                        <li>
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                    class="ti ti-chevron-up"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="barcode-content-list">
                <form action="{{ route('barcodes.print') }}" method="post">
                    @csrf
                    <div>
                        {{-- <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="row seacrh-barcode-item mb-1">
                                    <div class="col-sm-6 mb-3 seacrh-barcode-item-one">
                                        <label class="form-label">Location<span class="text-danger ms-1">*</span></label>
                                        <select class="form-select">
                                            <option disabled value="" selected>Select</option>
                                            <option>Lavish Warehouse</option>
                                            <option>Quaint Warehouse</option>
                                            <option>Traditional Warehouse</option>
                                            <option>Cool Warehouse</option>
                                            <option>Overflow Warehouse</option>
                                            <option>Nova Storage Hub</option>
                                            <option>Retail Supply Hub</option>
                                            <option>EdgeWare Solutions</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3 search-form seacrh-barcode-item">
                                    <div class="dropdown">
                                        <div class="searchinputs input-group dropdown-toggle" id="dropdownMenuClickable"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                            <input type="text" id="searchInput" placeholder="Search">
                                            <div class="search-addon">
                                                <span><i class="ti ti-search"></i></span>
                                            </div>
                                            <span class="input-group-text"></span>
                                        </div>

                                        <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                            <div class="search-info">
                                                <ul class="customers" id="productList">
                                                    @foreach ($products as $product)
                                                        @php
                                                            $images = $product->images
                                                                ? json_decode($product->images, true)
                                                                : [];
                                                            $imageUrl = !empty($images)
                                                                ? $images[0]
                                                                : asset('assets/img/products/istockphoto.png');
                                                        @endphp
                                                        <li>
                                                            <a class="add-product"
                                                                data-name="{{ $product['product_name'] }}"
                                                                data-id="{{ $product['id'] }}"
                                                                data-mark="{{ $product['mark'] }}"
                                                                data-code="{{ $product['item_code'] }}"
                                                                data-img="{{ $imageUrl }}"
                                                                data-qty="{{ $product['quantity'] }}"
                                                                href="javascript:void(0);">{{ $product['product_name'] }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="p-3 bg-light rounded border mb-3">
                            <div class="table-responsive rounded border">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Mark</th>
                                            <th>Code</th>
                                            <th>Qty</th>
                                            <th class="text-center no-sort bg-secondary-transparent"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="selectedProducts">
                                        <!-- New rows will be added here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    <div class="search-barcode-button">

                        <a href="javascript:void(0);" class="btn btn-cancel btn-secondary fs-13 me-2" data-bs-toggle="modal"
                            data-bs-target="#setting-barcode">
                            <span><i class="fas fa-power-off me-1"></i></span>Configure Barcode
                        </a>
                        <button type="submit" class="btn btn-cancel btn-danger close-btn">
                            <span><i class="fas fa-print me-1"></i></span>Print Barcode
                        </button>
                    </div>
                </form>
            </div>
        </div>



        {{-- model --}}
        <!-- Print Barcode -->

        <div class="modal fade" id="setting-barcode">
            <div class="modal-dialog modal-dialog-centered modal-lg barcode-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Barcode Design</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16 shadow-none"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form id="barcodeForm" action="{{ route('barcode.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <div class="mb-3">
                                            <label class="form-label">Label Name:</label>
                                            <input type="text" name="label_name"
                                                value="{{ old('label_name', $bar->label_name ?? '') }}"
                                                class="form-control" placeholder="Test Label 1">
                                        </div>

                                        @php
                                            $availableFields = [
                                                'item_code' => 'Show Barcode Value (Item Code)',
                                                'shop_name' => 'Show Shop Name',
                                                'product_name' => 'Show Product Name',
                                                'selling_price' => 'Show Selling Price',
                                                'online_price' => 'Show Online Price',
                                                'description' => 'Show Description',

                                            ];
                                            $selectedFields = json_decode($bar->fields ?? '', true) ?? [];
                                        @endphp

                                        <div class="mb-3">
                                            <label class="form-label">Select fields to show:</label>
                                            @foreach ($availableFields as $field => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input  field-toggle"
                                                        {{ in_array($field, $selectedFields) ? 'checked' : '' }}
                                                        type="checkbox" name="fields[]" value="{{ $field }}"
                                                        id="show_{{ $field }}">
                                                    <label class="form-check-label"
                                                        for="show_{{ $field }}">{{ $label }}</label>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Barcode Width (mm):</label>
                                            <input type="number" name="bar_width"
                                                value="{{ old('bar_width', $bar->barcode_width ?? '') }}"
                                                class="form-control" id="labelWidth">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Barcode Height (mm):</label>
                                            <input type="number" name="bar_height"
                                                value="{{ old('bar_height', $bar->barcode_hight ?? '') }}"
                                                class="form-control" id="labelHeight">
                                        </div>
                                        @php
                                            $fontFamily = [
                                                'Arial',
                                                'Arial_Bold',
                                                'Verdana',
                                                'Courier New',
                                                'Times New Roman',
                                            ];
                                        @endphp
                                        <div class="mb-3">
                                            <label class="form-label">Font Family:</label>
                                            <select id="fontFamily" name="font_family" class="form-select">
                                                @foreach ($fontFamily as $font)
                                                    <option value="{{ $font }}"
                                                        @if ($font == optional($bar)->font_family) selected @endif>
                                                        {{ $font }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Font Size (px):</label>
                                            <input type="number" name="font_size" class="form-control" id="fontSize"
                                                value="{{ old('font_size', $bar->font_size ?? '') }}" min="8"
                                                max="32">
                                        </div>

                                        <div class="discount-wrapper d-flex align-items-center mb-3">
                                            <div class="discount-group d-inline-flex align-items-center">
                                                <label class="me-2">Label Size</label>
                                                <div class="discount-input me-2">
                                                    <input type="number" name="lable_width"
                                                        class="discount_percent form-control" min="0"
                                                        value="{{ old('lable_width', $bar->label_width ?? '') }}"
                                                        placeholder="Width">
                                                    <span>mm</span>
                                                </div>
                                                x
                                                <div class="discount-input">
                                                    <input type="number" name="lable_height"
                                                        class="discount_amount form-control" min="0"
                                                        value="{{ old('lable_height', $bar->label_hight ?? '') }}"
                                                        placeholder="Height">
                                                    <span>mm</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Label count per row:</label>
                                            <input type="number" name="label_count" class="form-control"
                                                value="{{ old('label_count', $bar->lable_count_row ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <center>
                                        <div class="barcode-preview">
                                            <svg id="barcode" class="barscaner-img"></svg>
                                            <div id="previewDetails" class="mt-3"></div>
                                        </div>
                                    </center>

                                </div>
                            </div>

                            <div class="mt-3 d-flex justify-right-between">

                                <button type="submit" class="btn btn-primary">Save</button>
                                &nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>



    @endsection




    @push('js')
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
        <!-- Summernote JS -->
        <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}" type="text/javascript"></script>

        <!-- Chart JS -->
        <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}" type="text/javascript"></script>

        <!-- Sticky-sidebar -->
        <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}" type="text/javascript">
        </script>

        <script data-cfasync="false" src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

        <script>
            // Example product data (replace or pass dynamically as needed)
            const productData = {
                product_name: "Test Product",
                selling_price: 'Rs 250.00',
                online_price: 'Rs 200.00',
                item_code: "123456789",
                description: "QWERT",
                shop_name: "SHOP NAME"
            };

            function mmToPx(mm) {
                return mm * 3.7795275591; // approx. 96 dpi
            }

            function generateBarcode() {
                const heightMM = parseFloat($('#labelHeight').val()) || 25;
                const widthMM = parseFloat($('#labelWidth').val()) || 50;

                const height = mmToPx(heightMM);
                const width = mmToPx(widthMM) / 100;
                const fontSize = parseInt($('#fontSize').val()) || 14;

                let previewHTML = '';

                $('.field-toggle:checked').each(function() {
                    const field = $(this).val();
                    if (field === 'item_code') {
                        previewHTML += '<svg class="barcode-mini" id="itemcode-barcode"></svg>';
                    } else {
                        previewHTML += `<div style="font-size:${fontSize}px">${productData[field]}</div>`;
                    }
                });

                $('#previewDetails').html(previewHTML);

                if ($('.field-toggle[value="item_code"]').is(':checked')) {
                    JsBarcode("#itemcode-barcode", productData.item_code, {
                        format: "CODE128",
                        height: height / 2,
                        width: width,
                        displayValue: true,
                        fontSize: fontSize - 2,
                        margin: 5
                    });
                }
            }

            $(document).ready(function() {
                // When the modal opens, generate barcode preview
                $('#setting-barcode').on('shown.bs.modal', function() {
                    generateBarcode();
                });

                // When any input or select changes, regenerate barcode
                $('#barcodeForm input, #barcodeForm select').on('change input', function() {
                    generateBarcode();
                });
            });
        </script>


        <script>
            $(document).ready(function() {
                $(document).ready(function() {
                    $("#searchInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase().trim();
                        $("#productList li").filter(function() {
                            $(this).toggle(
                                $(this).text().toLowerCase().indexOf(value) > -1
                            );
                        });
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('click', '.add-product', function() {
                    var id = $(this).data('id');
                    var name = $(this).data('name');
                    var mark = $(this).data('mark');
                    var code = $(this).data('code');
                    var img = $(this).data('img');
                   var qty = parseInt($(this).data('qty'));

                    var newRow = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                        <img src="${img}" alt="product">
                                    </a>
                                    <a href="javascript:void(0);">${name}
                                        <input type="hidden" value="${id}" name="ids[]">
                                        </a>
                                </div>
                            </td>
                            <td>${mark}</td>
                            <td>${code}</td>
                            <td>
                                <div class="product-quantity border-secondary-transparent">
                                    <span class="quantity-btn minus"><i data-feather="minus-circle"></i></span>
                                    <input type="text" name="qtys[]" class="quntity-input" value="${qty}">
                                    <span class="quantity-btn plus"><i data-feather="plus-circle"></i></span>
                                </div>
                            </td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a class="remove-row" href="javascript:void(0);">
                                        <i data-feather="trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                    $("#selectedProducts").append(newRow);

                    // Refresh Feather icons
                    if (feather) {
                        feather.replace();
                    }
                });

                // Quantity buttons
                $(document).on('click', '.quantity-btn.minus', function() {
                    var input = $(this).siblings('input');
                    var value = parseInt(input.val()) || 1;
                    if (value > 1) {
                        input.val(value - 1);
                    }
                });
                $(document).on('click', '.quantity-btn.plus', function() {
                    var input = $(this).siblings('input');
                    var value = parseInt(input.val()) || 1;
                    input.val(value + 1);
                });

                // Remove row
                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                });
            });
        </script>
    @endpush
</x-app-layout>
