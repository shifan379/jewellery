<x-app-layout>
    @section('title', 'Advances')

    @push('css')
        <!-- Datetimepicker CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
        <!-- Bootstrap Tagsinput CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
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
                        <h4 class="fw-bold">Customer Advance Payments</h4>
                        <h6>Manage your advance payments</h6>
                    </div>
                </div>
                <ul class="table-top-head">
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-advance"><i
                            class="ti ti-circle-plus me-1"></i>Add Advance</a>



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
                    <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" data-status="CR"
                                        class="dropdown-category dropdown-item rounded-1">Advance</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-status="DR"
                                        class=" dropdown-category dropdown-item rounded-1">Due</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-status="Paid"
                                        class=" dropdown-category dropdown-item rounded-1">Paid</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div class="table-wrapper position-relative">
                            <div id="product-loader" style="display:none;">
                                <img src="{{ asset('assets/img/loader/table-loader.gif') }}" alt="Loading..."
                                    style="width:500px; height:500px;">
                            </div>
                            <table class="table datatable" id="product-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="no-sort">
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Customer Name</th>
                                        <th>Date</th>
                                        <th>Order No </th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body" class="">

                                    @include('app.customer-due.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>

        {{-- model --}}

        <!-- Add Advance -->
        <div class="modal fade" id="add-advance">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Advance</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <form action="{{ route('customer-due.store') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="add-newplus">
                                        <label class="form-label">Customer Name</label>
                                        <a href="{{ route('customer') }}"><i data-feather="plus-circle"
                                                class="plus-down-add"></i><span>Add
                                                New</span></a>
                                    </div>
                                    <select name="customerID" id="" class="form-select" required>
                                        <option value="" disabled selected>Select Customer</option>
                                        @forelse ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->first_name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>No data available. Please add a
                                                new customer.</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                    <input type="number" id="" class="form-control" step="0.00"
                                        name="amount" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <a href="javascript:void(0);" class="btn me-2 btn-secondary"
                                    data-bs-dismiss="modal">Cancel</a>
                                <button type="submit" class="btn btn-primary">Add Advance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Category -->


        <!-- Edit Category -->
        <div class="modal fade" id="edit-category">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Edit Advance</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('customer-dues.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="due_id">
                            <input type="hidden" name="type" id='type'>
                            <div class="mb-3">
                                <div class="add-newplus">
                                    <label class="form-label">Customer Name</label>
                                    <a href="{{ route('customer') }}"><i data-feather="plus-circle"
                                            class="plus-down-add"></i><span>Add
                                            New</span></a>
                                </div>
                                <select name="customerID" id="due_customer" class="form-select" required>
                                    <option value="" disabled selected>Select Customer</option>
                                    @forelse ($customers as $customer)
                                        <option value="{{ $customer->id }}">
                                            {{ $customer->first_name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No data available. Please add a
                                            new customer.</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Date<span class="text-danger ms-1">*</span></label>
                                <input type="date" id="due_date" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Amount<span class="text-danger ms-1">*</span></label>
                                <input type="number" id="due_amount" class="form-control" step="0.00"
                                    name="amount" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn me-2 btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- delete modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">
                        <form action="{{ route('customer-dues.destroy') }}" method="POST">
                            @csrf
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                        class="ti ti-trash fs-24 text-danger"></i></span>
                                <input type="text" name="id" id="delete-product-id">
                                <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Product</h4>
                                <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete product?</p>
                                <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes
                                        Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection



    @push('js')
    <script>
            const csrfToken = '{{ csrf_token() }}';
        </script>
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
        <!-- Customize JS for catgeory page -->

        <script>
            $(document).ready(function() {
                $(document).on('click', '.edit-category-btn', function() {
                    const id = $(this).data('id');
                    const customerID = $(this).data('customerid');
                    const date = $(this).data('date');
                    const amount = $(this).data('amount');
                    const type = $(this).data('type');

                    // Fill modal fields
                    $('#due_id').val(id);
                    $('#due_customer').val(customerID.toString()).trigger('change'); // dropdown
                    $('#due_date').val(date); // needs Y-m-d format
                    $('#due_amount').val(amount);
                    $('#type').val(type);

                });

                $(document).on('click', '.delete-advance-btn', function() {
                    const id = $(this).data('id');
                    // Fill modal fields
                    $('#delete-product-id').val(id);
                });

                // ===== Filter Categories by Status =====
                $(document).on('click', '.dropdown-menu .dropdown-category', function() {
                    const status = $(this).data('status');

                    $('#product-loader').show();
                    $('#product-table').addClass('dull');

                    $.ajax({
                        url: '{{ route('customer-dues.filterBy') }}',
                        type: 'POST',
                        data: {
                            status: status,
                            _token: csrfToken
                        },
                        success: function(response) {
                            $('#product-table-body').html(response.html);
                            toastr.info('Review the list of data that have been found.');
                        },
                        error: function() {
                            toastr.error('Failed to load data for this status.');
                        },
                        complete: function() {
                            $('#product-loader').hide();
                            $('#product-table').removeClass('dull');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
