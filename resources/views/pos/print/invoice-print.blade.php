<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from dreamspos.dreamstechnologies.com/html/template/invoice-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 23 Jun 2025 07:22:16 GMT -->

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords"
        content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>Dreams POS - Inventory Management & Admin Dashboard Template</title>

    <script src="assets/js/theme-script.js" type="e2029cfdfe7b7c387e389d1e-text/javascript"></script>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">

    <!-- jQuery (must be first) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS (must be after jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/theme-script.js') }}" type="62427e9c5fffd0f0e06cdda6-text/javascript"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/logo/favicon.png') }}">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/logo/favicon.png') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables-bootstrap5.min.css') }}">
    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/feather.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/@simonwep/pickr/themes/nano.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

</head>

<body>
    <!-- Main Wrapper -->


    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <!-- Invoices -->
                <div id="printArea">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between align-items-center border-bottom mb-3">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        {{-- customer company Logo --}}
                                        <img src="{{ asset('assets/img/logo.svg') }}" width="130" class="img-fluid"
                                            alt="logo">
                                    </div>
                                    <p>3099 Kennedy Court Framingham, MA 01702</p>
                                </div>
                                <div class="col-md-6">
                                    <div class=" text-end mb-3">
                                        <h5 class="text-gray mb-1">Invoice No <span class="text-primary"
                                                id="invoice_no">{{ $orders->invoice_no }}</span></h5>
                                        <p class="mb-1 fw-medium">Created Date : <span
                                                class="text-dark">{{ $orders->created_at->format('M d, Y') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-bottom mb-3">
                                <div class="col-md-5">
                                    <p class="text-dark mb-2 fw-semibold">From</p>
                                    <div>
                                        <h4 class="mb-1">Company Name</h4>
                                        <p class="mb-1">Company Address</p>
                                        <p class="mb-1">Email : <span class="text-dark"><a href="#"
                                                    class="__cf_email__"
                                                    data-cfemail="c490a5b6a5a8a5f6f0f0f184a1bca5a9b4a8a1eaa7aba9">Company
                                                    Email
                                                </a></span>
                                        </p>
                                        <p>Phone : <span class="text-dark">00000000</span></p>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <p class="text-dark mb-2 fw-semibold">To</p>
                                    @if (!empty($orders->customer))
                                        <div>
                                            <h4 class="mb-1">
                                                {{ $orders->customer->first_name ?? 'Walk On Customer' }}</h4>
                                            <p class="mb-1">{{ $orders->customer->address ?? '' }}</p>
                                            <p class="mb-1">Email : <span class="text-dark"><a href="#"
                                                        class="__cf_email__"
                                                        data-cfemail="05566477645a6c6b66363145607d64687569602b666a68">{{ $orders->customer->email ?? '' }}</a></span>
                                            </p>
                                            <p>Phone : <span
                                                    class="text-dark">{{ $orders->customer->phone ?? '' }}</span></p>
                                        </div>
                                    @else
                                        <div>
                                            <h4 class="mb-1">Walk On Customer</h4>
                                        </div>
                                    @endif

                                </div>
                                <div class="col-md-2">
                                    <div class="mb-3">
                                        <p class="text-title mb-2 fw-medium">Payment Status </p>
                                        @if ($orders->transaction->payment_status == 'Paid')
                                            <span class="bg-success text-white fs-10 px-1 rounded"><i
                                                    class="ti ti-point-filled "></i>Paid</span>
                                        @elseif($orders->transaction->payment_status == 'return')
                                            <span class="bg-danger text-white fs-10 px-1 rounded"><i
                                                    class="ti ti-point-filled "></i>Return</span>
                                        @else
                                            <span class="bg-warning text-white fs-10 px-1 rounded"><i
                                                    class="ti ti-point-filled "></i>Pending</span>
                                        @endif

                                        <div class="mt-3">
                                            <svg class="img-fluid barcode" id="barcode"></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <p class="fw-medium">Invoice For : <span class="text-dark fw-medium">
                                        Business({{ $orders->sales_type ?? 'Retails' }}) </span></p>
                                <div class="table-responsive mb-3">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Item</th>
                                                <th class="text-end">Qty</th>
                                                <th class="text-end">Price</th>
                                                <th class="text-end">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Normal Purchased Items --}}
                                            @forelse ($orders->items as $item)
                                                <tr>
                                                    <td class="text-gray-9 fw-medium ">{{ $loop->iteration }}</td>
                                                    <td class="text-gray-9 fw-medium ">
                                                        {{ $item->product->product_name }}</td>
                                                    <td class="text-gray-9 fw-medium text-end">{{ $item->qty }}
                                                    </td>
                                                    <td class="text-gray-9 fw-medium text-end">
                                                        {{ number_format($item->net_price, 2) }}</td>
                                                    <td class="text-gray-9 fw-medium text-end">Rs.
                                                        {{ number_format($item->total, 2) }}</td>
                                                </tr>
                                            @empty
                                            @endforelse

                                            {{-- Return Items Separator --}}
                                            @if ($orders->return_data->count())
                                                <tr>
                                                    <td colspan="5"
                                                        style="border-top: 2px solid #000; padding-top: 10px; font-weight: bold; background-color: #f0f0f0; text-align: center;">
                                                        Returned Items
                                                    </td>
                                                </tr>

                                                @php $return_total_value = 0; @endphp

                                                {{-- Returned Items --}}
                                                @foreach ($orders->return_data as $return)
                                                    <tr>
                                                        <td class="text-gray-9 fw-medium">{{ $loop->iteration }}</td>
                                                        <td class="text-gray-9 fw-medium ">
                                                            {{ $return->product_data->product_name }}</td>
                                                        <td class="text-gray-9 fw-medium text-end">
                                                            {{ $return->return_qty }}
                                                        </td>
                                                        <td class="text-gray-9 fw-medium text-end">
                                                            {{ number_format($return->return_net_price, 2) }}</td>
                                                        <td class="text-gray-9 fw-medium text-end">Rs.
                                                            {{ number_format($return->total, 2) }}</td>
                                                    </tr>
                                                    @php
                                                        $return_total_value += $return->total;
                                                    @endphp
                                                @endforeach
                                            @endif


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row border-bottom mb-3">
                                <div class="col-md-5 ms-auto mb-3">
                                    <div
                                        class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                        <p class="mb-0">Sub Total</p>
                                        <p class="text-dark fw-medium mb-2">Rs.
                                            {{ number_format($orders->subtotal, 2) }}</p>
                                    </div>
                                    <div
                                        class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                        <p class="mb-0">Discount </p>
                                        <p class="text-dark fw-medium mb-2">Rs.
                                            {{ number_format($orders->discount, 2) }}</p>
                                    </div>

                                    @if ($orders->return_data->count())
                                        <div
                                            class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                            <p class="mb-0">Return Deduction </p>
                                            <p class="text-dark fw-medium mb-2">Rs.
                                                {{ number_format($return_total_value, 2) }}
                                            </p>
                                        </div>
                                    @endif

                                    @if ($orders->total == 0 && $orders->return_amount > 0)
                                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                            <h5>Net Payable Amount</h5>
                                            <h5>Rs. {{ number_format($orders->return_amount, 2) }}</h5>
                                        </div>
                                    @elseif ($orders->total == 0 && $orders->return_amount == 0)
                                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                            <h5></h5>
                                            <h5>Exchange</h5>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                            <h5>Total Amount</h5>
                                            <h5>Rs. {{ number_format($orders->total, 2) }}</h5>
                                        </div>
                                        <p class="fs-12">
                                            Amount in Words : {{ ucfirst(numberToWords($orders->total)) }} rupees only
                                        </p>
                                    @endif

                                </div>
                            </div>
                            <div class="row align-items-center border-bottom mb-3">
                                <div class="col-md-7">
                                    <div>


                                        <div class="mb-3">
                                            <h6 class="mb-1">Payment Details</h6>
                                            <p>Payment Made Via {{ $orders->transaction->payment_method }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">

                                </div>
                            </div>
                            <div class="text-center">
                                <div class="mb-3">
                                    <img src="{{ asset('assets/img/logo.svg') }}" width="130" class="img-fluid"
                                        alt="logo">
                                </div>
                                <p class="text-dark mb-1">This is a computer-generated document and does not require a
                                    signature.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Invoices -->
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->


    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}" type="text/javascript"></script>
    <!-- Slimscroll JS -->
    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}" type="760da1dc9a40e43dbe4a35db-text/javascript"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- Color Picker JS -->
    <script src="{{ asset('assets/plugins/@simonwep/pickr/pickr.es5.min.js') }}" type="text/javascript"></script>
    <!-- Custom JS -->
    <script src="{{ asset('assets/js/theme-colorpicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
        data-cf-settings="62427e9c5fffd0f0e06cdda6-|49" defer></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"954235ae9edd5134","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
        crossorigin="anonymous"></script>

</body>

</html>
