<x-app-layout>
    @section('title', 'Brand List')

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
                        <h4 class="fw-bold">Brand</h4>
                        <h6>Manage your brands</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    {{-- <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg"
                                alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                src="assets/img/icons/excel.svg" alt="img"></a>
                    </li> --}}

                    <li>
                        <a href="{{ url()->current() }}"  data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                class="ti ti-refresh"></i></a>
                    </li>

                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>

                </ul>

                <div class="page-btn">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-brand"><i
                            class="ti ti-circle-plus me-1"></i>Add Brand</a>
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
                        {{-- <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Sort By : Latest
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Latest</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a>
                                </li>
                            </ul>
                        </div> --}}
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
                                    <th>Brand</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $brand)
                                    <tr class="brand-row" data-status="{{ $brand->status }}">
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        @php
                                            $image = $brand->image;
                                            $imageUrl = !empty($image)
                                                ? $image
                                                : asset('assets/img/products/istockphoto.png');
                                        @endphp
                                        <td>


                                            <div class="d-flex align-items-center">
                                                <a class="avatar avatar-md me-2">
                                                    <img src="{{ url($imageUrl) }}" alt="product">
                                                </a>
                                                <a>{{ $brand->name }}</a>
                                            </div>
                                        </td>

                                        <td>{{ $brand->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($brand->status)
                                                <span class="badge table-badge bg-success fw-medium fs-10">Active</span>
                                            @else
                                                <span class="badge table-badge bg-danger fw-medium fs-10">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="action-table-data">
                                            <div class="edit-delete-action">
                                                <a href="javascript:void(0);" class="me-2 p-2 EditBrandBtn"
                                                    data-id="{{ $brand->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#edit-brand">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>

                                                <a data-bs-toggle="modal" data-bs-target="#delete-brand"
                                                    class="p-2 deleteBrandBtn" data-id="{{ $brand->id }}"
                                                    href="javascript:void(0);">
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

        <!-- Add Brand -->
        <div class="modal fade" id="add-brand" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addBrandLabel">Add Brand</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body new-employee-field">
                            <div class="profile-pic-upload mb-3">
                                <div class="profile-pic brand-pic">
                                    <div class="preview-images d-flex align-items-center add-image">
                                        <span><i data-feather="plus-circle" class="plus-down-add"></i> Add Image</span>

                                    </div>
                                </div>
                                <div>
                                    <div class="image-upload mb-0">
                                        <input type="file" name="image" accept="image/*" >
                                        <div class="image-uploads">
                                            <h4>Upload Image</h4>
                                        </div>
                                    </div>
                                    <p class="mt-2">JPEG, PNG up to 2 MB</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Brand<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="mb-0">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input type="checkbox" id="user2" name="status" class="check" checked="">
                                    <label for="user2" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Add Brand -->

        <!-- Edit Brand Modal for brand id -->
        <div class="modal fade" id="edit-brand" tabindex="-1" aria-labelledby="editBrandLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="editBrandLabel">Edit Brand</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-body new-employee-field">
                            <div class="profile-pic-upload mb-3">
                                <div class="profile-pic brand-pic position-relative" id="edit-brand-image-container">
                                    <!-- Image or placeholder inserted dynamically -->
                                    <img id="editBrandImage" src="{{ asset('assets/img/brand/apple.png') }}"
                                        class="object-fit-cover h-100 rounded-1" alt="user">
                                    {{-- <span><i data-feather="plus-circle" class="plus-down-add"></i> Add Image</span> --}}
                                </div>
                                <div>
                                    <div class="image-upload mb-0">
                                        <input type="file" name="image" accept="image/*" id="editBrandImageFile">
                                        <div class="image-uploads">
                                            <h4>Change Image</h4>
                                        </div>
                                    </div>
                                    <p class="mt-2">JPEG, PNG up to 2 MB</p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Brand<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="name" class="form-control" id="editBrandName" required>
                            </div>
                            <div class="mb-0">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status </span>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="checkbox" name="status" id="edit-status-checkbox" class="check"
                                            value="1">
                                        <label for="edit-status-checkbox" class="checktoggle"></label>
                                        <span id="edit-status-text" class="badge">Active</span>
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

        <!-- Edit Brand -->

        <!-- Edit Brand -->

        <!-- delete modal -->
        <div class="modal fade" id="delete-brand">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="page-wrapper-new p-0">

                        <form  method="POST" id="deleteBrandForm">

                            @csrf
                            @method('DELETE')
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                        class="ti ti-trash fs-24 text-danger"></i></span>
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Brand</h4>
                                <p class="mb-0 fs-16">Are you sure you want to delete brand?</p>
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
            // This will give something like: http://localhost/yourproject/public/customers/
            // var routeBase = "{{ route('brand.show', ['id' => 'ID_REPLACE']) }}";
            var fetchRouteBase = "{{ route('brand.show', ['id' => 'ID_REPLACE']) }}"; // For AJAX GET
            var updateRouteBase = "{{ route('brand.update', ['id' => 'ID_REPLACE']) }}"; // For form action
        </script>

        <script>
            $(document).ready(function() {
                // Show selected image in preview circle
                $('#editBrandImageFile').on('change', function(e) {
                    const file = e.target.files[0];

                    // if (!file || !file.type.startsWith('image/')) {
                    //     toastr.error('Only image files are allowed!');
                    //     return;
                    // }
                    if (!file || !file.type.startsWith('image/')) {
                        toastr.error('Only image files (JPEG, PNG, JPG) are allowed!');
                        $(this).val(''); // Clear the invalid file
                        $('#editBrandImage').attr('src',
                            '/assets/img/brand/apple.jpg'); // Optional fallback preview
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        $('#editBrandImage').attr('src', evt.target.result);
                    };
                    reader.readAsDataURL(file);
                });

                $('.EditBrandBtn').on('click', function() {
                    var brandId = $(this).data('id');

                    // Replace placeholder with actual ID
                    // var fetchUrl = routeBase.replace('ID_REPLACE', brandId);
                    var fetchUrl = fetchRouteBase.replace('ID_REPLACE', brandId);
                    var updateUrl = updateRouteBase.replace('ID_REPLACE', brandId);


                    $.ajax({
                        url: fetchUrl,
                        method: 'GET',
                        success: function(response) {
                            // Set values for input fields
                            $('#editBrandName').val(response.name);

                            // Set image
                            if (response.image) {
                                $('#editBrandImage').attr('src', response.image);
                            } else {
                                $('#editBrandImage').attr('src',
                                    '/assets/img/users/user-41.jpg');
                            }

                            // Update the form action dynamically
                            $('#editBrandForm').attr('action', updateUrl);

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


        <script>
            // Single image preview
            $(document).on('change', '.image-upload input[type="file"]', function(e) {
                const file = e.target.files[0]; // Only take the first file
                const $previewArea = $(this).closest('.profile-pic-upload').find('.preview-images');

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


        {{-- Delete --}}
        <script>
            $(document).on('click', '.deleteBrandBtn', function() {
                var brandId = $(this).data('id');
                var deleteUrl = "{{ route('brands.destroy', ':id') }}".replace(':id', brandId);
                $('#deleteBrandForm').attr('action', deleteUrl);
            });
        </script>


        {{-- Filter --}}

        <script>
            $(document).ready(function() {
                // Handle status filter click
                $('.filter-status').on('click', function() {
                    const selectedStatus = $(this).data('status'); // 1 or 0

                    // Hide all brand rows
                    $('.brand-row').hide();

                    // Show only matching status rows
                    $('.brand-row').each(function() {
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
