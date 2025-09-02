<x-app-layout>
    @section('title', 'Dashboard')

    @push('css')
        <style>
            /* sds */
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

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Employee</h4>
                        <h6>Edit existing Employee</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
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
                <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
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
                                            <span>
                                                {{-- @if ($employee->profile_photo)
                                                    <img src="{{ asset($employee->profile_photo) }}" class="img-thumbnail"
                                                        width="100" alt="Profile Image">
                                                @endif --}}
                                                <img id="profilePreview"
                                                    src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : asset('assets/img/users/default.jpg') }}"
                                                    class="img-fluid" alt="img" style="border-radius:7%">
                                            </span>
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
                                    <input type="text" class="form-control" name="first_name"
                                        value="{{ old('first_name', $employee->first_name) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name', $employee->last_name) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email', $employee->email) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="contact"
                                        value="{{ old('contact', $employee->contact) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Employee Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="emp_code"
                                        value="{{ old('emp_code', $employee->emp_code) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob"
                                        value="{{ old('dob', $employee->dob) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select" name="gender" required>
                                        <option value="">Select</option>
                                        <option value="Male"
                                            {{ old('gender', $employee->gender ?? '') == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female"
                                            {{ old('gender', $employee->gender ?? '') == 'Female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    @error('gender')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <select class="form-select no-type-select" name="nationality" required>
                                        <option value="">-- Select Nationality --</option>
                                        <option value="India"
                                            {{ old('nationality', $employee->nationality ?? '') == 'India' ? 'selected' : '' }}>
                                            India</option>
                                        <option value="UK"
                                            {{ old('nationality', $employee->nationality ?? '') == 'UK' ? 'selected' : '' }}>
                                            UK</option>
                                        <option value="Sri Lanka"
                                            {{ old('nationality', $employee->nationality ?? '') == 'Sri Lanka' ? 'selected' : '' }}>
                                            Sri Lanka</option>
                                    </select>
                                    @error('nationality')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="joining_date"
                                        value="{{ old('joining_date', $employee->joining_date) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Shift <span class="text-danger">*</span></label>
                                    <select class="form-select" name="shift" required>
                                        <option value="">Select</option>
                                        <option value="Morning"
                                            {{ old('shift', $employee->shift ?? '') == 'Morning' ? 'selected' : '' }}>
                                            Morning</option>
                                        <option value="Evening"
                                            {{ old('shift', $employee->shift ?? '') == 'Evening' ? 'selected' : '' }}>
                                            Evening</option>
                                        <option value="Night"
                                            {{ old('shift', $employee->shift ?? '') == 'Night' ? 'selected' : '' }}>Night
                                        </option>
                                    </select>
                                    @error('shift')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-select" name="department" required>
                                        <option value="">Select</option>
                                        <option value="HR"
                                            {{ old('department', $employee->department ?? '') == 'HR' ? 'selected' : '' }}>
                                            HR</option>
                                        <option value="IT"
                                            {{ old('department', $employee->department ?? '') == 'IT' ? 'selected' : '' }}>
                                            IT</option>
                                        <option value="Sales"
                                            {{ old('department', $employee->department ?? '') == 'Sales' ? 'selected' : '' }}>
                                            Sales</option>
                                    </select>
                                    @error('department')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                    @error('department')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Designation <span class="text-danger">*</span></label>
                                    <select class="form-select" name="designation" required>
                                        <option value="">Select</option>
                                        <option value="Manager"
                                            {{ old('designation', $employee->designation ?? '') == 'Manager' ? 'selected' : '' }}>
                                            Manager</option>
                                        <option value="Developer"
                                            {{ old('designation', $employee->designation ?? '') == 'Developer' ? 'selected' : '' }}>
                                            Developer</option>
                                        <option value="Support"
                                            {{ old('designation', $employee->designation ?? '') == 'Executive' ? 'selected' : '' }}>
                                            Executive</option>
                                    </select>
                                    @error('designation')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Blood Group</label>
                                    <select name="blood_group" class="form-select no-type-select" required>
                                        <option value="">-- Select Blood Group --</option>
                                        <option value="A+"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'A+' ? 'selected' : '' }}>
                                            A+</option>
                                        <option value="A-"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'A-' ? 'selected' : '' }}>
                                            A-</option>
                                        <option value="B+"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'B+' ? 'selected' : '' }}>
                                            B+</option>
                                        <option value="B-"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'B-' ? 'selected' : '' }}>
                                            B-</option>
                                        <option value="O+"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'O+' ? 'selected' : '' }}>
                                            O+</option>
                                        <option value="O-"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'O-' ? 'selected' : '' }}>
                                            O-</option>
                                        <option value="AB+"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'AB+' ? 'selected' : '' }}>
                                            AB+</option>
                                        <option value="AB-"
                                            {{ old('blood_group', $employee->blood_group ?? '') == 'AB-' ? 'selected' : '' }}>
                                            AB-</option>
                                    </select>
                                    @error('blood_group')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror

                                </div>

                                <div class="col-lg-12 mb-3">
                                    <label class="form-label">About <span class="text-danger">*</span></label>
                                    <textarea class="form-control summernote" name="about" rows="3" maxlength="60" inputmode="text"
                                        autocomplete="off" spellcheck="false" aria-label="About"> {{ old('about', $employee->about) }}</textarea>
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
                                    <input type="text" class="form-control" name="address"
                                        value="{{ old('address', $employee->address) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Country</label>
                                    <select class="form-select" name="country" required>
                                        <option value="">Select</option>
                                        <option value="India"
                                            {{ old('country', $employee->country ?? '') == 'India' ? 'selected' : '' }}>
                                            India</option>
                                        <option value="USA"
                                            {{ old('country', $employee->country ?? '') == 'USA' ? 'selected' : '' }}>USA
                                        </option>
                                    </select>
                                    @error('country')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">State</label>
                                    <select class="form-select" name="state" required>
                                        <option value="">Select</option>
                                        <option value="Maharashtra"
                                            {{ old('state', $employee->state ?? '') == 'Maharashtra' ? 'selected' : '' }}>
                                            Maharashtra</option>
                                        <option value="California"
                                            {{ old('state', $employee->state ?? '') == 'California' ? 'selected' : '' }}>
                                            California</option>
                                    </select>
                                    @error('state')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">City</label>
                                    <select class="form-select" name="city" required>
                                        <option value="">Select</option>
                                        <option value="Mumbai"
                                            {{ old('city', $employee->city ?? '') == 'Mumbai' ? 'selected' : '' }}>Mumbai
                                        </option>
                                        <option value="Los Angeles"
                                            {{ old('city', $employee->city ?? '') == 'Los Angeles' ? 'selected' : '' }}>Los
                                            Angeles</option>
                                    </select>
                                    @error('city')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Zipcode</label>
                                    <input type="text" class="form-control" name="zipcode"
                                        value="{{ old('zipcode', $employee->zipcode) }}">
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
                                    <input type="text" class="form-control" name="emergency_contact_name1"
                                        value="{{ old('emergency_contact_name1', $employee->emergency_contact_name1) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="emergency_relationship1"
                                        value="{{ old('emergency_relationship1', $employee->emergency_relationship1) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="emergency_contact1"
                                        value="{{ old('emergency_contact1', $employee->emergency_contact1) }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Emergency Contact Number 2</label>
                                    <input type="text" class="form-control" name="emergency_contact_name2"
                                        value="{{ old('emergency_contact_name2', $employee->emergency_contact_name2) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Relationship</label>
                                    <input type="text" class="form-control" name="emergency_relationship2"
                                        value="{{ old('emergency_relationship2', $employee->emergency_relationship2) }}">
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="emergency_contact2"
                                        value="{{ old('emergency_contact2', $employee->emergency_contact2) }}">
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
                                    <input type="text" class="form-control" name="bank_name"
                                        value="{{ old('bank_name', $employee->bank_name) }}">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Branch</label>
                                    <input type="text" class="form-control" name="branch"
                                        value="{{ old('branch', $employee->branch) }}">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="account_no"
                                        value="{{ old('account_no', $employee->account_no) }}">
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label">IFSC Code</label>
                                    <input type="text" class="form-control" name="ifsc"
                                        value="{{ old('ifsc', $employee->ifsc) }}">
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
                                <div class="col-lg-4 col-md-6">
                                    <div class="input-blocks mb-md-0 mb-sm-3">
                                        <label>Password</label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-input form-control" name="password">
                                            <span class="fas toggle-password fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="input-blocks mb-0">
                                        <label>Confirm Password</label>
                                        <div class="pass-group">
                                            <input type="password" class="pass-inputa form-control"
                                                name="confirm_password">
                                            <span class="fas toggle-passworda fa-eye-slash"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTONS -->
                    <div class="text-end">
                        <button type="reset" onclick="window.history.back();" class="btn btn-secondary me-2">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit Employee</button>
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
                const [file] = event.target.files;
                if (file) {
                    const previewImg = document.getElementById('profilePreview');
                    previewImg.src = URL.createObjectURL(file);
                }
            });
        </script>
    @endpush
</x-app-layout>
