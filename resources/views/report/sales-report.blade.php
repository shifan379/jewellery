<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <!-- Bootstrap Tagsinput CSS -->
        <link rel="stylesheet" href="{{ asset(path: 'assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
        <!-- Daterangepikcer CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <style>
            .table-wrapper {
                position: relative;
            }

            #product-loader {
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 10;
                transform: translate(-50%, -50%);
                display: none;
            }

            #product-table.dull {
                opacity: 0.3;
                pointer-events: none;
                filter: grayscale(0.7);
            }
        </style>
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Sales Report</h4>
                        <h6>Manage your Sales report</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                class="ti ti-refresh"></i></a>
                    </li>
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
                    <div class="card border border-success sale-widget flex-fill">
                        <div class="card-body d-flex align-items-center">
                            <span class="sale-icon bg-success text-white">
                                <i class="ti ti-align-box-bottom-left-filled fs-24"></i>
                            </span>
                            <div class="ms-2">
                                <p class="fw-medium mb-1">Total Amount</p>
                                <div>
                                    <h3>Rs. {{ number_format($orders->sum('total'), 2) }}</h3>
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
                                <p class="fw-medium mb-1">Total Cash Payment</p>
                                @php
                                    $cashPayment = $orders->sum(
                                        fn($order) => optional($order->transaction)->payment_method === 'cash'
                                            ? $order->transaction->total
                                            : 0,
                                    );
                                    $cardPayment = $orders->sum(
                                        fn($order) => optional($order->transaction)->payment_method === 'credit'
                                            ? $order->transaction->total
                                            : 0,
                                    );
                                @endphp
                                <div>
                                    <h3>Rs. {{ number_format($cashPayment, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
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
                </div>
                <div class="col-xl-3 col-sm-6 col-12 d-flex">
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
                </div>
            </div>
            <div class="card">
                <div class="card-body pb-1">
                    <form action="{{ route('filterByProducts') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Choose Date </label>
                                            <div class="input-icon-start position-relative">
                                                <input type="text" name="date_range" class="form-control date-range bookingrange"
                                                    placeholder="dd/mm/yyyy - dd/mm/yyyy">
                                                <span class="input-icon-left">
                                                    <i class="ti ti-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Store</label>
                                            <select class="form-select"  id="storeSelect">
                                                <option value="all">All</option>
                                                @forelse ($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @empty
                                                    <option disabled>Add new location first</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Products</label>
                                            <select class="form-select" name="productID" id="productSelect">
                                                <option value="all" >All</option>
                                                @forelse ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}
                                                    </option>
                                                @empty
                                                    <option disabled>Add new product first</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Generate Report </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div class="card">
                <div class="card-body pb-1">
                    <form action="{{ route('filterByDate') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-label">Choose Date </label>
                                            <div class="input-icon-start position-relative">
                                                <input type="text" name="date_range" class="form-control date-range bookingrange"
                                                    placeholder="dd/mm/yyyy - dd/mm/yyyy">
                                                <span class="input-icon-left">
                                                    <i class="ti ti-calendar"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Generate Report by Date</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}

            <div class="card no-search">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div>
                        <h4>Sales Report</h4>
                    </div>
                    <ul class="table-top-head">
                        <li class="me-2">
                            <a data-bs-toggle="tooltip" class="exportToExcel" data-bs-placement="top" title="Excel"><img
                                    src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Name</th>
                                    <th>Date</th>
                                    <th>Category</th>
                                    <th>Sold Qty</th>
                                    <th>Sold Amount</th>
                                    <th>Instock Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>
                                                <a>{{ $order->invoice_no ?? 00000 }}</a>
                                            </td>
                                            @php
                                                $images = $item->product->images
                                                    ? json_decode($item->product->images, true)
                                                    : [];
                                                $imageUrl = !empty($images)
                                                    ? $images[0]
                                                    : asset('assets/img/products/istockphoto.png');
                                            @endphp
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a class="avatar avatar-md">
                                                        <img src="{{ $imageUrl }}" class="img-fluid" alt="img">
                                                    </a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0">
                                                            <a>{{ $item->product->product_name ?? '' }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->created_at->format('D, d M Y h:i A') }}
                                            </td>
                                            <td>
                                                {{ $item->product->cate->category ?? 'no data' }}
                                            </td>
                                            <td>{{ $item->qty }} </td>
                                            <td> {{ number_format($item->net_price, 2) }}

                                            </td>
                                            <td>
                                                {{ $item->product->quantity ?? 0 }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>
    @endsection


    @push('js')
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>

        <!-- Datetimepicker JS -->
        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Daterangepikcer JS -->
        <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>


        <script></script>
        <script>
            $(document).ready(function() {
                function submitExportForm(route) {

                    var form = $('<form>', {
                        action: route,
                        method: 'POST'
                    });
                    form.append('@csrf');
                    $('body').append(form);
                    form.submit();
                }

                $(".exportToExcel").on("click", function() {
                    submitExportForm('{{ route('salesReport.execl') }}');
                });


                $('#storeSelect').on('change', function() {
                    let locationId = $(this).val();

                    $.ajax({
                        url: '{{ route('getProductsByLocation') }}',
                        type: 'POST',
                        data: {
                            location_id: locationId,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#productSelect').empty();
                            $('#productSelect').append('<option value="all">All</option>');

                            if (response.length > 0) {
                                $.each(response, function(key, product) {
                                    $('#productSelect').append('<option value="' + product
                                        .id + '">' + product.product_name + '</option>');
                                });
                            } else {
                                $('#productSelect').append(
                                    '<option disabled>No products found</option>');
                            }
                        }
                    });

                });

            });
        </script>
    @endpush
</x-app-layout>
