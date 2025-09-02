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
    @endpush

    @section('content')
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4 class="fw-bold">Create Product</h4>
                        <h6>Create new product</h6>
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
                <div class="page-btn mt-0">
                    <a href="{{ route('product.index') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to Product</a>
                </div>
            </div>
            <form action="{{ route('product.store') }}" method="POST" class="add-product-form"
                enctype="multipart/form-data">
                @csrf
                <div class="add-product">
                    <div class="accordions-items-seperate" id="accordionSpacingExample">
                        <div class="accordion-item border mb-4">
                            <h2 class="accordion-header" id="headingSpacingOne">
                                <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse"
                                    data-bs-target="#SpacingOne" aria-expanded="true" aria-controls="SpacingOne">
                                    <div class="d-flex align-items-center justify-content-between flex-fill">
                                        <h5 class="d-flex align-items-center"><i data-feather="info"
                                                class="text-primary me-2"></i><span>Product Information</span></h5>
                                    </div>
                                </div>
                            </h2>
                            <div id="SpacingOne" class="accordion-collapse collapse show"
                                aria-labelledby="headingSpacingOne">
                                <div class="accordion-body border-top">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-6 col-12">
                                            <div class="mb-3 list position-relative">
                                                <label class="form-label">Code<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input type="text" name="prefix" required
                                                    class="form-control list getCode">
                                            </div>
                                        </div>
                                        <input type="hidden" class="code">

                                        <div class="col-sm-6 col-12">
                                            <div class="mb-3">
                                                <label class="form-label">Product Name<span
                                                        class="text-danger ms-1">*</span></label>
                                                <input name="product_name" required id="product_name" type="text"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="addservice-info">
                                        <div class="row">
                                            <div class="col-sm-6 col-12">
                                                <div class="mb-3">
                                                    <div class="add-newplus">
                                                        <label class="form-label">Category</label>
                                                        <a href="javascript:void(0);" data-bs-toggle="modal"
                                                            data-bs-target="#add-product-category"><i
                                                                data-feather="plus-circle"
                                                                class="plus-down-add"></i><span>Add
                                                                New</span></a>
                                                    </div>
                                                    <select name="category" id="categorySelect" class="form-select">
                                                        <option value="" disabled selected>Select Category</option>
                                                        @forelse ($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                @if (isset($category->set) && $category->set == 1) selected @endif>
                                                                {{ $category->category }}
                                                            </option>
                                                        @empty
                                                            <option value="" disabled>No data available. Please add a
                                                                new category.</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Sub Category</label>
                                                    <select name="sub_category" id="subCategorySelect" class="form-select">
                                                        <option value="">Select</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="add-product-new">
                                            <div class="row">
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <div class="add-newplus">
                                                            <label class="form-label">Unit</label>
                                                        </div>
                                                        <select name="unit" class="form-select">
                                                            <option value="" disabled selected>Select Unit</option>
                                                            @forelse ($units as $unit)
                                                                <option value="{{ $unit->name }}"
                                                                    @if (isset($unit->set) && $unit->set == 1) selected @endif>
                                                                    {{ $unit->name }}</option>
                                                            @empty
                                                                <option value="" disabled>No data available. Please
                                                                    add a new unit.</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Loaction</label>
                                                        <select name="location" class="form-select">
                                                            <option disabled selected value="">Select Loaction
                                                            </option>
                                                            @forelse ($locations as $location)
                                                                <option value="{{ $location->id }} "
                                                                    @if (isset($location->set) && $location->set == 1) selected @endif>
                                                                    {{ $location->name }}</option>
                                                            @empty
                                                                <option value="" disabled>No data available. Please
                                                                    add a new location.</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item border mb-4">
                                <h2 class="accordion-header" id="headingSpacingTwo">
                                    <div class="accordion-button collapsed bg-white" data-bs-toggle="collapse"
                                        data-bs-target="#SpacingTwo" aria-expanded="true" aria-controls="SpacingTwo">
                                        <div class="d-flex align-items-center justify-content-between flex-fill">
                                            <h5 class="d-flex align-items-center"><i data-feather="life-buoy"
                                                    class="text-primary me-2"></i><span>Pricing & Stocks</span></h5>
                                        </div>
                                    </div>
                                </h2>
                                <div id="SpacingTwo" class="accordion-collapse collapse show"
                                    aria-labelledby="headingSpacingTwo">
                                    <div class="accordion-body border-top">

                                        <div class="tab-content" id="pills-tabContent">

                                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab">
                                                <div class="row select-color-add">
                                                    <div class="col-lg-12 col-sm-12 col-12">
                                                        <div class="mb-3">

                                                            <div class="row">
                                                                <div class="col-lg-11 col-sm-11 col-11">
                                                                </div>
                                                                <div class="col-lg-1 col-sm-1 col-1 ps-0">
                                                                    <div class="add-icon tab">
                                                                        <a class="btn btn-filter addRow"><i
                                                                                class="feather feather-plus-circle"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="selected-hide-color" id="input-show">
                                                            <label class="form-label">Variant Attribute <span
                                                                    class="text-danger ms-1">*</span></label>
                                                            <div class="row align-items-center">
                                                                <div class="col-lg-10 col-sm-10 col-10">
                                                                    <div class="mb-3">
                                                                        <input  class="input-tags form-control"
                                                                            id="inputBox" readonly type="text"
                                                                            data-role="tagsinput" name="specialist">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-body-table border" id="variant-table">
                                                    <div class="table-responsive">
                                                        <table class="table border">
                                                            <thead>
                                                                <tr>
                                                                    <th>Barcode Number</th>
                                                                    <th>Quantity</th>
                                                                    <th>Buying Price (Rs)</th>
                                                                    <th>Weight(g)</th>
                                                                    <th>Print</th>
                                                                    <th class="no-sort"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="d-flex align-items-center justify-content-end mb-4">
                            <button type="button" class="btn btn-secondary me-2">Cancel</button>
                            <button type="submit" id="functionKey" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
            </form>
        </div>

        {{-- model --}}
        <!-- Add Category -->
        <div class="modal fade" id="add-product-category">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Category</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Category<span class="ms-1 text-danger">*</span></label>
                        <input name="category" id="category_name" required type="text" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <a href="javascript:void(0);" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                            data-bs-dismiss="modal">Cancel</a>
                        <a href="javascript:void(0);" id="submitCategory"
                            class="btn btn-primary text-white fs-13 fw-medium p-2 px-3">Add Category</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add Category -->

    @endsection



    @push('js')
        <script>
            const routes = {
                nextItemCode: @json(route('products.nextItemCode')),
                categoriesStore: @json(route('categories.store')),
                variantsStore: @json(route('variants.store')),
                subData: @json(route('get.sub.data')),
                generateAiImage: @json(route('products.generateAiImage')),

            };
            const csrfToken = '{{ csrf_token() }}';
        </script>

        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>


        <script src="{{ asset('assets/js/product-create.js') }}" type="text/javascript"></script>

        <script>
            $(document).ready(function() {
                $(document).on('click', '.print-lable', function() {
                    var row = $(this).closest('tr');
                    var itemCode = row.find('input[name="mark[]"]').val();
                    var productName = $('input[name="product_name"]').val();
                    var weight = row.find('input[name="weight[]"]').val();

                    var url = '{{ route('barcode.print') }}'; // Laravel POST route

                    // Create form dynamically
                    var form = $('<form>', {
                        action: url,
                        method: 'POST',
                        target: '_blank'
                    }).append($('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: $('meta[name="csrf-token"]').attr('content')
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'item_code',
                        value: itemCode
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'product_name',
                        value: productName
                    })).append($('<input>', {
                        type: 'hidden',
                        name: 'weight',
                        value: weight
                    }));

                    form.appendTo('body').submit().remove();
                });
            });
        </script>
    @endpush
</x-app-layout>
