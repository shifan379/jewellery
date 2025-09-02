<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        <style>
            /* sds */
        </style>
    @endpush

    @section('content')


        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Stock Adjustment</h4>
                        <h6>Manage your stock adjustment</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <form id="exportForm" method="POST" action="{{ route('stock.export') }}">
                        @csrf
                        <input type="hidden" name="format" id="exportFormat" value="">
                        <input type="hidden" name="selected_ids" id="selectedIds" value="">
                    </form>

                    <li>
                        <a href="#" onclick="event.preventDefault(); exportData('pdf')" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Pdf">
                            <img src="assets/img/icons/pdf.svg" alt="img">
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); exportData('excel')" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Excel">
                            <img src="assets/img/icons/excel.svg" alt="img">
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('stock.adjustment') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                {{-- <div class="page-btn">
							<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-stock-adjustment"><i class="ti ti-circle-plus me-1"></i>Add Adjustment</a>
						</div> --}}
            </div>

              <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card border border-success sale-widget flex-fill">
                            <div class="card-body d-flex align-items-center">
                                <span class="sale-icon bg-success text-white">
                                    <i class="ti ti-align-box-bottom-left-filled fs-24"></i>
                                </span>
                                <div class="ms-2">
                                    <p class="fw-medium mb-1">Total Stock Count</p>
                                    <div>
                                        <h3>{{ $products->sum('quantity') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card border border-info sale-widget flex-fill">
                            <div class="card-body d-flex align-items-center">
                                <span class="sale-icon bg-info text-white">
                                    <i class="ti ti-align-box-bottom-left-filled fs-24"></i>
                                </span>
                                <div class="ms-2">
                                    <p class="fw-medium mb-1">Total Stock Value</p>

                                    <div>
                                        <h3>Rs. {{ number_format($totalStockValue, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card border border-orange sale-widget flex-fill">
                            <div class="card-body d-flex align-items-center">
                                <span class="sale-icon bg-orange text-white">
                                    <i class="ti ti-moneybag fs-24"></i>
                                </span>
                                <div class="ms-2">
                                    <p class="fw-medium mb-1">Total Card Payment</p>
                                    <div>
                                        <h3>Rs. {{ number_format($cardPayment, 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card border border-danger sale-widget flex-fill">
                            <div class="card-body d-flex align-items-center">
                                <span class="sale-icon bg-danger text-white">
                                    <i class="ti ti-alert-circle-filled fs-24"></i>
                                </span>
                                <div class="ms-2">
                                    <p class="fw-medium mb-1">Total Return</p>
                                    <div>
                                        <h3>Rs. {{ number_format($orders->sum('return_amount'), 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>
                    <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Location
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3" id="locationDropdown">
                                @foreach ($locations as $location)
                                    <li>
                                        <a href="{{ route('stock.adjustment', ['location' => $location->id, 'sort' => request('sort')]) }}"
                                            class="dropdown-item rounded-1">
                                            {{ $location->name }}
                                        </a>
                                    </li>
                                @endforeach


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
                                    <a href="{{ route('stock.adjustment', ['sort' => 'recent']) }}"
                                        class="dropdown-item rounded-1">Recently Added</a>
                                </li>
                                <li>
                                    <a href="{{ route('stock.adjustment', ['sort' => 'asc']) }}"
                                        class="dropdown-item rounded-1">Ascending</a>
                                </li>
                                <li>
                                    <a href="{{ route('stock.adjustment', ['sort' => 'desc']) }}"
                                        class="dropdown-item rounded-1">Descending</a>
                                </li>
                                <li>
                                    <a href="{{ route('stock.adjustment', ['sort' => 'last_month']) }}"
                                        class="dropdown-item rounded-1">Last Month</a>
                                </li>
                                <li>
                                    <a href="{{ route('stock.adjustment', ['sort' => 'last_7_days']) }}"
                                        class="dropdown-item rounded-1">Last 7 Days</a>
                                </li>

                            </ul>
                        </div>
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
                                    <th>Location</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Qty</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" name="selected[]" value="{{ $product->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $product->locationRelation->name ?? 'N/A' }}</td>
                                        <td>{{ $product->supplier_id ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $images = $product->images ? json_decode($product->images, true) : [];
                                                $imageUrl = !empty($images)
                                                    ? $images[0]
                                                    : asset('assets/img/products/istockphoto.png');
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                    <img src="{{ $imageUrl }}" alt="product">

                                                </a>
                                                <a href="javascript:void(0);">{{ $product->product_name }}</a>
                                            </div>
                                        </td>
                                        <td>{{ $product->cate->category ?? 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($product->date)->format('d M Y') }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td class="d-flex">
                                            <div class="d-flex align-items-center edit-delete-action">
                                                <a class="me-2 border rounded d-flex align-items-center p-2 edit-stock-btn"
                                                    href="#" data-bs-toggle="modal"
                                                    data-bs-target="#edit-stock-adjustment" data-id="{{ $product->id }}"
                                                    data-quantity="{{ $product->quantity }}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a class="p-2 border rounded d-flex align-items-center"
                                                    href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#delete"
                                                    onclick="openDeleteModal({{ $product->id }})">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <script>
                            feather.replace()
                        </script>

                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>

        <!-- Edit Adjustment -->
        <div class="modal fade" id="edit-stock-adjustment" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered stock-adjust-modal">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4>Edit Quantity</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('stock.update') }}">
                        @csrf
                        <input type="hidden" name="product_id" id="product-id">
                        <div class="modal-body d-flex justify-content-center align-items-center"
                            style="min-height: 100px;">
                            <div class="product-quantity border-0 bg-gray-transparent d-flex align-items-center gap-2">
                                <button type="button" class="quantity-btn btn btn-light" id="minus-btn"
                                    aria-label="Decrease quantity">
                                    <i data-feather="minus-circle"></i>
                                </button>
                                <input type="text" id="quantity-input" name="quantity"
                                    class="quntity-input bg-transparent text-center"
                                    style="width: 60px; border: 1px solid #ccc; border-radius: 4px;">
                                <button type="button" class="quantity-btn btn btn-light" id="plus-btn"
                                    aria-label="Increase quantity">
                                    <i data-feather="plus-circle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Edit Adjustment -->

        <!-- Delete -->
        <div class="modal fade modal-default" id="delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form id="deleteTransferForm" method="POST">
                                @csrf
                                @method('DELETE')

                                <div class="icon-success bg-danger-transparent text-danger mb-2">
                                    <i class="ti ti-trash"></i>
                                </div>
                                <h3 class="mb-2">Delete Stock Adjustment</h3>
                                <p class="fs-16 mb-3">Are you sure you want to delete this product?</p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button type="submit" class="btn btn-md btn-primary">Yes, Delete</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete -->

    @endsection



    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Feather icons
                feather.replace();

                // Get buttons and input
                const minusBtn = document.getElementById('minus-btn');
                const plusBtn = document.getElementById('plus-btn');
                const qtyInput = document.getElementById('quantity-input');

                minusBtn.addEventListener('click', () => {
                    let currentVal = parseInt(qtyInput.value) || 0;
                    if (currentVal > 1) qtyInput.value = currentVal - 1;
                });

                plusBtn.addEventListener('click', () => {
                    let currentVal = parseInt(qtyInput.value) || 0;
                    qtyInput.value = currentVal + 1;
                });
            });
        </script> --}}

        {{-- Edit Adjustment --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.edit-stock-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const productId = this.dataset.id;
                        const quantity = this.dataset.quantity;

                        document.getElementById('product-id').value = productId;
                        document.getElementById('quantity-input').value = quantity;
                    });
                });

                // Optional: quantity +/-
                document.getElementById('plus-btn').addEventListener('click', () => {
                    let qty = parseInt(document.getElementById('quantity-input').value) || 0;
                    document.getElementById('quantity-input').value = qty + 1;
                });

                document.getElementById('minus-btn').addEventListener('click', () => {
                    let qty = parseInt(document.getElementById('quantity-input').value) || 0;
                    if (qty > 0) document.getElementById('quantity-input').value = qty - 1;
                });
            });
        </script>

        {{-- Delete --}}
        {{-- <script>
            document.addEventListener("DOMContentLoaded", function() {
                const deleteButtons = document.querySelectorAll('[data-bs-target="#delete"]');
                const deleteForm = document.getElementById('delete-form');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        deleteForm.setAttribute('action', `/stock-adjustment/delete/${id}`);
                    });
                });
            });
        </script> --}}
        {{-- Delete route --}}
        <script>
            function openDeleteModal(id) {
                const route = "{{ route('stock.destroy', ':id') }}".replace(':id', id);
                document.getElementById('deleteTransferForm').action = route;
            }
        </script>


        {{-- Export --}}
        <script>
            function exportData(format) {
                const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Please select at least one row to export.');
                    return;
                }
                const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value).join(',');

                document.getElementById('exportFormat').value = format;
                document.getElementById('selectedIds').value = selectedIds;

                document.getElementById('exportForm').submit();
            }
        </script>
    @endpush

</x-app-layout>
