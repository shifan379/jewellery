<x-app-layout>
    @section('title', 'Category')

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
                        <h4 class="fw-bold">Sub Category</h4>
                        <h6>Manage your sub categories</h6>
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category"><i
                            class="ti ti-circle-plus me-1"></i>Add Sub Category</a>
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
                                Category
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                @forelse ($categories as $cat)
                                    <li>
                                        <a href="javascript:void(0);" data-category="{{ $cat->id }}"
                                            class="dropdown-item dropdown-category rounded-1">{{ $cat->category }}</a>
                                    </li>
                                @empty
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Categories not
                                            available</a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" data-status="1"
                                        class="dropdown-status dropdown-item rounded-1">Active</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-status="0"
                                        class=" dropdown-status dropdown-item rounded-1">Inactive</a>
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
											<th>Sub Category</th>
											<th>Category</th>
											<th>Status</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body" class="">
                                    @include('app.subcategory.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->
        </div>

        {{-- model --}}
        <!-- Add Category -->
        <div class="modal fade" id="add-category">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Sub Category</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sub-categories.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                <Select required name="cat_id" class="form-select">
                                    <option value="" disabled selected>Select Category</option>
                                    @forelse ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                    @empty
                                        <option value="" disabled>Data Not Found</option>
                                    @endforelse
                                </Select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sub Category<span class="text-danger ms-1">*</span></label>
                                <input type="text" required name="subcategory" class="form-control">
                            </div>
                            <div class="mb-0">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input name="status" type="checkbox" id="user2" class="check" checked="">
                                    <label for="user2" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Sub Category</button>
                        </div>
                    </form>
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
                            <h4>Edit Sub Category</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sub-categories.update') }}" method="POST" >
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id"  id="edit_sub_id">
                            <div class="mb-3">
                                <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                <Select required name="cat_id" id="edit_category_name" class="form-select">
                                    <option value="" disabled selected>Select Category</option>
                                    @forelse ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category }}</option>
                                    @empty
                                        <option value="" disabled>Data Not Found</option>
                                    @endforelse
                                </Select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sub Category<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" required id="edit_subcategory" name="subcategory">
                            </div>

                            <div class="mb-0">
                                 <input type="hidden" id="sub_edit_category_status">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input type="checkbox" name="status" id="user3" class="check" checked="">
                                    <label for="user3" class="checktoggle"></label>
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
        <!-- /Edit Category -->
        <!-- delete modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('subCategories.destroy') }}" method="POST">
                        @csrf
                        <div class="page-wrapper-new p-0">
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                        class="ti ti-trash fs-24 text-danger"></i></span>
                                        <input type="hidden" name="id" id="delete-product-id">
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Sub Category</h4>
                                <p class="mb-0 fs-16">Are you sure you want to delete sub category?</p>
                                <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                    <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes
                                        Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    @endsection





    @push('js')
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>

        <script>
            const routes = {
                categoriesStore: @json(route('categories.store')),
                categoriesUpdate: @json(route('category.update')),
            };
            const csrfToken = '{{ csrf_token() }}';
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editButtons = document.querySelectorAll('.edit-sub-category-btn');
                editButtons.forEach(btn => {
                    btn.addEventListener('click', function() {

                        const id = $(this).data('id');
                        const name = $(this).data('name');
                        const category = $(this).data('category-name');
                        const category_id = $(this).data('category-id');
                        const status = $(this).data('status');

                        // Fill modal fields
                        document.getElementById('edit_sub_id').value = id;
                        document.getElementById('edit_subcategory').value = name;
                        document.getElementById('sub_edit_category_status').value = status;

                        // Set the category dropdown selected value
                        const select = $('#edit_category_name');

                        // First remove any existing selected option with that value
                        select.find('option').removeAttr('selected');

                        // Set if option exists
                        if (select.find(`option[value="${category_id}"]`).length) {
                            select.val(category_id);
                        } else {
                            // Add the option dynamically if not exists
                            select.append(`<option value="${category_id}" selected>${category_name}</option>`);
                        }
                        // Set checkbox state
                        const checkbox = document.getElementById('user3');
                        checkbox.checked = (status == 1);

                        // Also set the hidden input value
                        const hiddenInput = document.getElementById('sub_edit_category_status');
                        hiddenInput.value = status;

                        // When user changes the checkbox, update hidden input value
                        checkbox.addEventListener('change', function() {
                            hiddenInput.value = this.checked ? 1 : 0;
                        });
                    });
                });
            });
        </script>


        <script>
            $(document).on('click', '.dropdown-menu .dropdown-category', function() {
                // Get the status from the clicked item
                const id = $(this).data('category');
                // Show loader and dull table
                $('#product-loader').show();
                $('#product-table').addClass('dull');

                $.ajax({
                    url: '{{ route('subCategory.filterByCategory') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#product-table-body').html(response.html);
                        toastr.info('Review the list of categories that have been found.');
                    },
                    error: function() {
                        toastr.error('Failed to load categories for this status.');
                    },
                    complete: function() {
                        // Hide loader and restore table
                        $('#product-loader').hide();
                        $('#product-table').removeClass('dull');
                    }
                });
            });
        </script>

        <script>
            $(document).on('click', '.dropdown-menu .dropdown-status', function() {
                // Get the status from the clicked item
                const status = $(this).data('status');
                // Show loader and dull table
                $('#product-loader').show();
                $('#product-table').addClass('dull');

                $.ajax({
                    url: '{{ route('subCategory.filterByStatus') }}',
                    type: 'POST',
                    data: {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#product-table-body').html(response.html);
                        toastr.info('Review the list of categories that have been found.');
                    },
                    error: function() {
                        toastr.error('Failed to load categories for this status.');
                    },
                    complete: function() {
                        // Hide loader and restore table
                        $('#product-loader').hide();
                        $('#product-table').removeClass('dull');
                    }
                });
            });
        </script>
        <script>
            $(function() {
                let deleteProductId = null;
                // When delete button is clicked, set the product ID
                $(document).on('click', '.delete-product-btn', function() {
                    deleteProductId = $(this).data('id');
                    $('#delete-product-id').val(deleteProductId);
                });

            });
        </script>

    @endpush
</x-app-layout>
