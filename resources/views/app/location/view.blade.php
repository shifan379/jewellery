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
                        <h4>Location</h4>
                        <h6>Manage your Location</h6>
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-warehouse"><i
                            class="ti ti-circle-plus me-1"></i>Add Location</a>
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
                                    <th>Location</th>
                                    <th>Contact Person</th>
                                    <th>Phone</th>
                                    <th>Products Count</th>
                                    <th>status</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($locations as $loc)
                                    <tr class="location-row" data-status="{{ $loc->status }}">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="row-checkbox" value="{{ $loc->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td class="text-gray-9">{{ $loc->name }} </td>

                                        <td>{{ $loc->contact_person }}
                                        </td>

                                        <td>
                                            {{ $loc->phone }}
                                        </td>
                                        <td>{{ $loc->products->count()  }}</td>

                                        <td>
                                            @if ($loc->status)
                                                <span
                                                    class="d-inline-flex align-items-center p-1 pe-2 rounded-1 text-white bg-success fs-10"><i
                                                        class="ti ti-point-filled me-1 fs-11"></i>Active</span>
                                            @else
                                                <span
                                                    class="d-inline-flex align-items-center p-1 pe-2 rounded-1 text-white bg-danger fs-10"><i
                                                        class="ti ti-point-filled me-1 fs-11"></i>Inactive</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            <div class="edit-delete-action d-flex align-items-center">
                                                <a href="javascript:void(0);"
                                                    class="me-2 p-2 d-flex align-items-center border rounded viewLocationBtn"
                                                    data-id="{{ $loc->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#view-warehouse">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>

                                                <a class="me-2 p-2 d-flex align-items-center border rounded EditLocationBtn"
                                                    data-id="{{ $loc->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#edit-warehouse">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>

                                                <a data-bs-toggle="modal" data-bs-toggle="modal"
                                                    data-bs-target="#delete-modal"
                                                    class="p-2 d-flex align-items-center border rounded DeleteLocationBtn"
                                                    data-id="{{ $loc->id }}" href="javascript:void(0);">
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


        <!-- Add Warehouse -->
        <div class="modal fade" id="add-warehouse">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Location</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('location.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Location <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Person <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="contact_person" required>
                                            <option value="">Select</option>
                                            <option value="Steven">Steven</option>
                                            <option value="Gravely">Gravely</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label">Email <span class="text-danger">*</span></label>
										<input type="email" class="form-control">
									</div>
								</div>								 --}}
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="phone" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div
                                        class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status </span>
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
                            <button type="submit" class="btn btn-primary">Add Location</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Warehouse -->

        <!-- View Warehouse -->
        <div class="modal fade" id="view-warehouse">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>View Location</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="viewLocationForm" method="GET" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Location: <span id="viewLocation"></span></label>

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Person: <span id="viewContactPerson"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone: <span id="viewPhone"></span> </label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Product Count: <span id="viewProductCount"></span>
                                        </label>
                                    </div>
                                </div>

                                {{-- <div class="col-md-12">
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
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /View Warehouse -->


        <!-- Edit Warehouse -->
        <div class="modal fade" id="edit-warehouse">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Edit Location</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editLocationForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Location <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" id="editLocation">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact Person <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="contact_person" id="editContactPerson">
                                            <option value="">Select</option>
                                            <option value="Steven">Steven</option>
                                            <option value="Gravely">Gravely</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="phone" id="editPhone">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div
                                        class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                        <span class="status-label">Status <span class="text-danger ms-1">*</span></span>
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
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Edit Warehouse -->

        <!-- Delete Modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-5">
                    <form id="deleteLocationForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="page-wrapper-new p-0">
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2">
                                    <i class="ti ti-trash fs-24 text-danger"></i>
                                </span>
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Location</h4>
                                <p class="mb-0 fs-16">Are you sure you want to delete this Location?</p>

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
                $('.viewLocationBtn').on('click', function() {
                    var locationId = $(this).data('id');

                    $.ajax({
                        url: '{{ url('/location') }}/' + locationId,
                        method: 'GET',
                        success: function(response) {
                            $('#viewLocation').text(response.name);
                            $('#viewContactPerson').text(response.contact_person);
                            $('#viewPhone').text(response.phone);
                            $('#viewProductCount').text(response.product_count);


                            // if (response.image) {
                            //     $('#viewCustomerImage').attr('src', response
                            //         .image); // ✅ Already full URL
                            // } else {
                            //     $('#viewCustomerImage').attr('src',
                            //         '/assets/img/users/user-41.jpg');
                            // }

                        },
                        error: function() {
                            alert('Failed to fetch Location details');
                        }
                    });
                });
            });
        </script>
        {{-- /View end --}}

        {{-- Edit details --}}

        <script>
            // Define route base for fetching customer
            var routeBase = "{{ route('location.show', ['id' => 'ID_REPLACE']) }}";

            $(document).ready(function() {


                $('.EditLocationBtn').on('click', function() {
                    var locationId = $(this).data('id');
                    var fetchUrl = routeBase.replace('ID_REPLACE', locationId);

                    $.ajax({
                        url: fetchUrl,
                        method: 'GET',
                        success: function(response) {
                            // Set values for form fields
                            $('#editLocation').val(response.name);
                            $('#editContactPerson').val(response.contact_person);
                            $('#editPhone').val(response.phone);




                            // Set the form action dynamically
                            // $('#editCustomerForm').attr('action', '/customers/' + customerId);
                            $('#editLocationForm').attr('action', fetchUrl);
                            // ===== Status Toggle Setup =====
                            var checkbox = $('#edit-status-checkbox');
                            var statusText = $('#edit-status-text');

                            if (response.status == 1) {
                                checkbox.prop('checked', true);
                                statusText.text('Active').removeClass('bg-danger').addClass(
                                    'bg-success');
                            } else {
                                checkbox.prop('checked', false);
                                statusText.text('Inactive').removeClass('bg-success').addClass(
                                    'bg-danger');
                            }
                        },
                        error: function() {
                            alert('Failed to fetch Location details');
                        }
                    });
                });

                // Live status badge toggle when checkbox is changed
                $('#edit-status-checkbox').on('change', function() {
                    var statusText = $('#edit-status-text');
                    if ($(this).is(':checked')) {
                        statusText.text('Active').removeClass('bg-danger').addClass('bg-success');
                    } else {
                        statusText.text('Inactive').removeClass('bg-success').addClass('bg-danger');
                    }
                });
            });
        </script>


        {{-- /Edit end --}}


        {{-- Export  --}}
        <script>
            $(document).ready(function() {
                function submitExportForm(route) {
                    var selectedIds = [];
                    $(".row-checkbox:checked").each(function() {
                        selectedIds.push($(this).val());
                    });

                    if (selectedIds.length === 0) {
                        toastr.warning("Please select at least one location to export.");
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
                    submitExportForm('{{ route('location.downloadExcel') }}');
                });

                $("#export-selected-pdf").on("click", function() {
                    submitExportForm('{{ route('location.downloadPdf') }}');
                });

            });
        </script>


        {{-- Delete  --}}

        <script>
            // Get the base delete route with a placeholder
            var deleteRoute = "{{ route('location.destroy', ['id' => 'ID_REPLACE']) }}";

            $(document).ready(function() {
                $('.DeleteLocationBtn').on('click', function() {
                    var locationId = $(this).data('id');

                    // Replace placeholder with actual ID
                    var finalRoute = deleteRoute.replace('ID_REPLACE', locationId);

                    // Set the form action
                    $('#deleteLocationForm').attr('action', finalRoute);
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
                        statusText.textContent = "Inactive";
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
                    $('.location-row').hide();

                    // Show only matching status rows
                    $('.location-row').each(function() {
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
