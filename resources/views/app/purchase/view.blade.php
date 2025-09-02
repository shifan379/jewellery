<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
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
                background: #fff;
                border: 1px solid #ccc;
                max-height: 200px;
                overflow-y: auto;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .autocomplete-dropdown .dropdown-item {
                padding: 8px 12px;
                border-bottom: 1px solid #eee;
            }

            .autocomplete-dropdown .dropdown-item:last-child {
                border-bottom: none;
            }

            .autocomplete-dropdown .dropdown-item:hover {
                background-color: #f8f9fa;
            }
        </style>
    @endpush

    @section('content')

        <div class="content">
            <div class="page-header transfer">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4 class="fw-bold">Purchase</h4>
                        <h6>Manage your purchases</h6>
                    </div>
                </div>
                {{-- <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                src="assets/img/icons/pdf.svg" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                src="assets/img/icons/excel.svg" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i data-feather="rotate-ccw"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul> --}}
                {{-- <form id="purchaseExportForm" method="POST"  >
                    @csrf
                    <ul class="table-top-head">
                        <li>
                            <a href="#" id="export-purchase-pdf" title="Pdf">
                                <img src="assets/img/icons/pdf.svg" alt="PDF">
                            </a>
                        </li>
                        <li>
                            <a href="#" id="export-purchase-excel" title="Excel">
                                <img src="assets/img/icons/excel.svg" alt="Excel">
                            </a>
                        </li>
                </form>
                        <li>
                            <a href="{{ url()->current() }}" title="Refresh">
                                <i class="ti ti-refresh"></i>
                            </a>
                        </li>

                        <li>
                            <a title="Collapse" id="collapse-header">
                                <i class="ti ti-chevron-up"></i>
                            </a>
                        </li>
                    </ul> --}}

                <form id="purchaseExportForm" method="POST">
                    @csrf
                    <ul class="table-top-head">
                        <li>
                            <a href="#" id="export-purchase-pdf" title="Pdf">
                                <img src="assets/img/icons/pdf.svg" alt="PDF">
                            </a>
                        </li>
                        {{-- <li>
                            <a href="#" id="export-purchase-excel" title="Excel">
                                <img src="assets/img/icons/excel.svg" alt="Excel">
                            </a>
                        </li> --}}
                    </ul>
                </form>

                <ul class="table-top-head">
                    <li>
                        <a href="{{ url()->current() }}" title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li>
                        <a title="Collapse" id="collapse-header">
                            <i class="ti ti-chevron-up"></i>
                        </a>
                    </li>
                </ul>



                <div class="d-flex purchase-pg-btn">
                    <div class="page-btn">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-purchase"><i
                                data-feather="plus-circle" class="me-1"></i>Add Purchase</a>
                    </div>
                    <div class="page-btn import">
                        <a href="#" class="btn btn-secondary color" data-bs-toggle="modal"
                            data-bs-target="#view-notes"><i data-feather="download" class="me-2"></i>Import Purchase</a>
                    </div>
                </div>

            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>
                    <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <form method="GET" action="{{ route('purchase') }}">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    {{ $status ?? 'Status' }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <button class="dropdown-item rounded-1" type="submit" name="status"
                                            value="Received">Received</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item rounded-1" type="submit" name="status"
                                            value="Pending">Pending</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item rounded-1" type="submit" name="status"
                                            value="">All</button>
                                    </li>
                                </ul>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th class="no-sort">
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>Purchase Code</th>
                                    <th>Supplier Name</th>
                                    <th>Reference</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Quantity</th>
                                    {{-- <th>Due</th> --}}
                                    {{-- <th>Payment Status</th> --}}
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $purchase)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                {{-- <input type="checkbox"> --}}
                                                <input type="checkbox" class="purchase-checkbox"
                                                    value="{{ $purchase->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $purchase->purchase_code ?? 'N/A' }}</td>
                                        <td>{{ $purchase->supplier->company_name ?? 'N/A' }}</td>
                                        <td>{{ $purchase->reference }}</td>
                                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badges status-badge fs-10 p-1 px-2 rounded-1 {{ $purchase->status === 'Pending' ? 'badge-pending' : '' }}">
                                                {{ $purchase->status }}
                                            </span>
                                        </td>
                                        <td>Rs. {{ number_format($purchase->total) }}</td>
                                        {{-- @forelse ($purchase->items as $item)
                                            <td>
                                                {{ $item->qty }}
                                            </td>
                                        @empty
                                            <td>
                                                0
                                            </td>
                                        @endforelse --}}
                                        <td>
                                            {{ $purchaseQtySum[$purchase->id] ?? 0 }}
                                        </td>


                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a class="me-2 p-2" data-bs-toggle="modal" data-bs-target="#view-purchase"
                                                    data-id="{{ $purchase->id }}"
                                                    data-supplier-name="{{ $purchase->supplier->company_name }}"
                                                    data-date="{{ $purchase->purchase_date }}"
                                                    data-reference="{{ $purchase->reference }}"
                                                    data-shipping="{{ $purchase->shipping }}"
                                                    data-status="{{ $purchase->status }}"
                                                    data-notes="{{ $purchase->notes }}"
                                                    data-purchase_code="{{ $purchase->purchase_code }}">


                                                    <i data-feather="eye" class="action-eye"></i>
                                                </a>

                                                <a class="me-2 p-2" data-bs-toggle="modal"
                                                    data-bs-target="#edit-purchase" data-id="{{ $purchase->id }}"
                                                    data-supplier="{{ $purchase->supplier_id }}"
                                                    data-date="{{ $purchase->purchase_date }}"
                                                    data-reference="{{ $purchase->reference }}"
                                                    data-status="{{ $purchase->status }}"
                                                    data-notes="{{ $purchase->notes }}"
                                                    data-purchase_code="{{ $purchase->purchase_code }}"
                                                    data-category="{{ $purchase->categoryID }}"
                                                    {{-- data-tax="{{ $purchase->order_tax }}" --}} {{-- data-discount="{{ $purchase->discount }}" --}}
                                                    data-shipping="{{ $purchase->shipping }}">

                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="p-2" data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-id="{{ $purchase->id }}" href="javascript:void(0);">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
            <!-- /product list -->
        </div>

        <!-- View Purchase -->
        <div class="modal fade" id="view-purchase" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Purchase</h4>

                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                        <div class="row g-3">
                            {{-- Purchase Code --}}
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Purchase Code</label>
                                <input type="text" readonly class="form-control purchase_code text-bg-light"
                                    name="view_purchase_code">
                            </div>

                            {{-- Supplier --}}
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Supplier Name</label>
                                <input type="text" class="form-control" name="view_supplier" readonly>
                            </div>

                            {{-- Date --}}
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control" name="view_date" readonly>
                            </div>

                            {{-- Reference --}}
                            <div class="col-lg-4 col-md-12">
                                <label class="form-label">Reference</label>
                                <input type="text" class="form-control" name="view_reference" readonly>
                            </div>

                            {{-- Product Table --}}
                            <div class="col-12">
                                <label class="form-label">Products</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Product Name</th>
                                                <th>QTY</th>
                                                <th>Purchase Price </th>
                                                <th>Weight(g)</th>
                                                <th>Total Cost </th>
                                            </tr>
                                        </thead>
                                        <tbody id="viewPurchaseItems">
                                            <!-- filled by JS -->
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5" class="text-end">Sub Total:</th>
                                                <th id="view-subtotal">Rs 0.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            {{-- Shipping --}}
                            <div class="col-md-4">
                                <label class="form-label">Shipping</label>
                                <input type="text" class="form-control" name="view_shipping" readonly>
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" name="view_status" readonly>
                            </div>

                            {{-- Notes --}}
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="view_notes" rows="3" readonly></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- /View Purchase --}}

        <!-- Add Purchase -->
        <div class="modal fade" id="add-purchase">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Purchase</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('purchases.store') }}" id="purchaseForm">
                        @csrf
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label">Supplier Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" name="supplier_id" required>
                                            <option value="">Select</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                            <div class="add-icon tab">
                                                <a href="{{ route('suppliers.create') }}"
                                                    class="btn btn-outline-primary">
                                                    <i data-feather="plus-circle" class="feather-plus-circles"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label">Categorys Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" required name="categoryID">
                                            <option value="">Select</option>
                                            @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="date" name="purchase_date" class="form-control" required>
                                        <input type="hidden" name="purchase_code" class="form-control" required>
                                        <input type="hidden" id="purchase_id">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-12">
                                    <label class="form-label">Reference</label>
                                    <input type="text" name="reference" class="form-control">
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-label">Product<span class="text-danger">*</span></label>
                                        <div class="position-relative" id="product-input-wrapper" style="z-index: 1060;">
                                            <input type="text" id="product-input" name="product_name"
                                                class="form-control addNamewithClik" placeholder="Search Product">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <label class="form-label">Add Row</label>
                                        <div class="add-icon tab">
                                            <a href="#" class="btn btn-outline-primary addRow">
                                                <i data-feather="plus-circle" class="feather-plus-circles"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="modal-body-table mt-3">
                                        <div class="table-responsive">
                                            <table class="table  rounded-1">
                                                <thead>
                                                    <tr>
                                                        <th class="bg-secondary-transparent p-3">Product</th>
                                                        <th class="bg-secondary-transparent p-3">Code</th>
                                                        <th class="bg-secondary-transparent p-3">Qty</th>
                                                        <th class="bg-secondary-transparent p-3">Purchase Price</th>
                                                        <th class="bg-secondary-transparent p-3">Weight(g)</th>
                                                        <th class="bg-secondary-transparent p-3">Total Cost</th>
                                                        <th class="bg-secondary-transparent p-3">Print</th>
                                                        <th class="bg-secondary-transparent p-3 no-sort">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchase-items-table-body">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="6" class="text-end">Sub Total:</th>
                                                        <th id="sub">Rs. 0.00</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Shipping<span class="text-danger">*</span></label>
                                    <input type="number" name="shipping" class="form-control" value="0"
                                        step="any">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status<span class="text-danger">*</span></label>
                                    <select class="form-select" name="status" required>
                                        <option value="">Select</option>
                                        <option value="Received">Received</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes" rows="3" maxlength="600"></textarea>
                                    <small class="text-muted">Maximum 60 words</small>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Purchase -->

        <!-- Edit Purchase -->
        <div class="modal fade" id="edit-purchase" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Purchase </h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editPurchaseForm" method="POST"
                        action="{{ route('purchases.update', ['purchase' => '__ID__']) }}">
                        @csrf
                        @method('PUT')

                        <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                            <div class="row g-3">

                                {{-- Purchase Code --}}
                                <div class="col-lg-3 col-md-6">

                                    <label class="form-label">Purchase Code <span class="text-danger">*</span></label>
                                    <input type="text" readonly name="purchase_code"
                                        class="form-control purchase_code text-bg-light">
                                </div>
                                {{-- Supplier --}}
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" name="supplier_id">
                                            <option value="">Select</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->company_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#add_customer" type="button">
                                            <i data-feather="plus-circle"></i>
                                        </button>
                                    </div>
                                </div>


                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="date" name="purchase_date" class="form-control" required>
                                    </div>
                                </div>


                                {{-- Reference --}}
                                <div class="col-lg-3 col-md-12">
                                    <label class="form-label">Reference </label>
                                    <input type="text" name="reference" class="form-control">
                                </div>




                                {{-- Dynamic Product Table --}}
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Code</th>
                                                    <th>QTY</th>
                                                    <th>Purchase Price </th>
                                                    <th>Weight(g) </th>
                                                    <th>Total Cost </th>
                                                    <th>Print</th>
                                                    <th class="no-sort">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="editPurchaseItems">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="6" class="text-end">Sub Total:</th>
                                                    <th id="sub-totals">Rs. 0.00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                {{-- Shipping --}}
                                <div class="col-md-4">
                                    <label class="form-label">Shipping</label>
                                    <input type="text" name="shipping" class="form-control" value="0">
                                </div>

                                {{-- Status --}}
                                <div class="col-12">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select">
                                        <option value="">Select</option>
                                        <option value="Received">Received</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>

                                {{-- Description / Notes --}}
                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" class="form-control" rows="3" maxlength="600"></textarea>
                                    <small class="text-muted">Maximum 60 words</small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>

        <!-- /Edit Purchase -->


        {{-- Import Purchase --}}
        <div class="modal fade" id="view-notes" tabindex="-1" aria-labelledby="viewNotesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewNotesLabel">Import Purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body" style="max-height: 60vh; overflow-y: auto;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="supplierSelect" class="form-label">Supplier Name <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select id="supplierSelect" class="form-select" required>
                                            <option value="">Select</option>
                                            <option>Apex Computers</option>
                                            <option>Dazzle Shoes</option>
                                            <option>Best Accessories</option>
                                        </select>
                                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                            data-bs-target="#add_customer">
                                            <i data-feather="plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="statusSelect" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select id="statusSelect" class="form-select" required>
                                        <option value="">Select</option>
                                        <option>Received</option>
                                        <option>Ordered</option>
                                        <option>Pending</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <a href="javascript:void(0)" class="btn btn-primary mb-3">Download Sample File</a>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3 image-upload-down">
                                        <label class="form-label"> Upload CSV File</label>
                                        <div class="image-upload download">
                                            <input type="file">
                                            <div class="image-uploads">
                                                <img src="assets/img/download-img.png" alt="img">
                                                <h4>Drag and drop a <span>file to upload</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Order Tax <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Discount <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Shipping <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required />
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" class="form-control" rows="3" maxlength="60" placeholder="Maximum 60 characters"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Import Purchase -->


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
        <script>
            const searchUrl = "{{ route('products.search') }}";
            const nextItemCode = "{{ route('products.nextItemCode') }}";
            const csrfToken = '{{ csrf_token() }}';
        </script>
        {{-- Add function --}}
        <script>
            $(document).on('focus', '.canRemove', function() {
                // clear only if not readonly
                if (!$(this).prop('readonly')) {
                    $(this).val('');
                }
            });

            document.addEventListener('DOMContentLoaded', function() {
                let productInput = document.getElementById('product-input');
                let inputWrapper = document.getElementById('product-input-wrapper');
                let tableBody = document.getElementById('purchase-items-table-body');

                // dropdown element
                let dropdown = document.createElement('div');
                dropdown.classList.add('autocomplete-dropdown');
                Object.assign(dropdown.style, {
                    position: 'absolute',
                    top: '100%',
                    left: '0',
                    right: '0',
                    zIndex: '1060'
                });
                inputWrapper.appendChild(dropdown);

                // === PRODUCT SEARCH AUTOCOMPLETE ===
                productInput.addEventListener('input', function() {
                    let query = this.value.trim();
                    if (query.length < 2) {
                        dropdown.innerHTML = '';
                        return;
                    }
                    $.getJSON(searchUrl + "?q=" + query, function(products) {
                        dropdown.innerHTML = '';
                        if (!products.length) {
                            dropdown.innerHTML = '<div class="dropdown-item">No results</div>';
                            return;
                        }
                        $.each(products, function(index, product) {
                            let item = $('<div>')
                                .addClass('dropdown-item')
                                .attr('data-mark', product.prefix)
                                .css('cursor', 'pointer')
                                .text(product.product_name)
                                .on('click', function() {
                                    handleProductClick(product);
                                });
                            $(dropdown).append(item);
                        });
                    }).fail(function() {
                        dropdown.innerHTML =
                            '<div class="dropdown-item text-danger">Error fetching products</div>';
                    });
                });

                // hide dropdown on outside click
                document.addEventListener('click', function(e) {
                    if (!productInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.innerHTML = '';
                    }
                });

                // =====================
                let currentCode = null;
                let currentPrefix = null;
                let selectedProduct = null;

                function handleProductClick(product) {
                    dropdown.innerHTML = ''; // hide dropdown
                    $('.addNamewithClik').val(product.product_name);

                    selectedProduct = product;
                    currentPrefix = product.prefix;
                    currentCode = null; // reset codes for each product
                }

                function getNextCode(callback) {
                    $.ajax({
                        url: nextItemCode,
                        type: 'POST',
                        data: {
                            val: currentPrefix,
                            _token: csrfToken
                        },
                        success: function(data) {
                            callback(data.code);
                        },
                        error: function() {
                            toastr.error('Error getting next code.');
                        }
                    });
                }

                // Add Row button click
                $(document).on('click', '.addRow', function() {
                    if (!selectedProduct) {
                        toastr.warning('Select a product first.');
                        return;
                    }

                    if (currentCode === null) {
                        getNextCode(function(startCode) {
                            currentCode = parseInt(startCode);
                            addProductRow(selectedProduct, currentCode, currentPrefix);
                            currentCode++;
                        });
                    } else {
                        addProductRow(selectedProduct, currentCode, currentPrefix);
                        currentCode++;
                    }
                });

                function addProductRow(product, code, prefix) {
                    let rowIndex = tableBody.querySelectorAll('tr').length;

                    let row = document.createElement('tr');
                    row.innerHTML = `
                            <td>${product.product_name} (${prefix})
                                <input type="hidden" name="items[${rowIndex}][product_id]" value="${product.id}">
                                <input type="hidden" name="items[${rowIndex}][item_code]" value="${code}">
                                <input type="hidden" name="items[${rowIndex}][prefix]" value="${prefix}">
                                <input type="hidden" name="items[${rowIndex}][product_name]" value="${product.product_name}">

                            </td>
                            <td><input type="text" name="items[${rowIndex}][mark]" class="form-control mark" readonly value="${prefix + String(code).padStart(4, '0')}"></td>
                            <td><input type="number" name="items[${rowIndex}][qty]" class="form-control qty canRemove" value="1" min="1"></td>
                            <td><input type="number" name="items[${rowIndex}][purchase_price]" class="form-control price canRemove" value="0" step="any"></td>
                            <td><input type="number" name="items[${rowIndex}][weight]" class="form-control canRemove" step="any"></td>
                            <td><input type="number" name="items[${rowIndex}][line-total]" class="form-control line-total" readonly value="0"></td>
                            <td>
                                <button type="button" class="btn btn-primary print-lable">
                                    <i data-feather="printer"></i>
                                </button>

                            </td>
                            <td><button type="button" class="btn btn-primary remove-product">
                                <i data-feather="trash-2"></i>
                                </button>
                            </td>
                        `;

                    tableBody.appendChild(row);

                    const qtyInput = row.querySelector('.qty');
                    const priceInput = row.querySelector('.price');
                    const lineTotalField = row.querySelector('.line-total');

                    function calculateRow() {
                        const qty = parseFloat(qtyInput.value) || 0;
                        const price = parseFloat(priceInput.value) || 0;
                        const lineTotal = price * qty;
                        lineTotalField.value = lineTotal.toFixed(2);
                        updateSub();
                    }

                    [qtyInput, priceInput].forEach(input => {
                        input.addEventListener('input', calculateRow);
                    });

                    calculateRow();

                    feather.replace(); // refresh icons for new row
                }

                // remove row (event delegation)
                tableBody.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-product')) {
                        const row = e.target.closest('tr');
                        if (row) {
                            row.remove();
                            updateSub();
                            updateRowIndexes();
                        }
                    }
                });

                function updateRowIndexes() {
                    tableBody.querySelectorAll('tr').forEach((row, index) => {
                        row.querySelectorAll('input').forEach(input => {
                            input.name = input.name.replace(/items\[\d+\]/, `items[${index}]`);
                        });
                    });
                }
            });

            // update subtotal
            function updateSub() {
                let sub = 0;
                document.querySelectorAll('.line-total').forEach(input => {
                    sub += parseFloat(input.value) || 0;
                });
                document.getElementById('sub').textContent = `Rs. ${sub.toFixed(2)}`;
            }
        </script>

          <script>
            $(document).ready(function() {
                $(document).on('click', '.print-lable', function() {
                    var row = $(this).closest('tr');
                    var itemCode    = row.find('input[name*="[mark]"]').val();
                    var productName   = row.find('input[name*="[product_name]"]').val();
                    var weight      = row.find('input[name*="[weight]"]').val();


                    var url = '{{ route('barcode.print') }}'; // Laravel POST route

                    // Create form dynamically
                    var form = $('<form>', {
                        action: url,
                        method: 'POST',
                        target: '_blank'
                    }).append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: $('meta[name="csrf-token"]').attr('content')
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'item_code',
                        value: itemCode
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'product_name',
                        value: productName
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'weight',
                        value: weight
                    }));

                    form.appendTo('body').submit().remove();
                });
            });
        </script>


        {{-- Edit function --}}
        <script>
            $(document).on('click', '[data-bs-target="#edit-purchase"]', function() {
                let $this = $(this);
                let id = $this.data('id');
                let form = $('#editPurchaseForm');

                let action = form.attr('action').replace('__ID__', id);
                form.attr('action', action);

                form.find('select[name="supplier_id"]').val($this.data('supplier'));
                form.find('input[name="purchase_date"]').val($this.data('date'));
                form.find('input[name="reference"]').val($this.data('reference'));
                form.find('select[name="status"]').val($this.data('status'));
                form.find('textarea[name="notes"]').val($this.data('notes'));
                form.find('input[name="shipping"]').val($this.data('shipping'));
                form.find('input[name="purchase_code"]').val($this.data('purchase_code'));

                loadPurchaseItems(id);
            });

            // Product search setup
            document.addEventListener('DOMContentLoaded', function() {
                const BASE_URL = "{{ url('') }}";
                let productInput = document.getElementById('edit-product-input');
                let inputWrapper = document.getElementById('edit-product-input-wrapper');
                let tableBody = document.getElementById('editPurchaseItems');

                let dropdown = document.createElement('div');
                dropdown.classList.add('autocomplete-dropdown');
                dropdown.style.position = 'absolute';
                dropdown.style.top = '100%';
                dropdown.style.left = '0';
                dropdown.style.right = '0';
                dropdown.style.zIndex = '1060';
                inputWrapper.appendChild(dropdown);

                productInput.addEventListener('input', function() {
                    let query = this.value.trim();
                    if (query.length < 2) {
                        dropdown.innerHTML = '';
                        return;
                    }

                   $.getJSON(searchUrl + "?q=" + query, function(products) {
                        dropdown.innerHTML = '';
                        if (!products.length) {
                            dropdown.innerHTML = '<div class="dropdown-item">No results</div>';
                            return;
                        }
                        $.each(products, function(index, product) {
                            let item = $('<div>')
                                .addClass('dropdown-item')
                                .attr('data-mark', product.prefix)
                                .css('cursor', 'pointer')
                                .text(product.product_name)
                                .on('click', function() {
                                    handleEditProductClick(product);
                                });
                            $(dropdown).append(item);
                        });
                    }).fail(function() {
                        dropdown.innerHTML =
                            '<div class="dropdown-item text-danger">Error fetching products</div>';
                    });
                });

                document.addEventListener('click', function(e) {
                    if (!productInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.innerHTML = '';
                    }
                });
            });


            function loadPurchaseItems(purchaseId) {
                $.ajax({
                    url: "{{ route('purchases.edit', ':id') }}".replace(':id', purchaseId),
                    method: 'GET',
                    success: function(items) {
                        const tbody = $('#editPurchaseItems');
                        tbody.empty();

                        if (!items || items.length === 0) {
                            tbody.html(
                                `<tr><td colspan="6" class="text-center">No items found for this purchase.</td></tr>`
                            );
                            return;
                        }

                        let rowsHtml = '';
                        items.forEach((item, index) => {
                            const productName = item.product?.product_name || 'Unnamed Product';
                            const editPrefix = item.product?.prefix || 'Unnamed Product';
                            const editMark = item.product?.mark || 'Unnamed Product';
                            rowsHtml += `
                            <tr>
                                <td>${productName} (${editPrefix})
                                    <input type="hidden" name="item_id[${index}]" value="${item.id}">
                                    <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                                    <input type="hidden" name="items[${index}][item_code]" value="${item.item_code}">
                                    <input type="hidden" name="items[${index}][prefix]" value="${editPrefix}">
                                    <input type="hidden" name="items[${index}][product_name]" value="${productName}">
                                </td>
                                <td>
                                    <input type="text" name="items[${index}][mark]" class="form-control mark" readonly value="${editMark}">
                                </td>
                                <td>
                                    <input type="number" step="any" name="items[${index}][qty]" value="${item.qty}" class="form-control  form-control-sm qty-input">
                                </td>
                                <td>
                                    <input type="number" step="any" name="items[${index}][purchase_price]" value="${item.purchase_price}" class="form-control  form-control-sm price-input">
                                </td>
                                <td><input type="number" name="items[${index}][weight]" class="form-control weight" value="${item.weight}" step="any"></td>
                                <td>
                                    <input type="text" name="items[${index}][total]" class="form-control form-control-sm line-total" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary print-lable">
                                        <i data-feather="printer"></i>
                                    </button>

                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary remove-product"> <i data-feather="trash-2" class="feather-trash-2"></i></button>
                                </td>
                            </tr>
                            `;
                        });

                        tbody.html(rowsHtml);

                        if (window.feather) {
                            feather.replace();
                        }
                        attachEditCalculations();
                    },
                    error: function(xhr) {
                        console.error("Error fetching items:", xhr);
                        alert('Failed to load purchase items.');
                    }
                });
            }


            function attachEditCalculations() {
                const rows = document.querySelectorAll('#editPurchaseItems tr');

                rows.forEach(row => {

                    const qtyInput = row.querySelector('.qty-input');
                    const priceInput = row.querySelector('.price-input');
                    const lineTotalField = row.querySelector('.line-total');

                    function calculateRow() {
                        const qty = parseFloat(qtyInput.value) || 0;
                        const price = parseFloat(priceInput.value) || 0;


                        const unitCost = price;
                        const lineTotal = unitCost * qty;

                        lineTotalField.value = lineTotal.toFixed(2);
                        updateSubTotal();
                    }
                    [qtyInput, priceInput].forEach(input => {
                        input.addEventListener('input', calculateRow);
                    });

                    calculateRow();
                });

                updateSubTotal();
            }

            function updateSubTotal() {
                let subTotal = 0;
                const lineTotals = document.querySelectorAll('.line-total');

                lineTotals.forEach(input => {
                    const lineAmount = parseFloat(input.value) || 0;
                    subTotal += lineAmount;
                });

                document.getElementById('sub-totals').textContent = `Rs. ${subTotal.toFixed(2)}`;
            }

            // Delegated event so it works for dynamically added rows
            $(document).on('click', '#editPurchaseItems .remove-product', function() {
                const $row = $(this).closest('tr');
                $row.remove();
                updateSubTotal();
                updateRowIndexes();
            });

            // Optional: reindex input names after a row is removed to keep indexes continuous
            function updateRowIndexes() {
                $('#editPurchaseItems tr').each(function(index) {
                    $(this).find('input, select, textarea').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[\d+\]/, `[${index}]`);
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
        </script>

        {{-- Delete Function --}}

        <script>
            $(document).on('click', '[data-bs-target="#delete-modal"]', function() {
                let purchaseId = $(this).data('id');
                let form = $('#deletePurchaseForm');
                let actionUrl = "{{ route('purchases.destroy', '__ID__') }}".replace('__ID__', purchaseId);
                form.attr('action', actionUrl);
            });
        </script>

        {{-- View Purchase --}}

        <script>
            $(document).on('click', '[data-bs-target="#view-purchase"]', function() {
                let $this = $(this);
                let id = $this.data('id');
                // Fill basic info from data- attributes (optional, or use AJAX)
                $('input[name="view_supplier"]').val($this.data('supplier-name'));
                $('input[name="view_date"]').val($this.data('date'));
                $('input[name="view_reference"]').val($this.data('reference'));
                $('input[name="view_shipping"]').val($this.data('shipping'));
                $('input[name="view_status"]').val($this.data('status'));
                $('textarea[name="view_notes"]').val($this.data('notes'));
                $('input[name="view_purchase_code"]').val($this.data('purchase_code'));

                // Load purchase items from AJAX
                $.ajax({
                    url: "{{ route('purchases.edit', ':id') }}".replace(':id', id),
                    method: 'GET',
                    success: function(items) {
                        const tbody = $('#viewPurchaseItems');
                        tbody.empty();

                        let subTotal = 0;

                        if (items.length === 0) {
                            tbody.append(
                                `<tr><td colspan="6" class="text-center">No items found.</td></tr>`);
                        }

                        items.forEach(item => {
                            const productName = item.product?.product_name || 'Unnamed Product';
                            const unitCost = item.purchase_price ;
                            const lineTotal = unitCost * item.qty;
                            subTotal += lineTotal;

                            tbody.append(`
                        <tr>
                            <td>${item.item_code}</td>
                            <td>${productName}</td>
                            <td>${item.qty}</td>
                            <td>${parseFloat(item.purchase_price).toFixed(2)}</td>
                            <td>${item.weight}</td>

                            <td>Rs. ${lineTotal.toFixed(2)}</td>
                        </tr>
                    `);
                        });

                        $('#view-subtotal').text(`Rs. ${subTotal.toFixed(2)}`);
                    },
                    error: function(xhr) {
                        alert('Failed to load purchase items.');
                    }
                });
            });
        </script>

        {{-- /view_purchase --}}

        {{-- <script>
            function submitPurchaseExport(type) {
                let selectedIds = [];
                document.querySelectorAll('.purchase-checkbox:checked').forEach(cb => selectedIds.push(cb.value));

                if (selectedIds.length === 0) {
                    alert("Please select at least one purchase to export.");
                    return;
                }

                const form = document.getElementById('purchaseExportForm');
                form.innerHTML = ''; // Clear previous

                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                form.appendChild(csrfInput);

                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                form.action = (type === 'pdf') ?
                    "{{ route('purchases.download.pdf') }}" :
                    "{{ route('purchases.download.excel') }}";

                form.submit();
            }

            document.getElementById('export-purchase-pdf').addEventListener('click', function(e) {
                e.preventDefault();
                submitPurchaseExport('pdf');
            });

            document.getElementById('export-purchase-excel').addEventListener('click', function(e) {
                e.preventDefault();
                submitPurchaseExport('excel');
            });
        </script> --}}

        <script>
            function submitPurchaseExport(type) {
                let selectedIds = [];
                document.querySelectorAll('.purchase-checkbox:checked').forEach(cb => selectedIds.push(cb.value));

                // if (selectedIds.length === 0) {
                //     alert("Please select at least one purchase to export.");
                //     return;
                // }

                const form = document.getElementById('purchaseExportForm');
                form.innerHTML = ''; // Clear previous inputs

                // CSRF token for POST request
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}'; // Laravel blade syntax
                form.appendChild(csrfInput);

                // Add selected purchase IDs as hidden inputs
                selectedIds.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    form.appendChild(input);
                });

                // Set form action based on export type
                form.action = (type === 'pdf') ?
                    "{{ route('purchases.download.pdf') }}" :
                    "{{ route('purchases.download.excel') }}";

                form.method = 'POST'; // Make sure to use POST for sending arrays

                form.submit();
            }

            document.getElementById('export-purchase-pdf').addEventListener('click', function(e) {
                e.preventDefault();
                submitPurchaseExport('pdf');
            });

            document.getElementById('export-purchase-excel').addEventListener('click', function(e) {
                e.preventDefault();
                submitPurchaseExport('excel');
            });
        </script>

        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    @endpush
</x-app-layout>
