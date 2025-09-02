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
                        <h4>Stock Transfer</h4>
                        <h6>Manage your stock transfer</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    {{-- <!-- PDF -->
                    <li>
                        <a href="{{ route('stock-transfers.export.pdf') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Pdf">
                            <img src="assets/img/icons/pdf.svg" alt="PDF">
                        </a>
                    </li>

                    <!-- Excel -->
                    <li>
                        <a href="{{ route('stock-transfers.export.excel') }}" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Excel">
                            <img src="assets/img/icons/excel.svg" alt="Excel">
                        </a>
                    </li> --}}
                    <form id="exportForm" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="selected_ids" id="selected_ids">
                    </form>

                    <li>
                        <a href="#" onclick="event.preventDefault(); submitExport('pdf')" data-bs-toggle="tooltip"
                            title="PDF">
                            <img src="assets/img/icons/pdf.svg" alt="PDF">
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); submitExport('excel')" data-bs-toggle="tooltip"
                            title="Excel">
                            <img src="assets/img/icons/excel.svg" alt="Excel">
                        </a>
                    </li>


                    <!-- Refresh -->
                    <li>
                        <a href="{{ route('stock.transfer') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-stock-transfer"><i
                            class="ti ti-circle-plus me-1"></i>Add New</a>
                </div>
                <div class="page-btn import">
                    <a href="#" class="btn btn-secondary color" data-bs-toggle="modal" data-bs-target="#view-notes"><i
                            data-feather="download" class="me-1"></i>Import Transfer</a>
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
                    <form id="filterForm" method="GET" action="{{ route(name: 'stock.transfer') }}">
                        <input type="hidden" name="from_location_id" id="from_location_idInput">
                        <input type="hidden" name="to_location_id" id="to_location_idInput">
                        <input type="hidden" name="sort_by" id="sort_byInput">

                        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                            <!-- From Warehouse Dropdown -->
                            <div class="dropdown me-2">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">From Warehouse</a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    @foreach ($locations as $location)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="applyFilter('from_location_id', {{ $location->id }})">
                                                {{ $location->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- To Warehouse Dropdown -->
                            <div class="dropdown me-2">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">To Warehouse</a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    @foreach ($locations as $location)
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                onclick="applyFilter('to_location_id', {{ $location->id }})">
                                                {{ $location->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Sort Dropdown -->
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">Sort By</a>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li><a href="javascript:void(0);" class="dropdown-item"
                                            onclick="applyFilter('sort_by', 'recent')">Recently Added</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item"
                                            onclick="applyFilter('sort_by', 'asc')">Ascending</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item"
                                            onclick="applyFilter('sort_by', 'desc')">Descending</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item"
                                            onclick="applyFilter('sort_by', 'last_7')">Last 7 Days</a></li>
                                    <li><a href="javascript:void(0);" class="dropdown-item"
                                            onclick="applyFilter('sort_by', 'last_month')">Last Month</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>

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

                                    <th>From Warehouse</th>
                                    <th>To Warehouse</th>
                                    <th>Name of Products</th>
                                    <th>Responsible Person</th>
                                    <th>Quantity Transferred</th>
                                    <th>Ref Number</th>
                                    <th>Date</th>
                                    <th class="no-sort"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stockTransfers as $transfer)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="row-checkbox" value="{{ $transfer->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>

                                        <td>{{ $transfer->fromLocation->name ?? 'N/A' }}</td>
                                        <td>{{ $transfer->toLocation->name ?? 'N/A' }}</td>
                                        <td>{{ $transfer->product->product_name ?? 'N/A' }}</td>
                                        <td>{{ $transfer->responsible_person ?? 'N/A' }}</td>
                                        <td>{{ $transfer->stock_quantity }}</td>
                                        <td>{{ $transfer->ref_number ?? '-' }}</td>
                                        <td>{{ $transfer->created_at->format('d M Y') }}</td>
                                        <td class="d-flex">
                                            <div
                                                class="edit-delete-action d-flex align-items-center justify-content-center">
                                                {{-- Uncomment when edit is ready
                    <a class="me-2 p-2 d-flex align-items-center justify-content-between border rounded"
                       href="#" data-bs-toggle="modal" data-bs-target="#edit-stock-transfer">
                        <i data-feather="edit" class="feather-edit"></i>
                    </a>
                    --}}
                                                <a class="p-2 d-flex align-items-center justify-content-between border rounded"
                                                    href="javascript:void(0);" data-bs-toggle="modal"
                                                    onclick="openDeleteModal({{ $transfer->id }})"
                                                    data-bs-target="#delete">
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


        <!-- Add Stock -->
        {{-- <div class="modal fade" id="add-stock-transfer">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="page-title">
							<h4>Add Transfer</h4>
						</div>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="{{ route('stock-transfer.store') }}" method="POST">
						@csrf
						<div class="modal-body">
							<div class="row">
                                <div class="col-lg-12">
									<div class="search-form mb-3">
										<label class="form-label">Product<span class="text-danger ms-1">*</span></label>
										<div class="position-relative">
											<input type="text" class="form-control" name="product_id" placeholder="Search Product">
											<i data-feather="search" class="feather-search"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Warehouse From <span class="text-danger ms-1">*</span></label>
										<select class="form-select" name="from_location_id">
											<option>Select</option>
											<option>Lobar Handy</option>
											<option>Quaint Warehouse</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Warehouse To <span class="text-danger ms-1">*</span></label>
										<select class="form-select" name="to_location_id">
											<option>Select</option>
											<option>Selosy</option>
											<option>Logerro</option>
										</select>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label">Reference Number <span class="text-danger ms-1">*</span></label>
										<input type="text" name="ref_number" class="form-control">
									</div>
								</div>

								<div class="col-lg-12">
									<div class="search-form mb-0">
										<label class="form-label">Notes <span class="text-danger ms-1">*</span></label>
										<textarea class="form-control" name="notes"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</form>
				</div>
			</div>
		</div> --}}

        <div class="modal fade" id="add-stock-transfer">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Transfer</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('stock-transfer.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                {{-- Product Search --}}
                                <div class="col-lg-12">
                                    <div class="search-form mb-3">
                                        <label class="form-label">Product <span class="text-danger ms-1">*</span></label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control" id="productSearch"
                                                placeholder="Search Product">
                                            <input type="hidden" name="product_id" id="product_id">
                                            <ul id="productSuggestions" class="list-group position-absolute w-100"
                                                style="z-index: 1000;"></ul>
                                            <i data-feather="search" class="feather-search"></i>
                                        </div>
                                    </div>
                                    <div id="stockInfo" class="text-muted small"></div>
                                </div>
                                {{-- Product Search --}}

                                <div id="stockInfo" class="mt-2 text-muted small"></div>
                            </div>

                            <div class="row">

                                {{-- From Warehouse --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Warehouse From <span
                                                class="text-danger ms-1">*</span></label>
                                        <select class="form-select" name="from_location_id">
                                            <option value="">Select</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- To Warehouse --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Warehouse To <span
                                                class="text-danger ms-1">*</span></label>
                                        <select class="form-select" name="to_location_id">
                                            <option value="">Select</option>
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Quantity --}}

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Quantity <span class="text-danger ms-1">*</span></label>
                                        <input type="number" name="stock_quantity" class="form-control" required>
                                    </div>
                                </div>

                                 {{-- Responsible Person --}}

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Responsible Person <span class="text-danger ms-1">*</span></label>
                                        <input type="text" name="responsible_person" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Reference --}}
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Reference Number</label>
                                        <input type="text" name="ref_number" class="form-control">
                                    </div>
                                </div>
                            </div>

                            {{-- Notes --}}
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Notes</label>
                                    <textarea class="form-control" name="notes"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>

                </div>


            </div>
        </div>



        <!-- /Add Stock -->

        <!-- Edit Stock -->
        {{-- <div class="modal fade" id="edit-stock-transfer">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<div class="page-title">
							<h4>Edit Transfer</h4>
						</div>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="https://dreamspos.dreamstechnologies.com/html/template/stock-transfer.html">
						<div class="modal-body">
							<div class="row">
                                <div class="col-lg-12">
									<div class="mb-3 search-form">
										<label class="form-label">Product<span class="text-danger ms-1">*</span></label>
										<div class="position-relative">
											<input type="text" name="product_id" class="form-control" value="Nike Jordan">
											<i data-feather="search" class="feather-search"></i>
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Warehouse From<span class="text-danger ms-1">*</span></label>
										<select class="form-select" name="from_location_id">
											<option>Lobar Handy</option>
											<option>Quaint Warehouse</option>
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="mb-3">
										<label class="form-label">Warehouse To<span class="text-danger ms-1">*</span></label>
										<select class="form-select" name="to_location_id">
											<option>Selosy</option>
											<option>Logerro</option>
										</select>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3">
										<label class="form-label">Reference No<span class="text-danger ms-1">*</span></label>
										<input type="text" class="form-control" name="ref_number" value="PT002">
									</div>
								</div>

								<div class="col-lg-12">
									<div class="modal-body-table">
										<div class="table-responsive">
											<table class="table  datanew">
												<thead>
													<tr>
														<th>Product</th>
														<th>SKU</th>
														<th>Category</th>
														<th>Qty</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															<div class="d-flex align-items-center">
																<a href="javascript:void(0);" class="avatar avatar-md me-2">
																	<img src="assets/img/products/stock-img-02.png" alt="product">
																</a>
																<a href="javascript:void(0);">Nike Jordan</a>
															</div>
														</td>
														<td>PT002</td>
														<td>Nike</td>
														<td>
															<div class="product-quantity bg-gray-transparent border-0">
																<span class="quantity-btn"><i data-feather="minus-circle" class="feather-search"></i></span>
																<input type="text" class="quntity-input bg-transparent" value="2">
																<span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
															</div>
														</td>
														<td>
															<div class="edit-delete-action d-flex align-items-center justify-content-center">
																<a class="p-2 d-flex align-items-center justify-content-center border rounded" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#delete">
																	<i data-feather="trash-2" class="feather-trash-2"></i>
																</a>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="mb-3 search-form mb-0">
										<label class="form-label">Notes<span class="text-danger ms-1">*</span></label>
										<textarea  name="notes" class="form-control">The Jordan brand is owned by Nike (owned by the Knight family), as, at the time, the company was building its strategy to work with athletes to launch shows that could inspire consumers.Although Jordan preferred Converse and Adidas, they simply could not match the offer Nike made. </textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div> --}}
        <!-- /Edit Stock -->

        <!-- Import Transfer -->
        {{-- <div class="modal fade" id="view-notes">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Import Transfer</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/stock-transfer.html">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">From<span class="text-danger ms-1">*</span></label>
                                        <select class="select">
                                            <option>select</option>
                                            <option>Lavish Warehouse</option>
                                            <option>Lobar Handy</option>
                                            <option>Quaint Warehouse</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">To<span class="text-danger ms-1">*</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>North Zone Warehouse</option>
                                            <option>Nova Storage Hub</option>
                                            <option>Cool Warehouse</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Satus<span class="text-danger ms-1">*</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Sent</option>
                                            <option>Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="row">
                                        <div>
                                            <div class="modal-footer-btn download-file">
                                                <a href="javascript:void(0)" class="btn btn-submit">Download Sample
                                                    File</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3 image-upload-down">
                                        <label class="form-label"> Upload CSV File</label>
                                        <div class="image-upload download">
                                            <input type="file">
                                            <div class="image-uploads">
                                                <img src="assets/img/download-img.png" alt="img">
                                                <h4>Drag and drop a <span>file to upload</span></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Shipping<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
        <!-- /Import Transfer -->

        <!-- Delete -->
        {{-- <div class="modal fade modal-default" id="delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="success-wrap text-center">
                            <form id="deleteTransferForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="icon-success bg-danger-transparent text-danger mb-2">
                                    <i class="ti ti-trash"></i>
                                </div>
                                <h3 class="mb-2">Delete Stock Transfer</h3>
                                <p class="fs-16 mb-3">Are you sure you want to delete stock transfer?</p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button type="submit" class="btn btn-md btn-primary">Yes, Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Delete Confirmation Modal -->
        <div class="modal fade modal-default" id="delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="deleteTransferForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="modal-body p-0">
                            <div class="success-wrap text-center">
                                <div class="icon-success bg-danger-transparent text-danger mb-2">
                                    <i class="ti ti-trash"></i>
                                </div>
                                <h3 class="mb-2">Delete Stock Transfer</h3>
                                <p class="fs-16 mb-3">Are you sure you want to delete this stock transfer?</p>
                                <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
                                    <button type="button" class="btn btn-md btn-secondary" data-bs-dismiss="modal">No,
                                        Cancel</button>
                                    <button type="submit" class="btn btn-md btn-primary">Yes, Delete</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- /Delete -->



    @endsection


    @push('js')
        {{-- <script src="{{ asset('assets/js/stock-transfer.js') }}"></script> --}}

        {{-- Product Search and Details --}}
        <script>
            const PRODUCT_SEARCH_ROUTE = "{{ route('stock-transfer.product-search') }}";
            const PRODUCT_DETAILS_ROUTE_BASE = "{{ url('stock-transfer/product-details') }}";

            document.addEventListener('DOMContentLoaded', function() {
                const productInput = document.getElementById('productSearch');
                const productIdInput = document.getElementById('product_id');
                const suggestionBox = document.getElementById('productSuggestions');
                const stockInfo = document.getElementById('stockInfo');

                productInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    if (query.length < 2) {
                        suggestionBox.innerHTML = '';
                        stockInfo.innerHTML = '';
                        return;
                    }

                    fetch(`${PRODUCT_SEARCH_ROUTE}?q=${query}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(products => {
                            console.log("Fetched products:", products); // <--- add this

                            suggestionBox.innerHTML = '';
                            if (products.length === 0) {
                                suggestionBox.innerHTML =
                                    '<li class="list-group-item text-muted">No products found</li>';
                                return;
                            }

                            products.forEach(product => {
                                const li = document.createElement('li');
                                li.textContent = product.product_name;
                                li.className = 'list-group-item list-group-item-action';
                                li.onclick = () => {
                                    productInput.value = product.product_name;
                                    productIdInput.value = product.id;
                                    suggestionBox.innerHTML = '';

                                    fetch(`${PRODUCT_DETAILS_ROUTE_BASE}/${product.id}`)
                                        .then(res => res.json())
                                        .then(details => {
                                            stockInfo.innerHTML = details.length > 0 ?
                                                '<strong>Available in:</strong><br>' +
                                                details.map(d =>
                                                    `${d.location} – ${d.stock} units`)
                                                .join('<br>') :
                                                '<em>No stock available.</em>';
                                        });
                                };
                                suggestionBox.appendChild(li);
                            });
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            suggestionBox.innerHTML =
                                '<li class="list-group-item text-danger">Error fetching results</li>';
                        });
                });
            });
        </script>

        {{-- Delete route --}}
        <script>
            function openDeleteModal(id) {
                const route = "{{ route('stock-transfers.destroy', ':id') }}".replace(':id', id);
                document.getElementById('deleteTransferForm').action = route;
            }
        </script>

        {{-- filter --}}
        <script>
            let fromSelected = null;
            let toSelected = null;

            function applyFilter(field, value) {
                document.getElementById(field + 'Input').value = value;

                // Track warehouse selection
                if (field === 'from_location_id') fromSelected = value;
                if (field === 'to_location_id') toSelected = value;

                // Submit only if both warehouse values are selected OR if it's a sort_by filter
                if ((fromSelected && toSelected) || field === 'sort_by') {
                    document.getElementById('filterForm').submit();
                }
            }
        </script>


        {{-- Select All --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('.datatable input[type="checkbox"]');

                selectAllCheckbox.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (!this.checked) {
                            selectAllCheckbox.checked = false;
                        } else if (Array.from(checkboxes).every(cb => cb.checked)) {
                            selectAllCheckbox.checked = true;
                        }
                    });
                });
            });

            function submitExport(type) {
                const checkboxes = document.querySelectorAll('input[type="checkbox"][value]');
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length === 0) {
                    alert('Please select at least one transfer to export.');
                    return;
                }

                const form = document.getElementById('exportForm');
                const selectedInput = document.getElementById('selected_ids');
                selectedInput.value = selectedIds.join(',');

                if (type === 'pdf') {
                    form.action = "{{ route('stock-transfers.export.pdf') }}";
                } else if (type === 'excel') {
                    form.action = "{{ route('stock-transfers.export.excel') }}";
                }

                form.submit();
            }
        </script> --}}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('select-all');
                const checkboxes = document.querySelectorAll('.row-checkbox');

                // Select All logic
                selectAllCheckbox.addEventListener('change', function() {
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });

                // Deselect "select-all" if any one checkbox is unchecked
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (!this.checked) {
                            selectAllCheckbox.checked = false;
                        } else if (Array.from(checkboxes).every(cb => cb.checked)) {
                            selectAllCheckbox.checked = true;
                        }
                    });
                });
            });

            function submitExport(type) {
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const selectedIds = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length === 0) {
                    alert('Please select at least one transfer to export.');
                    return;
                }

                const form = document.getElementById('exportForm');
                const selectedInput = document.getElementById('selected_ids');
                selectedInput.value = selectedIds.join(',');

                if (type === 'pdf') {
                    form.action = "{{ route('stock-transfers.export.pdf') }}";
                } else if (type === 'excel') {
                    form.action = "{{ route('stock-transfers.export.excel') }}";
                }

                form.submit();
            }
        </script>
    @endpush
</x-app-layout>
