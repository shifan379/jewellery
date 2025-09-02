    <!DOCTYPE html>
    <html>

    <head>
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                margin: 20px;
                color: #333;
            }

            h2 {
                text-align: center;
                margin-bottom: 30px;
                color: #0056b3;
                border-bottom: 2px solid #0056b3;
                padding-bottom: 10px;
            }

            .employee-card {
                border: 1px solid #ddd;
                border-radius: 6px;
                padding: 15px 20px;
                margin-bottom: 25px;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
            }

            .employee-header {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 15px;
                color: #222;
                border-bottom: 1px solid #ccc;
                padding-bottom: 6px;
            }

            .section {
                margin-bottom: 12px;
            }

            .section-title {
                font-weight: 600;
                color: #007bff;
                margin-bottom: 6px;
                font-size: 14px;
                border-bottom: 1px dashed #007bff;
                padding-bottom: 4px;
            }

            dl {
                display: flex;
                flex-wrap: wrap;
                margin: 0;
            }

            dt,
            dd {
                width: 50%;
                margin: 0;
                padding: 3px 0;
            }

            dt {
                font-weight: 700;
                color: #555;
            }

            dd {
                color: #000;
            }

            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
         @foreach ($employees as $employee)
        <h2>{{ $employee['first_name'] }} {{ $employee['last_name'] }} - Employee Report</h2>


            <div class="employee-card">
                <div class="employee-header">
                    {{ $employee['first_name'] }} {{ $employee['last_name'] }} ({{ $employee['emp_code'] }})
                </div>

                <div class="section">
                    <div class="section-title">Personal Information</div>
                    <dl>
                        <dt>Date of Birth:</dt>
                        <dd>{{ \Carbon\Carbon::parse($employee['dob'])->format('d-m-Y') }}</dd>

                        <dt>Gender:</dt>
                        <dd>{{ $employee['gender'] }}</dd>

                        <dt>Blood Group:</dt>
                        <dd>{{ $employee['blood_group'] ?? 'N/A' }}</dd>

                        <dt>About:</dt>
                        <dd>{{ $employee['about'] ?? 'N/A' }}</dd>

                        <dt>Nationality:</dt>
                        <dd>{{ $employee['nationality'] }}</dd>
                    </dl>
                </div>

                <div class="section">
                    <div class="section-title">Contact Information</div>
                    <dl>
                        <dt>Email:</dt>
                        <dd>{{ $employee['email'] }}</dd>

                        <dt>Contact Number:</dt>
                        <dd>{{ $employee['contact'] }}</dd>

                        <dt>Address:</dt>
                        <dd>{{ $employee['address'] ?? 'N/A' }}, {{ $employee['city'] ?? '' }},
                            {{ $employee['country'] ?? '' }} -
                            {{ $employee['zipcode'] ?? '' }}</dd>
                    </dl>
                </div>

                <div class="section">
                    <div class="section-title">Job Details</div>
                    <dl>
                        <dt>Joining Date:</dt>
                        <dd>{{ \Carbon\Carbon::parse($employee['joining_date'])->format('d-m-Y') }}</dd>

                        <dt>Shift:</dt>
                        <dd>{{ $employee['shift'] ?? 'N/A' }}</dd>

                        <dt>Department:</dt>
                        <dd>{{ $employee['department'] }}</dd>

                        <dt>Designation:</dt>
                        <dd>{{ $employee['designation'] }}</dd>
                    </dl>
                </div>

                <div class="section">
                    <div class="section-title">Emergency Contacts</div>
                    <dl>
                        <dt>Contact Name 1:</dt>
                        <dd>{{ $employee['emergency_contact_name1'] ?? 'N/A' }}</dd>

                        <dt>Relationship 1:</dt>
                        <dd>{{ $employee['emergency_relationship1'] ?? 'N/A' }}</dd>

                        <dt>Contact 1:</dt>
                        <dd>{{ $employee['emergency_contact1'] ?? 'N/A' }}</dd>

                        <dt>Contact Name 2:</dt>
                        <dd>{{ $employee['emergency_contact_name2'] ?? 'N/A' }}</dd>

                        <dt>Relationship 2:</dt>
                        <dd>{{ $employee['emergency_relationship2'] ?? 'N/A' }}</dd>

                        <dt>Contact 2:</dt>
                        <dd>{{ $employee['emergency_contact2'] ?? 'N/A' }}</dd>
                    </dl>
                </div>

                <div class="section">
                    <div class="section-title">Bank Details</div>
                    <dl>
                        <dt>Bank Name:</dt>
                        <dd>{{ $employee['bank_name'] ?? 'N/A' }}</dd>

                        <dt>Branch:</dt>
                        <dd>{{ $employee['branch'] ?? 'N/A' }}</dd>

                        <dt>Account Number:</dt>
                        <dd>{{ $employee['account_no'] ?? 'N/A' }}</dd>

                        <dt>IFSC Code:</dt>
                        <dd>{{ $employee['ifsc'] ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>

            @if (!$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach

    </body>

    </html>
