<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

        <style>
            .product-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                max-height: 200px;
                overflow-y: auto;
                background: #fff;
                border: 1px solid #ccc;
                z-index: 2000;
                display: none;
            }

            .product-suggestions .product-item {
                padding: 5px 10px;
                cursor: pointer;
            }

            .product-suggestions .product-item:hover {
                background-color: #f0f0f0;
            }

            .search-productsList {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                max-height: 250px;
                overflow-y: auto;
                background: #fff;
                border: 1px solid #ccc;
                z-index: 2000;
            }

            .search-productsList li a {
                display: block;
                padding: 8px 10px;
                cursor: pointer;
            }

            .search-productsList li a:hover {
                background-color: #f0f0f0;
            }
        </style>
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Quotation List</h4>
                        <h6>Manage Your Quotation</h6>
                    </div>
                </div>
                <div class="page-btn">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-quotation"><i
                            class="ti ti-circle-plus me-1"></i>Add Quotation</a>
                </div>


            </div>

            <!-- /product list -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input"> <span class="btn-searchset"><i
                                    class="ti ti-search fs-14 feather-search"></i></span> </div>
                    </div>
                    {{-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <div class="dropdown me-2"> <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown"> Product </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Lenovo IdeaPad 3</a>
                                </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Beats Pro</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Nike Jordan</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Apple Series 5 Watch</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown me-2"> <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown"> Customer </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Carl Evans</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Minerva Rameriz</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Robert Lamon</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Patricia Lewis</a> </li>
                            </ul>
                        </div>
                        <div class="dropdown me-2"> <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown"> Status </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Sent</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Pending</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Ordered</a> </li>
                            </ul>
                        </div>
                        <div class="dropdown"> <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown"> Sort By : Last 7 Days </a>
                            <ul class="dropdown-menu dropdown-menu-end p-3">
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Recently Added</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Last Month</a> </li>
                                <li> <a href="javascript:void(0);" class="dropdown-item rounded-1">Last 7 Days</a> </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <!-- Quotation Table -->
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($quotations as $quotation)
                                    @php
                                        $firstItem = $quotation->items->first();
                                        $firstProduct = $firstItem?->product;
                                    @endphp
                                    <tr>
                                        <td>QUT00{{ $quotation->id }}</td>
                                        <td>
                                            @if ($quotation->items->count() > 1)
                                                {{ $firstProduct?->product_name ?? 'No Product' }} +
                                                {{ $quotation->items->count() - 1 }} more
                                            @else
                                                {{ $firstProduct?->product_name ?? 'No Product' }}
                                            @endif
                                        </td>
                                        <td>{{ $quotation->items->sum('quantity') }}</td>
                                        <td>{{ $quotation->customer?->first_name ?? 'Guest' }}</td>
                                        <td>Rs.{{ number_format($quotation->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('quotation.show', $quotation->id) }}"
                                                class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('quotation.print', $quotation->id) }}"
                                                class="btn btn-sm btn-outline-secondary"><i class="fas fa-print"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div> <!-- /product list -->

            <!-- Add Quotation Modal -->
            <div class="modal fade" id="add-quotation">
                <div class="modal-dialog purchase modal-dialog-centered stock-adjust-modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="page-title">
                                <h4>Add Quotation</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form action="{{ route('quotation.store') }}" method="POST" id="quotationForm">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Customer Name -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Name <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" name="customer_id" required>
                                                <option value="">--Select--</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->first_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Date -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Date <span class="text-danger">*</span></label>
                                            <input type="date" name="date" class="form-control" placeholder="Choose"
                                                required>
                                        </div>
                                    </div>
                                    <!-- Reference -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Reference <span class="text-danger">*</span></label>
                                            <input type="text" name="reference" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Selection -->
                                <div class="row">
                                    <div class="col-lg-12 col-sm-6 col-12">
                                        <div class="mb-3">
                                            <label class="form-label">Product <span class="text-danger">*</span></label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" id="quotationBarcodeInput"
                                                    placeholder="Scan Item or Search Product">
                                                <div class="search-productsList d-none">
                                                    <ul id="quotationProductData">
                                                        @forelse ($products as $product)
                                                            <li>
                                                                <a class="add-quotation-product"
                                                                    data-id="{{ $product->id }}"
                                                                    data-name="{{ $product->product_name }}"
                                                                    data-quantity="1"
                                                                    data-price="{{ $product->selling_price ?? 0 }}"
                                                                    data-discount="{{ $product->discount_amount ?? 0 }}"
                                                                    data-unit="{{ $product->unit }}">
                                                                    {{ $product->product_name }}
                                                                    ({{ $product->selling_price }})
                                                                </a>
                                                            </li>
                                                        @empty
                                                            <li><a>No products found</a></li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Products Table -->
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table" id="quotationTable">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Qty</th>
                                                        <th>Purchase Price($)</th>
                                                        <th>Discount($)</th>
                                                        <th>Unit Cost($)</th>
                                                        <th>Total Cost($)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-end"><strong>Subtotal:</strong>
                                                        </td>
                                                        <td>

                                                            <input type="text" name="subtotal" class="form-control"
                                                                id="subtotal" readonly value="0.00">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Summary Fields -->
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Discount ($)</label>
                                            <input type="text" class="form-control" name="main_discount"
                                                value="0">
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Shipping ($)</label>
                                            <input type="text" class="form-control" name="shipping" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" required>
                                                <option value="">Select</option>
                                                <option value="Sent">Sent</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Inprogress">Inprogress</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            $(document).ready(function() {
                // Show search dropdown
                $('#quotationBarcodeInput').on('keyup', function() {
                    const query = $(this).val().toLowerCase();
                    if (query.length === 0) {
                        $('.search-productsList').addClass('d-none');
                        return;
                    }
                    $('.search-productsList').removeClass('d-none');
                    $('#quotationProductData li').each(function() {
                        const text = $(this).text().toLowerCase();
                        $(this).toggle(text.includes(query));
                    });
                });

                // Add product on enter
                $('#quotationBarcodeInput').on('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const code = $(this).val().trim();
                        if (code) {
                            addQuotationProduct(code);
                        }
                    }
                });

                // Click product from dropdown
                $(document).on('click', '.add-quotation-product', function() {
                    addQuotationProduct($(this).data('id'), $(this));
                    $('.search-productsList').addClass('d-none');
                });

                function addQuotationProduct(code, element = null) {
                    $('#quotationBarcodeInput').val('');
                    if (element) {
                        insertRow({
                            id: element.data('id'),
                            name: element.data('name'),
                            quantity: element.data('quantity'),
                            price: element.data('price'),
                            discount: element.data('discount'),
                        });
                    } else {
                        $.ajax({
                            url: '{{ route('quotation.addById') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                product_id: code
                            },
                            success: function(res) {
                                insertRow({
                                    id: res.id,
                                    name: res.name,
                                    quantity: 1,
                                    price: res.price,
                                    discount: res.discount || 0,
                                });
                            },
                            error: function() {
                                alert('Product not found');
                            }
                        });
                    }
                }

                function insertRow(product) {
                    const unitCost = product.price - (product.discount || 0);
                    const totalCost = unitCost * product.quantity;
                    const row = `<tr>
            <td>${product.name}<input type="hidden" name="product_id[]" value="${product.id}"></td>
            <td><input type="number" name="quantity[]" class="form-control" value="${product.quantity}" min="1"></td>
            <td><input type="number" name="purchase_price[]" class="form-control" value="${product.price}"></td>
            <td><input type="number" name="discount[]" class="form-control" value="${product.discount}"></td>
            <td><input type="text" name="unit_cost[]" class="form-control unit-cost" readonly value="${unitCost.toFixed(2)}"></td>
            <td><input type="text" name="total_cost[]" class="form-control total-cost" readonly value="${totalCost.toFixed(2)}"></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
        </tr>`;
                    $('#quotationTable tbody').append(row);
                    updateSubtotal();
                }

                $(document).on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    updateSubtotal();
                });

                $('#quotationTable').on('input', 'input', function() {
                    const $row = $(this).closest('tr');
                    const qty = parseFloat($row.find('[name="quantity[]"]').val()) || 0;
                    const price = parseFloat($row.find('[name="purchase_price[]"]').val()) || 0;
                    const discount = parseFloat($row.find('[name="discount[]"]').val()) || 0;
                    const unitCost = price - discount;
                    const totalCost = unitCost * qty;
                    $row.find('.unit-cost').val(unitCost.toFixed(2));
                    $row.find('.total-cost').val(totalCost.toFixed(2));
                    updateSubtotal();
                });

                function updateSubtotal() {
                    let subtotal = 0;
                    $('#quotationTable tbody tr').each(function() {
                        subtotal += parseFloat($(this).find('.total-cost').val()) || 0;
                    });

                    const mainDiscount = parseFloat($('[name="main_discount"]').val()) || 0;
                    const grandTotal = subtotal - mainDiscount;

                    // Update visible subtotal
                    $('#subtotal').val(grandTotal.toFixed(2));

                    // Update hidden total_amount input
                    $('#total_amount').val(grandTotal.toFixed(2));
                }




            });
        </script>

        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/moment.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
        <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    @endpush
</x-app-layout>
