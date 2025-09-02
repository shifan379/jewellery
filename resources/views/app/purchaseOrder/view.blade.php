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
                        <h4 class="fw-bold">Purchase order</h4>
                        <h6>Manage your Purchase order</h6>
                    </div>
                </div>

                <form id="purchaseExportForm" method="POST">
                    @csrf
                    <input type="hidden" name="export_type" id="export_type" value="">
                    <input type="hidden" name="selected_ids" id="selected_ids" value="">

                    <ul class="table-top-head">
                        <li>
                            <a href="#" id="export-purchase-pdf" title="Pdf">
                                <img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="PDF">
                            </a>
                        </li>
                        <li>
                            <a href="#" id="export-purchase-excel" title="Excel">
                                <img src="{{ asset('assets/img/icons/excel.svg') }}" alt="Excel">
                            </a>
                        </li>
                    </ul>
                </form>

                <ul class="table-top-head">
                    <li>
                        <a href="{{ url()->current() }}" title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
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
                        <form method="GET" action="{{ route('purchase.order') }}">
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Sort By : {{ ucwords(str_replace('_', ' ', $sort ?? 'Last 7 Days')) }}
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li><button class="dropdown-item rounded-1" type="submit" name="sort"
                                            value="recent">Recently Added</button></li>
                                    <li><button class="dropdown-item rounded-1" type="submit" name="sort"
                                            value="asc">Ascending</button></li>
                                    <li><button class="dropdown-item rounded-1" type="submit" name="sort"
                                            value="desc">Descending</button></li>
                                    <li><button class="dropdown-item rounded-1" type="submit" name="sort"
                                            value="last_month">Last Month</button></li>
                                    <li><button class="dropdown-item rounded-1" type="submit" name="sort"
                                            value="last_7_days">Last 7 Days</button></li>
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
                                    <th>Product</th>
                                    <th>Purchased Amount</th>
                                    <th>Purchased QTY</th>
                                    <th>Instock QTY</th>
                                </tr>
                            </thead>
                            {{-- <tbody>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td class="d-flex align-items-center p-3 px-2">
                                        <a class="avatar avatar-md me-2">
                                            <img src="assets/img/products/stock-img-01.png" alt="product">
                                        </a>
                                        <a href="javascript:void(0);">Lenovo IdeaPad 3</a>
                                    </td>
                                    <td>$1000</td>
                                    <td>40</td>
                                    <td>30</td>
                                </tr>

                            </tbody> --}}
                            <tbody>
                                @foreach ($purchaseItems as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" name="purchase_ids[]" value="{{ $item->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        {{-- <td class="d-flex align-items-center p-3 px-2">
                                            <a class="avatar avatar-md me-2">
                                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="product"
                                                    style="width: 40px; height: auto;">
                                            </a>
                                            <a href="javascript:void(0);">{{ $item->product->product_name }}</a>
                                        </td> --}}
                                        @php
                                            $images = $item->product->images
                                                ? json_decode($item->product->images, true)
                                                : [];

                                            // Check if it's already a full URL or path starting with 'http' or 'storage/'
$firstImage = $images[0] ?? null;

if (
    $firstImage &&
    Str::startsWith($firstImage, ['http', 'storage', '/storage'])
) {
    $imageUrl = $firstImage;
} elseif ($firstImage) {
    $imageUrl = asset('storage/' . $firstImage);
} else {
    $imageUrl = asset('assets/img/products/istockphoto.png');
                                            }

                                        @endphp

                                        <td class="d-flex align-items-center p-3 px-2">
                                            <a class="avatar avatar-md me-2">
                                                <img src="{{ $imageUrl }}" alt="product"
                                                    style="width: 40px; height: auto;">
                                            </a>
                                            <a href="javascript:void(0);">{{ $item->product->product_name }}</a>
                                        </td>


                                        <td>Rs. {{ number_format($item->purchase_price * $item->qty, 2) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ (int) $item->product->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>


    @endsection


    @push('js')
        <script>
            // Trigger export on PDF/Excel button click
            $('#export-purchase-pdf, #export-purchase-excel').on('click', function(e) {
                e.preventDefault();

                // Determine which export type was clicked
                let exportType = this.id.includes('pdf') ? 'pdf' : 'excel';
                $('#export_type').val(exportType);

                // Collect selected checkbox values
                let selectedIds = [];
                $('input[name="purchase_ids[]"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                // if (selectedIds.length === 0) {
                //     alert('Please select at least one item to export.');
                //     return;
                // }

                $('#selected_ids').val(selectedIds.join(','));

                // Set form action based on type
                let actionUrl = (exportType === 'pdf') ?
                    "{{ route('purchases.export.selected.pdf') }}" :
                    "{{ route('purchases.export.selected.excel') }}";

                $('#purchaseExportForm').attr('action', actionUrl).submit();
            });

            // Optional: Select All functionality
            $('#select-all').on('change', function() {
                $('input[name="purchase_ids[]"]').prop('checked', this.checked);
            });
        </script>
    @endpush
</x-app-layout>
