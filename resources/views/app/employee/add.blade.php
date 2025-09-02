<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        <!-- Product create CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/product-create.css') }}">

        <style>
            /* sds */
            .profile-pic-upload {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .profile-pic {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            #previewImage {
                border-radius: 6px;
                /* slight rounding to soften square edges */
            }
        </style>
    @endpush

    @section('content')

        <div class="content">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops! There were some problems with your input:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

         
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Add Employee</h4>
                        <h6>Create new Employee</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                                class="ti ti-refresh"></i></a>
                    </li>
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                                class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="page-btn">
                    <a href="{{ route('employee.list') }}" class="btn btn-secondary"><i data-feather="arrow-left"
                            class="me-2"></i>Back to List</a>
                </div>
            </div>
            <!-- /product list -->

            <div class="container-fluid py-4">
                <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- EMPLOYEE INFORMATION -->
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="ti ti-users text-primary me-2"></i> Employee Information</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="new-employee-field">
                                    <div class="profile-pic-upload">
                                        <div class="profile-pic">
                                            <!-- Square Preview Box -->
                                            <img id="previewImage" src="#" alt="Preview"
                                                style="display: none; width: 120px; height: 120px; object-fit: cover; border: 1px solid #ccc; ">
                                            {{-- <span><i data-feather="plus-circle" class="plus-down-add"></i> Profile
                                                Photo</span> --}}
                                        </div>
                                        <div class="input-blocks mb-0">
                                            <div class="image-upload mb-0">
                                                <input type="file" name="profile_photo" class="form-control"
                                                    id="profilePhotoInput" accept="image/*">
                                                <div class="image-uploads">
                                                    <h4>Change Image</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="contact" required>
                                </div>
                                {{-- <div class="col-lg-4 mb-3">
                                    <label class="form-label">Employee Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emp_code" required>

                                </div> --}}
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="mb-3 list position-relative">
                                        <label class="form-label">Employee Code<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" name="emp_code" required class="form-control list emp_code">
                                        <button type="button" class="btn btn-primaryadd genEmpcode">
                                            Generate
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <select class="form-select" name="nationality" required>
                                        <option value="">Select</option>
                                        {{-- <option value="India">India</option>
                                        <option value="UK">UK</option> --}}
                                        <option value="Sri Lanka">Sri Lanka</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="joining_date" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="add-newplus">
                                        <label class="form-label">Shift<span class="text-danger ms-1">*</span></label>
                                        {{-- <a href="#" data-bs-toggle="modal" data-bs-target="#add_customer"><span><i
                                                    data-feather="plus-circle" class="plus-down-add"></i>Add
                                                new</span></a> --}}
                                    </div>
                                    <select class="form-select" name="shift" required>
                                        <option value="">Select</option>
                                        <option value="Morning">Morning</option>
                                        <option value="Evening">Evening</option>
                                        <option value="Night">Night</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-select" name="department" required>
                                        <option value="">Select</option>
                                        <option>HR</option>
                                        <option>Finance</option>
                                        <option>IT</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <select class="form-select" name="designation" required>
                                        <option value="">Select</option>
                                        <option>Manager</option>
                                        <option>Executive</option>
                                        <option>Intern</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Blood Group <span class="text-danger">*</span></label>
                                    <select class="form-select" name="blood_group">
                                        <option value="">Select</option>
                                        <option>A+</option>
                                        <option>A-</option>
                                        <option>B+</option>
                                        <option>B-</option>
                                        <option>O+</option>
                                        <option>O-</option>
                                        <option>AB+</option>
                                        <option>AB-</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">About <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote" name="about" rows="3" maxlength="60" inputmode="text"
                                        autocomplete="off" spellcheck="false" aria-label="About"></textarea>
                                    <p class="mt-1">Maximum 60 Characters. HTML is not allowed.</p>
                                </div>

                                @push('css')
                                    @parent
                                    <link
                                        href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
                                        rel="stylesheet">
                                @endpush

                                @push('js')
                                    @parent
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            $('.summernote').summernote({
                                                height: 100,
                                                toolbar: [
                                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                                    ['para', ['ul', 'ol', 'paragraph']],
                                                    ['view', ['codeview']]
                                                ],
                                                callbacks: {
                                                    onKeyup: function(e) {
                                                        var content = $(this).summernote('code').replace(/<\/?[^>]+(>|$)/g, "");
                                                        if (content.length > 60) {
                                                            $(this).summernote('code', content.substring(0, 60));
                                                        }
                                                    }
                                                }
                                            });
                                        });
                                    </script>
                                @endpush
                            </div>
                        </div>
                    </div>
                    <!-- ADDRESS INFORMATION -->
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i data-feather="map-pin" class="feather-edit text-primary me-2"></i>
                                Address
                                Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="form-select" name="country">
                                        <option value="">Select</option>
                                        <option value="Srilanka">Srilanka</option>
                                        {{-- <option value="USA">USA</option> --}}
                                    </select>
                                </div>
                                {{-- <div class="col-lg-4 mb-3">
                                    <label class="form-label">State</label>
                                    <select class="form-select" name="state">
                                        <option value="">Select</option>
                                        <option>Maharashtra</option>
                                        <option>California</option>
                                    </select>
                                </div> --}}
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">City</label>
                                    <select class="form-select" name="city">
                                        <option value="">Select</option>
                                        <option value="colombo">Colombo</option>
                                        <option value="kotte">Sri Jayawardenepura Kotte</option>
                                        <option value="galle">Galle</option>
                                        <option value="kandy">Kandy</option>
                                        <option value="negombo">Negombo</option>
                                        <option value="trincomalee">Trincomalee</option>
                                        <option value="jaffna">Jaffna</option>
                                        <option value="matara">Matara</option>
                                        <option value="anuradhapura">Anuradhapura</option>
                                        <option value="nuwara_eliya">Nuwara Eliya</option>
                                        <option value="badulla">Badulla</option>
                                        <option value="hambantota">Hambantota</option>
                                        <option value="ratnapura">Ratnapura</option>
                                        <option value="polonnaruwa">Polonnaruwa</option>
                                        <option value="batticaloa">Batticaloa</option>
                                        <option value="kurunegala">Kurunegala</option>
                                        <option value="puttalam">Puttalam</option>
                                        <option value="avissawella">Avissawella</option>
                                        <option value="colombo_10">Pettah (Colombo 10)</option>
                                        <option value="horana">Horana</option>
                                        <option value="kalutara">Kalutara</option>
                                        <option value="kilinochchi">Kilinochchi</option>
                                        <option value="vavuniya">Vavuniya</option>
                                        <option value="mannar">Mannar</option>
                                        <option value="mulaitivu">Mulaitivu</option>
                                        <option value="monaragala">Monaragala</option>
                                        <option value="gampaha">Gampaha</option>
                                        <option value="jaela">Ja-Ela</option>
                                        <option value="dehiwala">Dehiwala</option>
                                        <option value="moratuwa">Moratuwa</option>
                                        <option value="panadura">Panadura</option>
                                        <option value="homagama">Homagama</option>
                                        <option value="wattala">Wattala</option>
                                        <option value="kalmunai">Kalmunai</option>
                                        <option value="ampara">Ampara</option>
                                    </select>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- EMERGENCY CONTACT -->
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i data-feather="info" class="feather-edit text-primary me-2"></i>
                                Emergency Contact</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Emergency Contact Number 1</label>
                                    <input type="text" class="form-control" name="emergency_contact1" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="emergency_relationship1" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="emergency_contact_name1" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Emergency Contact Number 2</label>
                                    <input type="text" class="form-control" name="emergency_contact2">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="emergency_relationship2">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="emergency_contact_name2">
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- BANK INFORMATION -->
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="ti ti-building-bank feather-edit text-primary me-2"></i> Bank
                                Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" name="bank_name">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Branch</label>
                                    <input type="text" class="form-control" name="branch">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="account_no">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD SETUP -->
                    <div class="card mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i data-feather="info" class="feather-edit text-primary me-2"></i> Set
                                Password</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTONS -->
                    <div class="text-end">
                        <button type="reset" class="btn btn-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>



        </div>

        <!-- Add Shift -->
        <div class="modal fade" id="add_customer">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="page-title">
                            <h4>Add Shift</h4>
                        </div>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="https://dreamspos.dreamstechnologies.com/html/template/add-employee.html">
                        <div class="modal-body">
                            <div>
                                <label class="form-label">Shift<span class="text-danger">*</span></label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Add Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Add Shift -->



    @endsection

    @push('js')
        <script>
            document.getElementById('profilePhotoInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('previewImage');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'inline-block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        </script>

        <script>
            $(document).on('click', '.genEmpcode', function() {
                $.ajax({
                    url: '{{ url('generate-employee-code') }}',
                    type: 'GET',
                    success: function(response) {
                        $('.emp_code').val(response.emp_code);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                        alert('Error generating employee code');
                    }
                });
            });
        </script>


        <script src="{{ asset('assets/js/product-create.js') }}" type="text/javascript"></script>

        <!-- Feather Icon JS -->
        <script src="{{ asset('js/feather.min.js') }}" type="50c98d4c98f76db1b907ddb2-text/javascript"></script>
    @endpush
</x-app-layout>
