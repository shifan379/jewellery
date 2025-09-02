<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->string('emp_code')->unique()->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('shift')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('about')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            // $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();

            // Emergency Contacts
            $table->string('emergency_contact_name1')->nullable();
            $table->string('emergency_relationship1')->nullable();
            $table->string('emergency_contact1')->nullable();

            $table->string('emergency_contact_name2')->nullable();
            $table->string('emergency_relationship2')->nullable();
            $table->string('emergency_contact2')->nullable();

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc')->nullable();

            $table->string('profile_photo')->nullable();
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
