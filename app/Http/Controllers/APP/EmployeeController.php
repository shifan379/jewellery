<?php

namespace App\Http\Controllers\APP;

use App\Exports\EmployeesExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('app.employee.view', compact('employees'));
    }
    public function create()
    {
        return view('app.employee.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'required|email|unique:employees,email',
            'contact' => 'required|string|max:20',
            'emp_code' => 'required|string|max:50|unique:employees,emp_code',
            'dob' => 'required|date',
            'gender' => 'required',
            'nationality' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'shift' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'blood_group' => 'nullable|string|max:10',
            'about' => 'nullable|string|max:60',
            'address' => 'required|nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            // 'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:10',
            'emergency_contact_name1' => 'required|nullable|string|max:100',
            'emergency_relationship1' => 'required|nullable|string|max:100',
            'emergency_contact1' => 'required|nullable|string|max:20',
            'emergency_contact_name2' => 'nullable|string|max:100',
            'emergency_relationship2' => 'nullable|string|max:100',
            'emergency_contact2' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:30',
            'ifsc' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            'contact',
            'emp_code',
            'dob',
            'gender',
            'nationality',
            'joining_date',
            'shift',
            'department',
            'designation',
            'blood_group',
            'about',
            'address',
            'country',
            // 'state',
            'city',
            'zipcode',
            'emergency_contact_name1',
            'emergency_relationship1',
            'emergency_contact1',
            'emergency_contact_name2',
            'emergency_relationship2',
            'emergency_contact2',
            'bank_name',
            'branch',
            'account_no',
            'ifsc'
        ]);

        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('employees', 'public');
            $data['profile_photo'] = $path;
        }

        Employee::create($data);


        return redirect()->route('employee.list')->with('success', 'Employee added successfully!');
    }

    public function generateEmployeeCode()
    {
        $latest = Employee::orderBy('id', 'desc')->first();

        $number = $latest ? ((int) filter_var($latest->emp_code, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;

        $code = 'EMP' . str_pad($number, 3, '0', STR_PAD_LEFT);

        return response()->json(['emp_code' => $code]);
    }



    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('app.employee.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        // Validation rules - password is nullable on update
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'contact' => 'required|string|max:20',
            'emp_code' => 'required|string|max:50|unique:employees,emp_code,' . $employee->id,
            'dob' => 'required|date',
            'gender' => 'required',
            'nationality' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'shift' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'designation' => 'required|string|max:100',
            'blood_group' => 'nullable|string|max:10',
            'about' => 'nullable|string|max:60',
            'address' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:10',
            'emergency_contact_name1' => 'nullable|string|max:100',
            'emergency_relationship1' => 'nullable|string|max:100',
            'emergency_contact1' => 'nullable|string|max:20',
            'emergency_contact_name2' => 'nullable|string|max:100',
            'emergency_relationship2' => 'nullable|string|max:100',
            'emergency_contact2' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:100',
            'branch' => 'nullable|string|max:100',
            'account_no' => 'nullable|string|max:30',
            'ifsc' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle profile photo upload if present
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('employees', 'public');
            $validated['profile_photo'] = $path;

            // Optionally, delete old image from storage here if you want
            // Storage::disk('public')->delete($employee->profile_photo);
        }

        // Handle password only if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update employee record
        $employee->update($validated);

        // Redirect back to employee list with success message
        return redirect()->route('employee.list')->with('success', 'Employee updated successfully.');
    }

    public function list(Request $request)
    {
        $query = Employee::query();

        // Filter by designation
        if ($request->has('designation') && !empty($request->designation)) {
            $query->where('designation', $request->designation);
        }

        // Filter by employee name (first name or last name)
        if ($request->has('employee_name') && !empty($request->employee_name)) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->employee_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->employee_name . '%');
            });
        }

        $employees = $query->latest()->get();

        // (Optional) For filter dropdowns
        $employeeNames = Employee::select('first_name')->distinct()->pluck('first_name');
        $designations = Employee::select('designation')->distinct()->pluck('designation');

        // === 👇 Dashboard Cards Data (Summary) ===
        $totalEmployees = Employee::count();
        // $activeEmployees = Employee::where('status', 'Active')->count();
        // $inactiveEmployees = Employee::where('status', 'Inactive')->count();
        $newJoiners = Employee::where('joining_date', '>=', Carbon::now()->subDays(30))->count();


        return view('app.employee.list', compact('employees', 'employeeNames', 'designations', 'totalEmployees', 'newJoiners'));
    }

    public function details($id)
    {

        $employee = Employee::findOrFail($id); // Fails with 404 if not found
        return view('app.employee.details', compact('employee'));

    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        // Delete profile photo from storage if exists
        if ($employee->profile_photo && file_exists(public_path($employee->profile_photo))) {
            unlink(public_path($employee->profile_photo));
        }

        $employee->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully!');

    }

    public function export(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
        ]);

        // Check if selected_ids exist
        $selectedIds = $request->input('selected_ids');

        $query = Employee::query();

        if ($selectedIds) {
            $ids = explode(',', $selectedIds);
            $query->whereIn('id', $ids);
        } else {
            // Apply filters if no checkboxes selected
            if ($request->filled('employee_name')) {
                $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $request->employee_name . '%']);
            }

            if ($request->filled('designation')) {
                $query->where('designation', $request->designation);
            }
        }

        $employees = $query->get();

        if ($employees->isEmpty()) {
            return redirect()->back()->with('error', 'No data to export.');
        }

        if ($request->format === 'excel') {
            return Excel::download(new EmployeesExport($employees), 'employees.xlsx');
        }

        // PDF Export with view
        $pdf = PDF::loadView('export.employee_pdf', compact('employees'))->setPaper('a4', 'portrait');
        return $pdf->download('employees.pdf');
    }


}
