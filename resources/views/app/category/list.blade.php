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
                        <h4 class="fw-bold">Category</h4>
                        <h6>Manage your categories</h6>
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
                            class="ti ti-circle-plus me-1"></i>Add Category</a>



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
                                    <a href="javascript:void(0);" data-status="1"
                                        class="dropdown-category dropdown-item rounded-1">Active</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" data-status="0"
                                        class=" dropdown-category dropdown-item rounded-1">Inactive</a>
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

                                        <th>Category </th>
                                        <th>Unit</th>
                                        <th>Created On</th>
                                        <th>Status</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body" class="">

                                    @include('app.category.table')
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
                            <h4>Add Category</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="category_name" id="category_name" class="form-control">
                            </div>
                            <div class="mb-0">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status<span class="text-danger ms-1">*</span></span>
                                    <input type="checkbox" name="addstatus" id="user2" class="check"
                                        checked="">
                                    <label for="user2" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="javascript:void(0);" class="btn me-2 btn-secondary"
                                data-bs-dismiss="modal">Cancel</a>
                            <a href="javascript:void(0);" id="submitCategory" class="btn btn-primary">Add Category</a>
                        </div>
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
                            <h4>Edit Category</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('category.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">

                            <div class="mb-3">
                                <input type="hidden" name="id" id="edit_category_id">
                                <label class="form-label">Category<span class="text-danger ms-1">*</span></label>
                                <input type="text" class="form-control" id="edit_category_name" name="category">
                            </div>

                            <div class="mb-0">
                                <input type="hidden" id="edit_category_status">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status<span class="text-danger ms-1">*</span></span>
                                    <input name="status" type="checkbox" id="user3" class="check">
                                    <label for="user3" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit"  class="btn btn-primary">Save Changes</button>
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
                        <form action="{{ route('category.destroy') }}" method="POST">
                            @csrf
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                        class="ti ti-trash fs-24 text-danger"></i></span>
                                <input type="hidden" name="id" id="delete-product-id">
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
            const routes = {
                categoriesStore: @json(route('categories.store')),
                categoriesUpdate: @json(route('category.update')),
                categoriesFilter: @json(route('category.filterByStatus')),
            };
            const csrfToken = '{{ csrf_token() }}';
        </script>
        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
        <!-- Customize JS for catgeory page -->
        <script src="{{ asset('assets/js/category.js') }}" type="text/javascript"></script>

        <script>
            // Single image preview
            $(document).on('change', '.image-upload-two input[type="file"]', function(e) {
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
    @endpush
</x-app-layout>
