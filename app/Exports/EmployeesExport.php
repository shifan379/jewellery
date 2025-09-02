<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    protected $employees;

    public function __construct($employees)
    {
        $this->employees = $employees;
    }

    public function collection()
    {
        return $this->employees->map(function ($employee) {
            return [
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'contact' => $employee->contact,
                'emp_code' => $employee->emp_code,
                'dob' => $employee->dob,
                'gender' => $employee->gender,
                'nationality' => $employee->nationality,
                'joining_date' => $employee->joining_date,
                'shift' => $employee->shift,
                'department' => $employee->department,
                'designation' => $employee->designation,
                'blood_group' => $employee->blood_group,
                'about' => $employee->about,

                'address' => $employee->address,
                'city' => $employee->city,
                'state' => $employee->state,
                'country' => $employee->country,
                'zipcode' => $employee->zipcode,

                'emergency_contact_name1' => $employee->emergency_contact_name1,
                'emergency_relationship1' => $employee->emergency_relationship1,
                'emergency_contact1' => $employee->emergency_contact1,

                'emergency_contact_name2' => $employee->emergency_contact_name2,
                'emergency_relationship2' => $employee->emergency_relationship2,
                'emergency_contact2' => $employee->emergency_contact2,

                'bank_name' => $employee->bank_name,
                'branch' => $employee->branch,
                'account_no' => $employee->account_no,
                'ifsc' => $employee->ifsc,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Contact',
            'Employee Code',
            'Date of Birth',
            'Gender',
            'Nationality',
            'Joining Date',
            'Shift',
            'Department',
            'Designation',
            'Blood Group',
            'About',
            'Address',
            'City',
            'State',
            'Country',
            'Zipcode',
            'Emergency Contact Name 1',
            'Emergency Relationship 1',
            'Emergency Contact 1',
            'Emergency Contact Name 2',
            'Emergency Relationship 2',
            'Emergency Contact 2',
            'Bank Name',
            'Branch',
            'Account Number',
            'IFSC',
        ];
    }
}
