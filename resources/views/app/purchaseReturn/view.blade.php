<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script> --}}


        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <!-- Summernote CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}">
        <!-- Bootstrap Tagsinput CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">

        <style>
            /* sds */
            .modal-body {
                max-height: 70vh;
                overflow-y: auto;
            }

            .modal:not(.show) {
                display: none !important;
            }

            .autocomplete-dropdown {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                z-index: 1051;
                background: #fff;
                border: 1px solid #ddd;
                max-height: 200px;
                overflow-y: auto;
            }

            .autocomplete-dropdown .dropdown-item {
                padding: 6px 12px;
                cursor: pointer;
            }

            .autocomplete-dropdown .dropdown-item:hover {
                background-color: #f0f0f0;
            }
        </style>
    @endpush

    @section('content')

        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4 class="fw-bold">Purchase Returns</h4>
                        <h6>Manage your purchase return</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a href="#" onclick="submitReturnExport('pdf')" data-bs-toggle="tooltip" title="PDF">
                            <img src="assets/img/icons/pdf.svg" alt="PDF">
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="submitReturnExport('excel')" data-bs-toggle="tooltip" title="Excel">
                            <img src="assets/img/icons/excel.svg" alt="Excel">
                        </a>
                    </li>

                    <li>
                        <a href="{{ url()->current() }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                class="ti ti-refresh"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-sales-new">
                        <i class="ti ti-circle-plus me-1"></i>Add Sales Return
                    </a>
                </div>
            </div>
            <!-- /product list -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>
                    {{-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Paid</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Unpaid</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Sort By : Last 7 Days
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Recently Added</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Last Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Last 7 Days</a>
                                </li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Product Name</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                    <th>Retrun Price</th>
                                    <th>Supplier Name</th>
                                    <th>Purchase Invoice ID</th>
                                    <th>Return Total Amount</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($PurchaseReturn as $return)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="purchase-return-checkbox"
                                                    value="{{ $return->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $return->product->product_name }} </td>
                                        <td>{{ $return->purchase_date }}</td>
                                        <td>{{ $return->qty }}</td>
                                        <td>{{ $return->purchase_price }}</td>
                                        <td>{{ $return->purchase->supplier->company_name }}</td>
                                        <td><span
                                                class="badges status-badge fs-10 p-1 px-2 rounded-1">{{ $return->purchase->purchase_code }}</span>
                                        </td>
                                        <td>Rs {{ $return->total }}</td>

                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                {{-- <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit-sales-new">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a> --}}
                                                <a class="p-2" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-id="{{ $return->id }}" href="javascript:void(0);">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>


        <!-- Add Purchase Modal -->
        <div class="modal fade" id="add-sales-new" tabindex="-1" aria-labelledby="addPurchaseLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Return</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form method="POST" action="{{ route('purchase_returns.store') }}" id="purchaseForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">


                                {{-- Date --}}
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="date" name="purchase_date" class="form-control" required>
                                    </div>
                                </div>


                                <div class="col-12" id="purchase-code-wrapper" style="position: relative;">
                                    <label class="form-label">Purchase Code <span class="text-danger">*</span></label>
                                    <input type="text" id="purchase_code" class="form-control"
                                        placeholder="Search Purchase Code">
                                    <input type="hidden" id="purchase_id">
                                    <div id="purchase-suggestions" class="autocomplete-dropdown border bg-white"
                                        style="position: absolute; top: 100%; left: 0; right: 0; z-index: 1000;"></div>
                                </div>

                                {{-- Purchase Items Table --}}
                                <div class="col-12">
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered">
                                            <thead class="table-light">
                                                <tr>

                                                    <th>Product</th>
                                                    <th>Code</th>
                                                    <th>Qty</th>
                                                    <th>Purchase Price</th>
                                                    <th>Weight</th>
                                                    <th>Unit Cost</th>
                                                    <th>Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="purchase-items-table-body">
                                                {{-- Rows will be added dynamically via JS --}}
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-end fw-bold">Sub Total</td>
                                                    <td colspan="2" id="subTotalDisplay">Rs 0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>


                                {{-- Notes --}}
                                <div class="col-md-12">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" rows="3" maxlength="600"
                                        placeholder="Enter any purchase notes..."></textarea>
                                    <small class="text-muted">Maximum 600 characters</small>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Return</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- /Add Purchase Modal -->

        <!-- Add Supplier -->
        <div class="modal fade" id="add_customer">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Supplier</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/purchase-returns.html">
                        <div class="modal-body">
                            <div>
                                <label class="form-label">Supplier<span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Add Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Supplier -->




        <!-- delete modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deletePurchaseForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <div class="page-wrapper-new p-0">
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                                    <i class="ti ti-trash fs-24 text-danger"></i>
                                </span>
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Purchase</h4>
                                <p class="mb-0 fs-16">Are you sure you want to delete purchase?</p>
                                <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-submit fs-13 fw-medium p-2 px-3">Yes
                                        Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




    @endsection



    @push('js')
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const BASE_URL = "{{ url('') }}";
                const $input = $('#purchase_code');
                const $hiddenId = $('#purchase_id');
                const $suggestions = $('#purchase-suggestions');
                const wrapper = document.getElementById('purchase-code-wrapper');

                let debounceTimer;

                $input.on('input', function() {
                    const query = this.value.trim();

                    clearTimeout(debounceTimer); // prevent multiple rapid AJAX calls
                    if (query.length < 2) {
                        $suggestions.empty();
                        return;
                    }

                    debounceTimer = setTimeout(() => {
                        $.ajax({
                            url: `{{ route('search.by.code') }}`,
                            data: {
                                q: query
                            },
                            dataType: 'json',
                            success: function(data) {
                                $suggestions.empty();

                                if (!data.length) {
                                    $suggestions.append(
                                        $('<div>', {
                                            class: 'dropdown-item text-muted',
                                            text: 'No results found'
                                        })
                                    );
                                    return;
                                }

                                data.forEach(purchase => {
                                    $('<div>', {
                                        class: 'dropdown-item',
                                        text: purchase.purchase_code,
                                        css: {
                                            cursor: 'pointer'
                                        },
                                        mousedown: function() {
                                            $input.val(purchase
                                                .purchase_code);
                                            $hiddenId.val(purchase.id);
                                            $suggestions.empty();
                                            loadPurchaseDetails(purchase
                                                .id);
                                        }
                                    }).appendTo($suggestions);
                                });
                            },
                            error: function() {
                                $suggestions.html(
                                    '<div class="dropdown-item text-danger">Error fetching data</div>'
                                );
                            }
                        });
                    }, 300); // 300ms debounce
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!wrapper.contains(e.target)) {
                        $suggestions.empty();
                    }
                });
            });


            function loadPurchaseDetails(purchaseId) {
                $.ajax({
                    url: `{{ route('purchase.details') }}`, // Removed the ID from the URL
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        purchase_id: purchaseId
                    }, // Send ID in POST body
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Important for Laravel
                    },
                    success: function(response) {
                        const $tableBody = $('#purchase-items-table-body');
                        $tableBody.empty(); // Clear previous data

                        let total = 0;

                        $.each(response.purchase_items, function(index, item) {

                            const product = item.product;
                            const productName = product.product_name || 'Unknown Product';
                            const rowTotal = (item.unit_cost * item.qty);
                            total += rowTotal;

                            const $row = $(`
                            <tr>

                                <td>
                                    ${productName}
                                    <input type="hidden" name="items[${index}][product_id]" value="${product.id}">
                                    <input type="hidden" name="purcheseID" value="${response.id}">
                                </td>
                                <td>
                                    <input type="text" name="items[${index}][item_code]" class="form-control qty" value="${item.item_code}">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][qty]" class="form-control qty" value="${item.qty}">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][purchase_price]" class="form-control purchase_price" value="${item.purchase_price}">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][weight]" class="form-control discount" value="${item.weight}">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][unit_cost]" class="form-control unit_cost" value="${item.unit_cost}" readonly>
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][line_total]" class="form-control line_total" value="${rowTotal.toFixed(2)}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary remove-product">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </button>
                                </td>
                            </tr>
                            `);

                            $tableBody.append($row);

                            // When qty, price, or discount changes — update line total & sub total
                            $row.find('.qty, .purchase_price').on('input', function() {
                                const qty = parseFloat($row.find('.qty').val()) || 0;
                                const price = parseFloat($row.find('.purchase_price').val()) || 0;

                                const newLineTotal = (qty * price);
                                $row.find('.line_total').val(newLineTotal.toFixed(2));
                                updateSubTotal();
                            });

                            // Remove row
                            $row.find('.remove-product').on('click', function() {
                                $(this).closest('tr').remove();
                                updateSubTotal();
                            });

                        });

                        $('#subTotalDisplay').text(`Rs ${total.toFixed(2)}`);
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching purchase details');
                        console.error(error);
                    }
                });
            }

            function updateSubTotal() {
                let newTotal = 0;
                $('#purchase-items-table-body tr').each(function() {
                    const lineTotal = parseFloat($(this).find('.line_total').val()) || 0;
                    newTotal += lineTotal;
                });
                $('#subTotalDisplay').text(`Rs ${newTotal.toFixed(2)}`);
            }
        </script>


        <script>
            document.getElementById('select-all').addEventListener('change', function() {
                document.querySelectorAll('.purchase-return-checkbox').forEach(cb => {
                    cb.checked = this.checked;
                });
            });

            function submitReturnExport(format) {
                let selected = [];
                document.querySelectorAll('.purchase-return-checkbox:checked').forEach(cb => {
                    selected.push(cb.value);
                });

                if (selected.length === 0) {
                    alert('Please select at least one return item to export.');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('purchase-return.export') }}";

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = "{{ csrf_token() }}";
                form.appendChild(token);

                const formatInput = document.createElement('input');
                formatInput.type = 'hidden';
                formatInput.name = 'format';
                formatInput.value = format;
                form.appendChild(formatInput);

                const idsInput = document.createElement('input');
                idsInput.type = 'hidden';
                idsInput.name = 'selected_ids';
                idsInput.value = selected.join(',');
                form.appendChild(idsInput);

                document.body.appendChild(form);
                form.submit();
            }
        </script>

        {{-- Delete Function --}}

        <script>
            $(document).on('click', '[data-bs-target="#delete-modal"]', function() {
                let purchaseId = $(this).data('id');
                let form = $('#deletePurchaseForm');
                let actionUrl = "{{ route('purchaseReturn.destroy', '__ID__') }}".replace('__ID__', purchaseId);
                form.attr('action', actionUrl);
            });
        </script>




        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    @endpush
</x-app-layout>
