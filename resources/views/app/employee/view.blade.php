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
                        <h4>Employees</h4>
                        <h6>Manage your employees</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <div class="d-flex me-2 pe-2 border-end">
                            <a href="{{ route('employee.list') }}" class="btn-list me-2"><i data-feather="list"
                                    class="feather-user"></i></a>
                            <a href="{{ route('employee.view') }}" class="btn-grid active bg-primary me-2"><i
                                    data-feather="grid" class="feather-user text-white"></i></a>
                        </div>
                    </li>
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img
                                src="assets/img/icons/pdf.svg" alt="img"></a>
                    </li>
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img
                                src="assets/img/icons/excel.svg" alt="img"></a>
                    </li>
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
                    <a href="{{ route('employee.create') }}" class="btn btn-primary"><i
                            class="ti ti-circle-plus me-1"></i>Add Employee</a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-purple border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Total Employee</p>
                                <h4 class="text-white">1007</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-purple-900"><i class="ti ti-users-group"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-teal border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Active</p>
                                <h4 class="text-white">1007</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-teal-900"><i class="ti ti-user-star"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Inactive</p>
                                <h4 class="text-white">1007</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-secondary-900"><i
                                        class="ti ti-user-exclamation"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">New Joiners</p>
                                <h4 class="text-white">67</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-info-900"><i class="ti ti-user-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <div class="search-set mb-0">
                            <div class="search-input">
                                <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                                <input type="search" class="form-control" placeholder="Search">
                            </div>

                        </div>
                        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                            <div class="dropdown me-2">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Select Employees
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Anthony Lewis</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Brian Villalobos</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Harvey Smith</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Stephan Peralt</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Designation
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">System Admin</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Designer</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Tech Lead</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Database
                                            administrator</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /product list -->

            <div class="row employee-grid-widget">
                @foreach ($employees as $employee)
                    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start justify-content-between mb-2">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                    <div>
                                        <a href="employee-details.html"
                                            class="avatar avatar-xl avatar-rounded border p-1 rounded-circle">
                                            <img src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : asset('assets/img/users/default.jpg') }}"
                                                class="img-fluid h-auto w-auto" alt="img">
                                        </a>
                                    </div>
                                    <div class="dropdown">
                                        <a href="#" class="action-icon border-0" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i data-feather="more-vertical"
                                                class="feather-user"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="{{ route('employee.edit', ['id' => $employee->id]) }}"
                                                    class="dropdown-item"><i data-feather="edit"
                                                        class="me-2"></i>Edit</a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item confirm-text mb-0"
                                                    data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    data-id="{{ $employee->id }}"><i data-feather="trash-2"
                                                        class="me-2"></i>Delete</a>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-primary mb-2">EMP ID : {{ $employee->emp_code }}</p>
                                </div>
                                <div class="text-center mb-3">
                                    <h6 class="mb-1"><a href="employee-details.html">{{ $employee->first_name }}
                                            {{ $employee->last_name }}</a></h6>
                                    <span
                                        class="badge bg-secondary-transparent text-gray-9 fs-10 fw-medium">{{ $employee->designation }}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between bg-light rounded p-3">
                                    <div class="text-start">
                                        <h6 class="mb-1">Joined</h6>
                                        <p>{{ $employee->joined_date }}</p>
                                    </div>
                                    <div class="text-start">
                                        <h6 class="mb-1">Department</h6>
                                        <p>{{ $employee->department }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- delete modal -->
            <div class="modal fade" id="delete-modal">
                <form id="deleteEmployeeForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="page-wrapper-new p-0">
                                <div class="content p-5 px-3 text-center">
                                    <span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i
                                            class="ti ti-trash fs-24 text-danger"></i></span>
                                    <h4 class="fs-20 text-gray-9 fw-bold mb-2 mt-1">Delete Employee</h4>
                                    <p class="text-gray-6 mb-0 fs-16">Are you sure you want to delete employee?</p>
                                    <div class="modal-footer-btn mt-3 d-flex justify-content-center">
                                        <button type="button"
                                            class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-submit fs-13 fw-medium p-2 px-3">Yes
                                            Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>

        </div>



    @endsection


    @push('js')
    {{-- Delete --}}
       <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('[data-bs-target="#delete-modal"]');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const employeeId = this.getAttribute('data-id');
                        const form = document.getElementById('deleteEmployeeForm');
                        form.action = `{{ route('employee.delete', ['id' => '::id::']) }}`.replace(
                            '::id::', employeeId);
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
