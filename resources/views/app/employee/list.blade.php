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
                            <a href="{{ route('employee.list') }}" class="btn-list active bg-primary me-2"><i
                                    data-feather="list" class="feather-user text-white"></i></a>
                            <a href="{{ route('employee.view') }}" class="btn-grid me-2"><i data-feather="grid"
                                    class="feather-user"></i></a>
                        </div>
                    </li>
                    <li class="me-2">
                        <a href="javascript:void(0);" onclick="submitExport('pdf')" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="PDF">
                            <img src="assets/img/icons/pdf.svg" alt="PDF">
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="javascript:void(0);" onclick="submitExport('excel')" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Excel">
                            <img src="assets/img/icons/excel.svg" alt="Excel">
                        </a>
                    </li>



                    <li class="me-2">
                        <a href="{{ route('employee.list') }}" data-bs-toggle="tooltip" data-bs-placement="top"
                            title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
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
                                <h4 class="text-white">{{ $totalEmployees }}</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-purple-900"><i class="ti ti-users-group"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xl-3 col-md-4">
                    <div class="card bg-teal border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Active</p>
                                <h4 class="text-white">{{ $activeEmployees }}</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-teal-900"><i class="ti ti-user-star"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-4">
                    <div class="card bg-secondary border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Inactive</p>
                                <h4 class="text-white">{{ $inactiveEmployees }}</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-secondary-900"><i
                                        class="ti ti-user-exclamation"></i></span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">New Joiners</p>
                                <h4 class="text-white">{{ $newJoiners }}</h4>
                            </div>
                            <div>
                                <span class="avatar avatar-lg bg-info-900"><i class="ti ti-user-check"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- product list -->

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <div class="search-set">
                        <div class="search-input">
                            <span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
                        </div>
                    </div>
                    <form action="{{ route('employee.list') }}" method="GET">
                        <div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">

                            <!-- Employee Filter -->
                            <div class="dropdown me-2">
                                <button class="dropdown-toggle btn btn-white btn-md" type="button"
                                    data-bs-toggle="dropdown">
                                    {{ request('employee_name') ?? 'Select Employees' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <!-- 'All Employees' button to remove filter -->
                                    <li>
                                        <a href="{{ route('employee.list') }}" class="dropdown-item rounded-1">
                                            All Employees
                                        </a>
                                    </li>
                                    @foreach ($employeeNames as $name)
                                        <li>
                                            <button type="submit" name="employee_name" value="{{ $name }}"
                                                class="dropdown-item rounded-1">
                                                {{ $name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <!-- Designation Filter -->
                            <div class="dropdown">
                                <button class="dropdown-toggle btn btn-white btn-md" type="button"
                                    data-bs-toggle="dropdown">
                                    {{ request('designation') ?? 'Designation' }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                    <li>
                                        <a href="{{ route('employee.list') }}" class="dropdown-item rounded-1">
                                            All Designations
                                        </a>
                                    </li>
                                    @foreach ($designations as $designation)
                                        <li>
                                            <button type="submit" name="designation" value="{{ $designation }}"
                                                class="dropdown-item rounded-1">
                                                {{ $designation }}
                                            </button>
                                        </li>
                                    @endforeach
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
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Shift</th>
                                    {{-- <th>Status</th> --}}
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox" class="employee-checkbox" name="selected_ids[]"
                                                    value="{{ $employee->id }}">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <a
                                                href="{{ route('employee.details', ['id' => $employee->id]) }}">{{ $employee->emp_code }}</a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('employee.details', ['id' => $employee->id]) }}"
                                                    class="avatar avatar-md">
                                                    <img src="{{ $employee->profile_photo ? asset('storage/' . $employee->profile_photo) : asset('assets/img/users/default.jpg') }}"
                                                        class="img-fluid" alt="img">
                                                </a>


                                                <div class="ms-2">
                                                    <p class="text-dark mb-0">
                                                        <a
                                                            href="{{ route('employee.details', ['id' => $employee->id]) }}">
                                                            {{ $employee->first_name }} {{ $employee->last_name }}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $employee->designation }}
                                        </td>
                                        <td>
                                            {{ $employee->email }}
                                        </td>
                                        <td>{{ $employee->contact }} </td>
                                        <td>
                                            {{ $employee->shift }}
                                        </td>
                                        {{-- <td>
                                            <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Active
                                            </span>
                                        </td> --}}
                                        <td>
                                            <div class="edit-delete-action d-flex align-items-center">
                                                <a class="me-2 d-flex align-items-center border rounded p-2"
                                                    href="{{ route('employee.details', ['id' => $employee->id]) }}">
                                                    <i data-feather="eye" class="feather-eye"></i>
                                                </a>
                                                <a class="me-2 p-2 d-flex align-items-center border rounded"
                                                    href="{{ route('employee.edit', ['id' => $employee->id]) }}">
                                                    <i data-feather="edit" class="feather-edit"></i>
                                                </a>
                                                <a data-bs-toggle="modal" data-bs-target="#delete-modal"
                                                    class="p-2 d-flex align-items-center border rounded"
                                                    href="javascript:void(0);" data-id="{{ $employee->id }}">
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
        <!-- /delete modal -->


    @endsection


    @push('js')
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

        {{-- Select all export --}}
        <script>
            // Select All Checkbox
            document.getElementById('select-all').addEventListener('change', function() {
                let checkboxes = document.querySelectorAll('.employee-checkbox');
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            function submitExport(format) {
                let selected = [];
                document.querySelectorAll('.employee-checkbox:checked').forEach(cb => {
                    selected.push(cb.value);
                });

                if (selected.length === 0) {
                    alert('Please select at least one employee.');
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('employees.export') }}";

                const token = document.createElement('input');
                token.type = 'hidden';
                token.name = '_token';
                token.value = '{{ csrf_token() }}';
                form.appendChild(token);

                const formatInput = document.createElement('input');
                formatInput.type = 'hidden';
                formatInput.name = 'format';
                formatInput.value = format;
                form.appendChild(formatInput);

                const selectedInput = document.createElement('input');
                selectedInput.type = 'hidden';
                selectedInput.name = 'selected_ids';
                selectedInput.value = selected.join(',');
                form.appendChild(selectedInput);

                document.body.appendChild(form);
                form.submit();
            }
        </script>
    @endpush
</x-app-layout>
