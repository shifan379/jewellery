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
        <!-- Product create CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/product-create.css') }}">


        <style>
            /* sds */
        </style>
    @endpush

    @section('content')

        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Suppliers</h4>
                        <h6>Manage your suppliers</h6>
                    </div>
                </div>

                <ul class="table-top-head">
                    <li>
                        <a id="export-selected-pdf" data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                src="assets/img/icons/pdf.svg" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" id="export-selected" data-bs-placement="top" title="Excel"><img
                                src="assets/img/icons/excel.svg" alt="img"></a>
                    </li>
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-supplier"><i
                            class="ti ti-circle-plus me-1"></i>Add Supplier</a>
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
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3" id="statusFilterDropdown">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1 filter-status"
                                        data-status="1">Active</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1 filter-status"
                                        data-status="0">Inactive</a>
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
                                    <th>Code</th>
                                    <th>Company Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Bank Name</th>
                                    <th>Bank Acc No</th>
                                    <th>Status</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr class="customer-row" data-status="{{ $supplier->status }}">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="row-checkbox" value="{{ $supplier->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>SU001</td>
                                        @php
                                            $image = $supplier->image;
                                            $imageUrl = !empty($image)
                                                ? $image
                                                : asset('assets/img/products/istockphoto.png');
                                        @endphp
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a class="avatar avatar-md me-2">
                                                    <img src="{{ url($imageUrl) }}" alt="product">
                                                </a>
                                                <a>{{ $supplier->company_name }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <a>{{ $supplier->email }}</a>
                                        </td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>{{ $supplier->bank_name }}</td>
                                        <td>{{ $supplier->bank_acc_no }}</td>

                                        <td>
                                           @if ($supplier->status)
                                                <span
                                                    class="d-inline-flex align-items-center p-1 pe-2 rounded-1 text-white bg-success fs-10"><i
                                                        class="ti ti-point-filled me-1 fs-11"></i>Active</span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center p-1 pe-2 rounded-1 text-white bg-danger fs-10"><i
                                                        class="ti ti-point-filled me-1 fs-11"></i>Not Active</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            <div class="edit-delete-action d-flex align-items-center">
                                                <a href="javascript:void(0);"
                                                    class="me-2 p-2 d-flex align-items-center border rounded viewSupplierBtn"
                                                    data-id="{{ $supplier->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#view-supplier">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>

                                                <a class="me-2 p-2 d-flex align-items-center border rounded EditSupplierBtn"
                                                    data-id="{{ $supplier->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#edit-supplier">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>

                                                <a data-bs-toggle="modal" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal"
                                                    class="p-2 d-flex align-items-center border rounded DeleteSupplierBtn"
                                                    data-id="{{ $supplier->id }}" href="javascript:void(0);">
                                                    <i data-feather="trash-2" class="feather-trash-2"></i>
                                                </a>

                                            </div>

                                        </td>
                                    </tr>

                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /product list -->

        </div>

        <!-- Add Supplier -->
        <div class="modal fade" id="add-supplier">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Supplier</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <div class="add-image-upload">
                                        <div class="preview-images d-flex align-items-center add-image">

                                        </div>
                                        <div class="new-employee-field">
                                            <div class="mb-0">
                                                <div class="image-upload mb-2">
                                                    <input type="file" name="image" id="category_image"
                                                        accept=".jpeg, .png, .jpg">
                                                    <div class="image-uploads">
                                                        <h4 class="fs-13 fw-medium">Upload Image</h4>
                                                    </div>
                                                </div>
                                                <span>JPEG, PNG up to 2 MB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Company Name <span
                                                    class="text-danger">*</span> </label>
                                        <input type="text" class="form-control"  name="company_name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email </label>
                                        <input type="email" class="form-control"  name="email">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone </label>
                                        <input type="number" class="form-control" name="phone">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address </label>
                                        <input type="text" class="form-control" name="address">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Name </label>
                                        <input type="text" class="form-control" name="bank_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Acc No </label>
                                        <input type="text" class="form-control" name="bank_acc_no">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div
                                        class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status <span class="text-danger ms-1">*</span></span>
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="checkbox" name="addstatus" id="user1" class="check"
                                                {{ old('addstatus', true) ? 'checked' : '' }}>
                                            <label for="user1" class="checktoggle"></label>
                                            <span id="status-text" class="badge bg-success">Active</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Supplier -->

        {{-- View Supplier --}}

        <div class="modal fade" id="view-supplier">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="content">
                        <div class="modal-header">
                            <div class="page-title">
                                <h4>View Supplier</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="viewSupplierForm" method="GET" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="new-employee-field">
                                        <div class="profile-pic-upload image-field">
                                            <div class="profile-pic p-2">
                                                <img id="viewSupplierImage"
                                                    src="{{ asset('assets/img/users/user-41.jpg') }}"
                                                    class="object-fit-cover h-100 rounded-1" alt="user"  accept=".jpeg, .png, .jpg">

                                                <button type="button" class="close rounded-1">
                                                    <span aria-hidden="false">&times;</span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Company Name: <b class="text-black-50"> &nbsp;
                                                    <span id="viewCompanyName"></span></b> </label>

                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email: <b class="text-black-50"> &nbsp;
                                                    <span id="viewEmail"></span></b> </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Phone: <b class="text-black-50"> &nbsp;
                                                    <span id="viewPhone"></span></b> </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address: <b class="text-black-50"> &nbsp;
                                                    <span id="viewAddress"></span></b> </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label ">Bank Name: <b class="text-black-50"> &nbsp; <span
                                                        id="viewBankName"></span></b>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bank Acc No: <b class="text-black-50"> &nbsp;
                                                    <span id="viewBankAccNo"></span></b> </label>

                                        </div>
                                    </div>
                                    {{--
                                    <div class="col-md-12">
                                        <div class="mb-0">
                                            <div
                                                class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                                <span class="status-label">Status</span>
                                                <input type="checkbox" id="users6" class="check" checked>
                                                <label for="users6" class="checktoggle mb-0"></label>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn me-2 btn-secondary"
                                    data-bs-dismiss="modal">Cancel</button>
                                {{-- <button type="submit" class="btn btn-primary">Save Changes</button> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- /View Supplier --}}

        <!-- Edit Supplier -->
        <div class="modal fade" id="edit-supplier">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="content">
                        <div class="modal-header">
                            <div class="page-title">
                                <h4>Edit Supplier</h4>
                            </div>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="editSupplierForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="new-employee-field">
                                        <div class="profile-pic-upload image-field">
                                            <div class="profile-pic p-2">
                                                <img id="editSupplierImage"
                                                    src="{{ asset('assets/img/users/user-41.jpg') }}"
                                                    class="object-fit-cover h-100 rounded-1" alt="user">
                                            </div>
                                            <div class="mb-3">
                                                <input type="file" name="image" class="form-control"
                                                    id="editSupplierImageFile"  accept=".jpeg, .png, .jpg">
                                                <p class="mt-2">JPEG, PNG up to 2 MB</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Company Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="company_name"
                                                id="editCompanyName">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email </label>
                                            <input type="email" class="form-control" name="email" id="editEmail">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Phone </label>
                                            <input type="number" class="form-control" name="phone" id="editPhone">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Address </label>
                                            <input type="text" class="form-control" name="address" id="editAddress">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bank Name </label>
                                            <input type="text" class="form-control" name="bank_name"
                                                id="editBankName">

                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Bank Acc No </label>
                                            <input type="text" class="form-control" name="bank_acc_no"
                                                id="editBankAccNo">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div
                                            class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                            <span class="status-label">Status </span>
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="checkbox" name="addstatus" id="edit-status-checkbox"
                                                    class="check">
                                                <label for="edit-status-checkbox" class="checktoggle"></label>
                                                <span id="edit-status-text" class="badge">Active</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
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
        </div>
        <!-- /Edit Supplier -->

        <!-- Delete Modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteSupplierForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="page-wrapper-new p-0">
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                                    <i class="ti ti-trash fs-24 text-danger"></i>
                                </span>
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Supplier</h4>
                                <p class="mb-0 fs-16">Are you sure you want to delete this supplier?</p>

                                <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                        data-bs-dismiss="modal">Cancel</button>

                                    <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">
                                        Yes Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Delete Modal -->



    @endsection



    @push('js')
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
        {{-- select function --}}
        <script>
            $('#select-all').on('change', function() {
                $('.row-checkbox').prop('checked', this.checked);
            });
        </script>


        {{-- View Details --}}
        <script>
            $(document).ready(function() {
                $('.viewSupplierBtn').on('click', function() {
                    var supplierId = $(this).data('id');

                    $.ajax({
                        url: '{{ url('/suppliers') }}/' + supplierId,
                        method: 'GET',
                        success: function(response) {
                            $('#viewCompanyName').text(response.company_name);
                            $('#viewEmail').text(response.email);
                            $('#viewPhone').text(response.phone);
                            $('#viewAddress').text(response.address);
                            $('#viewBankName').text(response.bank_name);
                            $('#viewBankAccNo').text(response.bank_acc_no);
                            // $('#viewSta').text(response.province);
                            // Set profile image if available
                            // if (response.image) {
                            //     $('#viewCustomerImage').attr('src', '/storage/customers/' + response
                            //         .image);
                            // } else {
                            //     $('#viewCustomerImage').attr('src',
                            //         '/assets/img/users/user-41.jpg'); // fallback image
                            // }
                            if (response.image) {
                                $('#viewSupplierImage').attr('src', response
                                    .image); // ✅ Already full URL
                            } else {
                                $('#viewSupplierImage').attr('src',
                                    '/assets/img/users/user-41.jpg');
                            }

                        },
                        error: function() {
                            alert('Failed to fetch supplier details');
                        }
                    });
                });
            });
        </script>
        {{-- /View end --}}

        {{-- Edit details --}}
        <script>
            // This will give something like: http://localhost/yourproject/public/customers/
            var routeBase = "{{ route('suppliers.show', ['id' => 'ID_REPLACE']) }}";
        </script>

        <script>
            $(document).ready(function() {
                // Show selected image in preview circle
                $('#editSupplierImageFile').on('change', function(e) {
                    const file = e.target.files[0];

                    // if (!file || !file.type.startsWith('image/')) {
                    //     toastr.error('Only image files are allowed!');
                    //     return;
                    // }
                     if (!file || !file.type.startsWith('image/')) {
                        toastr.error('Only image files (JPEG, PNG, JPG) are allowed!');
                        $(this).val(''); // Clear the invalid file
                        $('#editCustomerImage').attr('src',
                        '/assets/img/users/user-41.jpg'); // Optional fallback preview
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        $('#editSupplierImage').attr('src', evt.target.result);
                    };
                    reader.readAsDataURL(file);
                });

                $('.EditSupplierBtn').on('click', function() {
                    var supplierId = $(this).data('id');

                    // Replace placeholder with actual ID
                    var fetchUrl = routeBase.replace('ID_REPLACE', supplierId);


                    $.ajax({
                        url: fetchUrl,
                        method: 'GET',
                        success: function(response) {
                            // Set values for input fields
                            $('#editCompanyName').val(response.company_name);
                            $('#editEmail').val(response.email);
                            $('#editPhone').val(response.phone);
                            $('#editAddress').val(response.address);
                            $('#editBankName').val(response.bank_name);
                            $('#editBankAccNo').val(response.bank_acc_no);
                            // $('#editCustomerProvince').val(response.province);

                            // Set profile image if available
                            // if (response.image) {
                            //     $('#viewCustomerImage').attr('src', '/storage/customers/' + response
                            //         .image);
                            // } else {
                            //     $('#viewCustomerImage').attr('src',
                            //         '/assets/img/users/user-41.jpg'); // fallback image
                            // }
                            // Set image
                            if (response.image) {
                                $('#editSupplierImage').attr('src', response.image);
                            } else {
                                $('#editSupplierImage').attr('src',
                                    '/assets/img/users/user-41.jpg');
                            }

                            // Update the form action dynamically
                            $('#editSupplierForm').attr('action', fetchUrl);

                            // ===== Status Toggle Setup =====
                            var checkbox = $('#edit-status-checkbox');
                            var statusText = $('#edit-status-text');

                            if (response.status == 1) {
                                checkbox.prop('checked', true);
                                statusText.text('Active').removeClass('bg-danger').addClass(
                                    'bg-success');
                            } else {
                                checkbox.prop('checked', false);
                                statusText.text('Not Active').removeClass('bg-success').addClass(
                                    'bg-danger');
                            }

                        },
                        error: function() {
                            alert('Failed to fetch supplier details');
                        }
                    });
                });

                // Live status badge toggle when checkbox is changed
                $('#edit-status-checkbox').on('change', function() {
                    var statusText = $('#edit-status-text');
                    if ($(this).is(':checked')) {
                        statusText.text('Active').removeClass('bg-danger').addClass('bg-success');
                    } else {
                        statusText.text('Not Active').removeClass('bg-success').addClass('bg-danger');
                    }
                });

            });
        </script>
        {{-- /Edit end --}}


        {{-- Image view for add image --}}

        <script>
            // Single image preview
            $(document).on('change', '.image-upload input[type="file"]', function(e) {
                const file = e.target.files[0]; // Only take the first file
                const $previewArea = $(this).closest('.add-image-upload').find('.preview-images');

                // Clear previous previews
                $previewArea.empty();

                if (!file) return; // No file selected

                if (!file.type.startsWith('image/')) {
                    toastr.error('Only image files are allowed!');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(evt) {
                    const imgHtml = `
            <div class="phone-img uploaded" style="position:relative; display:inline-block; margin:5px;">
                <img src="${evt.target.result}" alt="image" style="max-width:110px; max-height:110px; border-radius:8px; box-shadow:0 2px 8px #eee;">
                <a href="javascript:void(0);" class="remove-product" style="position:absolute;top:5px;right:5px;">
                    <span style="background:#f33;color:#fff;border-radius:50%;padding:2px 6px;font-weight:bold;font-size:16px;line-height:1;">×</span>
                </a>
            </div>
        `;
                    $previewArea.html(imgHtml);
                    if (window.feather) feather.replace();
                };
                reader.readAsDataURL(file);
            });

            // Remove image preview
            $(document).on('click', '.remove-product', function() {
                $(this).closest('.phone-img.uploaded').remove();
            });
        </script>

        {{-- Export  --}}
        <script>
            $(document).ready(function() {
                function submitExportForm(route) {
                    var selectedIds = [];
                    $(".row-checkbox:checked").each(function() {
                        selectedIds.push($(this).val());
                    });

                    if (selectedIds.length === 0) {
                        toastr.warning("Please select at least one supplier to export.");
                        return;
                    }

                    var form = $('<form>', {
                        action: route,
                        method: 'POST'
                    });

                    form.append('@csrf');

                    selectedIds.forEach(function(id) {
                        form.append($('<input>', {
                            type: 'hidden',
                            name: 'ids[]',
                            value: id
                        }));
                    });

                    $('body').append(form);
                    form.submit();
                }

                $("#export-selected").on("click", function() {
                    submitExportForm('{{ route('suppliers.downloadExcel') }}');
                });

                $("#export-selected-pdf").on("click", function() {
                    submitExportForm('{{ route('suppliers.downloadPdf') }}');
                });

            });
        </script>


        {{-- Delete  --}}

        <script>
            // Get the base delete route with a placeholder
            var deleteRoute = "{{ route('suppliers.destroy', ['id' => 'ID_REPLACE']) }}";

            $(document).ready(function() {
                $('.DeleteSupplierBtn').on('click', function() {
                    var supplierId = $(this).data('id');

                    // Replace placeholder with actual ID
                    var finalRoute = deleteRoute.replace('ID_REPLACE', supplierId);

                    // Set the form action
                    $('#deleteSupplierForm').attr('action', finalRoute);
                });
            });
        </script>

        {{-- Add sttaus --}}

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const checkbox = document.getElementById("user1");
                const statusText = document.getElementById("status-text");

                function updateStatus() {
                    if (checkbox.checked) {
                        statusText.textContent = "Active";
                        statusText.classList.remove("bg-danger");
                        statusText.classList.add("bg-success");
                    } else {
                        statusText.textContent = "Not Active";
                        statusText.classList.remove("bg-success");
                        statusText.classList.add("bg-danger");
                    }
                }

                checkbox.addEventListener("change", updateStatus);
                updateStatus(); // Initial set
            });

            $(document).ready(function() {
                // Handle status filter click
                $('.filter-status').on('click', function() {
                    const selectedStatus = $(this).data('status'); // 1 or 0

                    // Hide all customer rows
                    $('.customer-row').hide();

                    // Show only matching status rows
                    $('.customer-row').each(function() {
                        const rowStatus = $(this).data('status'); // from <tr data-status="1">
                        if (rowStatus == selectedStatus) {
                            $(this).show();
                        }
                    });
                });
            });

        </script>
    @endpush
</x-app-layout>
