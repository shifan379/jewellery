<x-app-layout>
    @section('title', 'Invoice View')

    @push('css')
        <style>
            /* .barcode {
            margin-top: 10px;
            text-align: center;
            width: 800px;
            height: auto;
        } */
        </style>
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Invoice Details</h4>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a onclick="downloadPDF()" data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                    </li>
                    <li>
                        <a href="{{ route('pos.format', $orders->id) }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Print"><i data-feather="printer" class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="{{ route('invoice.index') }}" class="btn btn-primary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to
                        Invoices</a>
                </div>
            </div>


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
                                            class="text-dark">{{ $orders->created_at->format('M d, Y') }}</span> </p>
                                </div>
                            </div>
                        </div>
                        <div class="row border-bottom mb-3">
                            <div class="col-md-5">
                                <p class="text-dark mb-2 fw-semibold">From</p>
                                <div>
                                    <h4 class="mb-1">Company Name</h4>
                                    <p class="mb-1">Company Address</p>
                                    <p class="mb-1">Email : <span class="text-dark"><a href="#" class="__cf_email__"
                                                data-cfemail="c490a5b6a5a8a5f6f0f0f184a1bca5a9b4a8a1eaa7aba9">Company Email
                                            </a></span>
                                    </p>
                                    <p>Phone : <span class="text-dark">00000000</span></p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <p class="text-dark mb-2 fw-semibold">To</p>
                                @if (!empty($orders->customer))
                                    <div>
                                        <h4 class="mb-1">{{ $orders->customer->first_name ?? 'Walk On Customer' }}</h4>
                                        <p class="mb-1">{{ $orders->customer->address ?? '' }}</p>
                                        <p class="mb-1">Email : <span class="text-dark"><a href="#"
                                                    class="__cf_email__"
                                                    data-cfemail="05566477645a6c6b66363145607d64687569602b666a68">{{ $orders->customer->email ?? '' }}</a></span>
                                        </p>
                                        <p>Phone : <span class="text-dark">{{ $orders->customer->phone ?? '' }}</span></p>
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
                                        <span class="bg-success text-white fs-16 px-1 rounded"><i
                                                class="ti ti-point-filled "></i>Paid</span>
                                    @elseif($orders->transaction->payment_status == 'return')
                                        <span class="bg-danger text-white fs-16 px-1 rounded"><i
                                                class="ti ti-point-filled "></i>Return</span>
                                    @else
                                        <span class="bg-warning text-white fs-16 px-1 rounded"><i
                                                class="ti ti-point-filled "></i>Pending</span>
                                    @endif

                                    {{-- <div class="mt-3">
                                        <svg class="img-fluid" id="barcode"></svg>
                                    </div> --}}
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
                                                <td class="text-gray-9 fw-medium ">{{ $item->product->product_name }}</td>
                                                <td class="text-gray-9 fw-medium text-end">{{ $item->qty }}</td>
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
                                                    <td class="text-gray-9 fw-medium text-end">{{ $return->return_qty }}
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
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">Sub Total</p>
                                    <p class="text-dark fw-medium mb-2">Rs. {{ number_format($orders->subtotal, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">Discount </p>
                                    <p class="text-dark fw-medium mb-2">Rs. {{ number_format($orders->discount, 2) }}</p>
                                </div>

                                @if ($orders->return_data->count())
                                    <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
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

            <div class="d-flex justify-content-center align-items-center mb-4">
                <a onclick="printCard()" class="btn btn-primary d-flex justify-content-center align-items-center me-2"><i
                        class="ti ti-printer me-2"></i>Print Invoice Format</a>

                <a href="{{ route('pos.format', $orders->id) }}"
                    class="btn btn-secondary d-flex justify-content-center align-items-center border"><i
                        class="ti ti-printer me-2"></i>Print POS Format</a>
            </div>
        </div>


    @endsection





    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
        <script>
            JsBarcode("#barcode", document.getElementById("invoice_no").textContent, {
                format: "CODE128",
                displayValue: true,
                fontSize: 14,
                height: 40
            });
        </script>

        <script>
            function printCard() {
                let printContents = document.getElementById("printArea").innerHTML;
                let originalContents = document.body.innerHTML;

                document.body.innerHTML = `
        <html>
            <head>
                <title>Invoice Print</title>
                <style>
                    @media print {
                        @page {
                            size: A4;
                            margin: 15mm;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 6px;
                        }
                        .text-end {
                            text-align: right;
                        }
                    }
                </style>
            </head>
            <body>${printContents}</body>
        </html>
    `;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload(); // reload to restore JS functionality
            }

            function downloadPDF() {
                let element = document.getElementById("printArea");
                let opt = {
                    margin: 0.5,
                    filename: 'invoice_{{ $orders->invoice_no }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };
                html2pdf().set(opt).from(element).save();
            }
        </script>
    @endpush
</x-app-layout>
