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


        <style>
            /* sds */
        </style>
    @endpush

    @section('content')

        <div class="content">
            <div class="card">
                <div class="container py-4 p-5">
                    <div class="page-title mb-4">
                        <h4>Add Supplier</h4>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('suppliers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="redirect_from" value="supplier_form">

                        <div class="row">
                            <div class="mb-3">
                                <div class="add-image-upload">
                                    <div class="preview-images d-flex align-items-center add-image"></div>
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
                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="company_name" required
                                        value="{{ old('company_name') }}">
                                    @error('company_name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name"
                                        value="{{ old('bank_name') }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Bank Acc No</label>
                                    <input type="text" class="form-control" name="bank_acc_no"
                                        value="{{ old('bank_acc_no') }}">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="status-toggle modal-status d-flex justify-content-between align-items-center">
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

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Add Supplier</button>
                            <a href="{{ route('purchase') }}" class="btn btn-secondary">Back to Purchase</a>
                        </div>
                    </form>
                </div>
            </div>


        </div>


    @endsection


    @push('js')

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

        <!-- Select2 JS -->
        <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>

        <script src="{{ asset('assets/js/moment.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap Tagsinput JS -->
        <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}" type="text/javascript"></script>
    @endpush
</x-app-layout>
