<x-app-layout>
    @section('title', 'Quotation View')

    @push('css')
        <style>
            /* Optional CSS for Quotation-specific styling */
        </style>
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Quotation Details</h4>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a onclick="downloadPDF()" data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
                    </li>
                    <li>
                        <a href="{{ route('quotation.print', $quotation->id) }}" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Print"><i data-feather="printer"
                                class="feather-rotate-ccw"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="{{ route('quotation.index') }}" class="btn btn-primary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Quotations</a>
                </div>
            </div>

            <!-- Quotation -->
            <div id="printArea">
                <div class="card">
                    <div class="card-body">
                        <div class="row justify-content-between align-items-center border-bottom mb-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/logo.svg') }}" width="130" class="img-fluid"
                                        alt="logo">
                                </div>
                                <p>3099 Kennedy Court Framingham, MA 01702</p>
                            </div>
                            <div class="col-md-6">
                                <div class="text-end mb-3">
                                    <h5 class="text-gray mb-1">Quotation No: <span class="text-primary"
                                            id="quotation_no">QUT00{{ $quotation->id }}</span></h5>
                                    <p class="mb-1 fw-medium">Date : <span
                                            class="text-dark">{{ \Carbon\Carbon::parse($quotation->date)->format('M d, Y') }}</span> </p>
                                </div>
                            </div>
                        </div>

                        <div class="row border-bottom mb-3">
                            <div class="col-md-5">
                                <p class="text-dark mb-2 fw-semibold">From</p>
                                <div>
                                    <h4 class="mb-1">Company Name</h4>
                                    <p class="mb-1">Company Address</p>
                                    <p class="mb-1">Email : <span class="text-dark">company@email.com</span></p>
                                    <p>Phone : <span class="text-dark">00000000</span></p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <p class="text-dark mb-2 fw-semibold">To</p>
                                @if (!empty($quotation->customer))
                                    <div>
                                        <h4 class="mb-1">{{ $quotation->customer->first_name ?? 'Walk On Customer' }}</h4>
                                        <p class="mb-1">{{ $quotation->customer->address ?? '' }}</p>
                                        <p class="mb-1">Email : <span class="text-dark">{{ $quotation->customer->email ?? '' }}</span></p>
                                        <p>Phone : <span class="text-dark">{{ $quotation->customer->phone ?? '' }}</span></p>
                                    </div>
                                @else
                                    <div>
                                        <h4 class="mb-1">Walk On Customer</h4>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <p class="text-title mb-2 fw-medium">Status</p>
                                    <span class="bg-warning text-white fs-16 px-1 rounded"><i
                                            class="ti ti-point-filled"></i>Ready</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <p class="fw-medium">Quotation For : <span class="text-dark fw-medium">
                                    Business({{ $quotation->type ?? 'Retails' }}) </span></p>

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
                                        @forelse ($quotation->items as $item)


                                            <tr>
                                                <td class="text-gray-9 fw-medium">{{ $loop->iteration }}</td>
                                                <td class="text-gray-9 fw-medium">{{ $item->product->product_name }}</td>
                                                <td class="text-gray-9 fw-medium text-end">{{ $item->quantity }}</td>
                                                <td class="text-gray-9 fw-medium text-end">{{ number_format($item->unit_cost, 2) }}</td>
                                                <td class="text-gray-9 fw-medium text-end">Rs. {{ number_format($item->total_cost , 2) }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row border-bottom mb-3">
                            <div class="col-md-5 ms-auto mb-3">
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">Sub Total</p>
                                    <p class="text-dark fw-medium mb-2">Rs. {{ number_format($quotation_items->sum('total_cost'), 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pe-3">
                                    <p class="mb-0">Discount</p>
                                    <p class="text-dark fw-medium mb-2">Rs. {{ number_format($quotation->discount, 2) }}</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2 pe-3">
                                    <h5>Total Amount</h5>
                                    <h5>Rs. {{ number_format($quotation->total_amount, 2) }}</h5>
                                </div>
                                <p class="fs-12">
                                    Amount in Words : {{ ucfirst(numberToWords($quotation->total_amount)) }} rupees only
                                </p>
                            </div>
                        </div>

                        <div class="text-center">
                            <div class="mb-3">
                                <img src="{{ asset('assets/img/logo.svg') }}" width="130" class="img-fluid"
                                    alt="logo">
                            </div>
                            <p class="text-dark mb-1">This is a computer-generated document and does not require a
                                signature.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Quotation -->

            <div class="d-flex justify-content-center align-items-center mb-4">
                <a onclick="printCard()" class="btn btn-primary d-flex justify-content-center align-items-center me-2"><i
                        class="ti ti-printer me-2"></i>Print Invoice Format</a>
                        <a href="{{ route('quotation.print', $quotation->id) }}" class="btn btn-info d-flex justify-content-center align-items-center me-2"><i
                        class="ti ti-printer me-2"></i>Print 80MM Format</a>
            </div>



        </div>
    @endsection

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
        <script>
            function printCard() {
                let printContents = document.getElementById("printArea").innerHTML;
                let originalContents = document.body.innerHTML;

                document.body.innerHTML = `
        <html>
            <head>
                <title>Quotation Print</title>
                <style>
                    @media print {
                        @page { size: A4; margin: 15mm; }
                        body { font-family: Arial, sans-serif; font-size: 14px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 6px; }
                        .text-end { text-align: right; }
                    }
                </style>
            </head>
            <body>${printContents}</body>
        </html>`;
                window.print();
                document.body.innerHTML = originalContents;
                location.reload();
            }

            function downloadPDF() {
                let element = document.getElementById("printArea");
                let opt = {
                    margin: 0.5,
                    filename: 'quotation_{{ $quotation->quotation_no }}.pdf',
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2 },
                    jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(element).save();
            }
        </script>
    @endpush
</x-app-layout>
