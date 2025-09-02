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
                        <h4>Purchase Report</h4>
                        <h6>Manage your Purchase report</h6>
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

            <div class="card">
                <div class="card-body pb-1">
                    <form action="{{ route('filterByProducts.purchase') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Suppliers</label>
                                            <select class="form-select" name="supplierId" id="productSelect">
                                                <option value="all">All</option>
                                                @forelse ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->company_name }}
                                                    </option>
                                                @empty
                                                    <option disabled>Add new supplier first</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="mb-3">
                                    <button class="btn btn-primary w-100" type="submit">Generate Report</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card no-search">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div>
                        <h4>Purchase Report</h4>
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
                                    <th>Purchase Code</th>
                                    <th>Reference</th>
                                    <th>Supplier</th>
                                    <th>Date</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Instock Qty</th>
									<th>Purchase Qty</th>
									<th>Purchase Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($purchase as $purchas)
                                    @foreach ($purchas->items as $item)
                                        <tr>
                                            <td>
                                                <a>{{ $purchas->purchase_code ?? 00000 }}</a>
                                            </td>
                                             <td>
                                               {{ $purchas->reference ?? '' }}
                                            </td>
                                            <td>
                                               {{ $purchas->supplier->company_name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $item->created_at->format('D, d M Y h:i A') }}
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
                                                {{ $item->product->cate->category ?? 'no data' }}
                                            </td>
                                            <td>{{ $item->product->quantity ?? 0 }} </td>
                                            <td>{{ $item->qty ?? 0 }}</td>
                                            <td> {{ number_format($item->purchase_price, 2) }}

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
                    submitExportForm('{{ route('purchaseReport.execl') }}');
                });




            });
        </script>
    @endpush
</x-app-layout>
