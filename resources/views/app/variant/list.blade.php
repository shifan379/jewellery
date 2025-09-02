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
                        <h4 class="fw-bold">Variant Attributes</h4>
                        <h6>Manage your variant attributes</h6>
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-variant"><i
                            class="ti ti-circle-plus me-1"></i>Add Variant</a>
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
                    {{-- <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">

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
                    </div> --}}
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
                                        <th>Variant</th>
                                        <th>Values</th>
                                        <th>Created at</th>
                                        <th>Status</th>
                                        <th class="no-sort"></th>
                                    </tr>
                                </thead>
                                <tbody id="product-table-body" class="">
                                    @forelse ($variants as $variant)
                                        <tr>
                                            <td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </td>
                                            <td><span class="text-gray-9">{{ $variant->name }}</span></td>
                                            <td><span class="text-gray-9">{{ implode(', ', json_decode($variant->values, true)) }}</span></td>
                                            <td>{{ $variant->created_at->format('F j, Y') }}</td>
                                            <td>
                                                <span class="badge table-badge  {{ $variant->status == 1 ? 'bg-success' : 'bg-info' }} fw-medium fs-10">
                                                    {{ $variant->status == 1 ? 'Active' : 'Deactivate' }}
                                                </span>
                                            </td>
                                            <td class="action-table-data">
                                                <div class="edit-delete-action">

                                                    <a data-bs-toggle="modal" class="delete-product-btn"
                                                        data-id="{{ $variant->id }}" data-bs-target="#delete-modal"
                                                        class="p-2" href="javascript:void(0);">
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
            </div>
            <!-- /product list -->
        </div>

        {{-- model --}}
        <!-- Add Unit -->
        <div class="modal fade" id="add-variant">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Variant</h4>
                        </div>
                        <button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Variant<span class="text-danger ms-1">*</span></label>
                                <input type="text" name="variant_name" id="variant_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Values<span class="text-danger ms-1">*</span></label>
                                <input class="fs-14 bg-secondary-transparent" type="text" data-role="tagsinput"
                                    name="variant_value" id="variant_value" value="">
                                <span class="tag-text mt-2 d-flex">Enter value separated by comma</span>
                            </div>
                            <div class="mb-0 mt-4">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
                                    <span class="status-label">Status</span>
                                    <input name="status" type="checkbox" id="user2" class="check create_status" checked="">
                                    <label for="user2" class="checktoggle"></label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="submitVariant" class="btn btn-primary">Add Variant</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Unit -->


        <!-- delete modal -->
        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('variant.destroy') }}" method="POST">
                        @csrf
                        <div class="page-wrapper-new p-0">
                            <div class="content p-5 px-3 text-center">
                                <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                        class="ti ti-trash fs-24 text-danger"></i></span>
                                <h4 class="fs-20 fw-bold mb-2 mt-1">Delete Sub Category</h4>
                                <input type="hidden" name="id" id="delete-product-id">
                                <p class="mb-0 fs-16">Are you sure you want to delete sub category?</p>
                                <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                    <button type="button"
                                        class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
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
            // Save Variant
            $('#submitVariant').on('click', function() {
                var $btn = $(this);
                var variant = $('#variant_name').val();
                var variantValue = $('#variant_value').val();
                var status = $('.create_status').is(':checked') ? 1 : 0;


                if (!variant) {
                    toastr.warning('Please enter a variant name.');
                    return;
                }
                if (!variantValue) {
                    toastr.warning('Please enter a variant value.');
                    return;
                }
                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Saving...');
                var variantValueArray = variantValue.split(',').map(function(item) {
                    return item.trim();
                }).filter(Boolean);

                $.ajax({
                    url: "{{ route('variants.store') }}",
                    type: 'POST',
                    data: {
                        variant: variant,
                        variantValue: variantValueArray,
                        status: status,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        toastr.success('Variant added!');
                        location.reload();

                    },
                    error: function(xhr) {
                        toastr.error('Error adding variant.');
                        $btn.prop('disabled', false).html('Try Again');
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
