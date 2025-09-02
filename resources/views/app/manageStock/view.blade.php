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
                        <h4>Manage Stock</h4>
                        <h6>Manage your stock</h6>
                    </div>
                </div>


                <form id="exportForm" method="GET" action="{{ route('stocks.export') }}">
                    <input type="hidden" name="selected_ids" id="exportSelectedIds">
                    <input type="hidden" name="product_id" id="exportProductId" value="{{ request('product_id') }}">
                    <input type="hidden" name="location_id" id="exportLocationId" value="{{ request('location_id') }}">
                    <input type="hidden" name="format" id="exportFormat" value="">
                    <ul class="table-top-head">
                        <li>
                            <a href="javascript:void(0);" onclick="submitExport('pdf')" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Pdf">
                                <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" onclick="submitExport('excel')" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Excel">
                                <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img">
                            </a>
                        </li>
                </form>
                <li>
                    <a href="{{ url()->current() }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                            class="ti ti-refresh"></i></a>
                </li>

                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            class="ti ti-chevron-up"></i></a>
                </li>
                </ul>

                {{-- <div class="page-btn">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-stock"><i
                            class="ti ti-circle-plus me-1"></i>Add Stock</a>
                </div> --}}
            </div>

            <!-- /product list -->
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>
                    <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">

                        <form method="GET" id="filterForm" action="{{ route('manage_stock') }}">

                            <input type="hidden" name="location_id" id="locationFilterInput"
                                value="{{ request('location_id') }}">
                            <input type="hidden" name="product_id" id="productFilterInput"
                                value="{{ request('product_id') }}">
                        </form>

                        <div class="d-flex gap-2">
                            {{-- Location Dropdown --}}
                            {{-- <div class="dropdown me-2">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    {{ $locations->firstWhere('id', request('location_id'))?->name ?? 'Location' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    @foreach ($locations as $location)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="filterByLocation({{ $location->id }})">
                                                {{ $location->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div> --}}

                            <div class="dropdown me-2">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Warehouse
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                            onclick="filterByLocation('')">All Locations</a>
                                    </li>
                                    @foreach ($locations as $location)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="filterByLocation('{{ $location->id }}')">
                                                {{ $location->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                            {{-- Product Dropdown --}}
                            {{-- <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    {{ $products->firstWhere('id', request('product_id'))?->product_name ?? 'Product' }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    @foreach ($products as $product)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="filterByProduct({{ $product->id }})">
                                                {{ $product->product_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div> --}}

                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Product
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                            onclick="filterByProduct('')">All Products</a>
                                    </li>
                                    @foreach ($products as $product)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="filterByProduct('{{ $product->id }}')">
                                                {{ $product->product_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


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
                                    <th>Warehouse</th>
                                    {{-- <th>Store</th> --}}
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Person</th>
                                    <th>Qty</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stocks as $stock)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" name="selected_stocks[]"
                                                    value="{{ $stock->id }}"  class="stock-checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $stock->location->name ?? 'N/A' }} </td>
                                        {{-- <td>Electro Mart </td> --}}
                                        <td>
                                            @php
                                                $images = $stock->product->images
                                                    ? json_decode($stock->product->images, true)
                                                    : [];
                                                $imageUrl = !empty($images)
                                                    ? $images[0]
                                                    : asset('assets/img/products/istockphoto.png');
                                            @endphp
                                            <div class="d-flex align-items-center">

                                                <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                                    <img src="{{ $imageUrl }}" alt="product">

                                                </a>
                                                <a
                                                    href="javascript:void(0);">{{ $stock->product->product_name ?? 'N/A' }}</a>
                                            </div>
                    </div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($stock->updated_at)->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            {{-- <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="assets/img/users/user-30.jpg" alt="product">
                            </a> --}}
                            <a href="javascript:void(0);">{{ $stock->responsible_person ?? 'N/A' }}</a>
                        </div>
                    </td>
                    <td>{{ $stock->stock }}</td>
                    <td class="d-flex">
                        <div class="d-flex align-items-center edit-delete-action">
                            {{-- <a class="me-2 border rounded d-flex align-items-center p-2" href="#"
                                                data-bs-toggle="modal" data-bs-target="#edit-stock">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a> --}}
                            <a class="p-2 border rounded d-flex align-items-center" href="javascript:void(0);"
                                data-bs-toggle="modal" data-bs-target="#deleteStockModal{{ $stock->id }}">
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


        <!-- Delete -->
        @foreach ($stocks as $stock)
            <div class="modal fade modal-default" id="deleteStockModal{{ $stock->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="success-wrap text-center">
                                <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <div class="icon-success bg-danger-transparent text-danger mb-2">
                                        <i class="ti ti-trash"></i>
                                    </div>
                                    <h3 class="mb-2">Delete Stock</h3>
                                    <p class="fs-16 mb-3">Are you sure you want to delete
                                        <strong>{{ $stock->product->product_name }}</strong> from stock?
                                    </p>
                                    <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                        <button type="button" class="btn btn-md btn-secondary"
                                            data-bs-dismiss="modal">No,
                                            Cancel</button>
                                        <button type="submit" class="btn btn-md btn-primary">Yes, Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- /Delete -->


    @endsection


    @push('js')
        {{-- <script>
            document.querySelectorAll('.dropdown-menu a.dropdown-item').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    let value = this.getAttribute('data-value');
                    let dropdown = this.closest('.dropdown');
                    let button = dropdown.querySelector('button.dropdown-toggle');

                    button.textContent = this.textContent;

                    if (dropdown.querySelector('input[type="hidden"]').id === 'warehouseInput') {
                        document.getElementById('warehouseInput').value = value;
                    } else {
                        document.getElementById('productInput').value = value;
                    }

                    // Submit the form to reload with filters
                    document.getElementById('filterForm').submit();
                });
            });
        </script> --}}

        {{-- <script>
            function filterByLocation(locationId) {
                document.getElementById('locationFilterInput').value = locationId;
                document.getElementById('filterForm').submit();
            }

            function filterByProduct(productId) {
                document.getElementById('productFilterInput').value = productId;
                document.getElementById('filterForm').submit();
            }
        </script> --}}

        <script>
            function filterByLocation(locationId) {
                if (locationId === '') {
                    // Reset both filters if "All Locations" is selected
                    document.getElementById('locationFilterInput').value = '';
                    document.getElementById('productFilterInput').value = '';
                } else {
                    document.getElementById('locationFilterInput').value = locationId;
                }
                document.getElementById('filterForm').submit();
            }

            function filterByProduct(productId) {
                if (productId === '') {
                    // Reset both filters if "All Products" is selected
                    document.getElementById('productFilterInput').value = '';
                    document.getElementById('locationFilterInput').value = '';
                } else {
                    document.getElementById('productFilterInput').value = productId;
                }
                document.getElementById('filterForm').submit();
            }
        </script>
{{--
        <script>
            // Select all checkbox toggles all individual checkboxes
            document.getElementById('select-all').addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.stock-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            function submitExport(format) {
                let selectedCheckboxes = document.querySelectorAll('.stock-checkbox:checked');
                if (selectedCheckboxes.length === 0) {
                    alert('Please select at least one stock to export.');
                    return;
                }

                // Collect selected IDs into array
                let selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

                // Set hidden input value as comma-separated string
                document.getElementById('exportSelectedIds').value = selectedIds.join(',');
                document.getElementById('exportFormat').value = format;

                document.getElementById('exportForm').submit();
            }
        </script> --}}

        <script>
            document.getElementById('select-all').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('.stock-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

function submitExport(format) {
    // Remove client-side check and alert
    // The backend will handle validation and return error message if no selection

    // Collect selected IDs (optional, but still send for backend processing)
    let selectedCheckboxes = document.querySelectorAll('.stock-checkbox:checked');
    let selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);

    document.getElementById('exportSelectedIds').value = selectedIds.join(',');
    document.getElementById('exportFormat').value = format;

    document.getElementById('exportForm').submit();
}

        </script>
    @endpush
</x-app-layout>
