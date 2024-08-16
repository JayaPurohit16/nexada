@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Student</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.student.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Student
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.student.store') }}" method="POST" id="studentForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="age" id="age">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="true">Student</button>
                        </li>
                        <li class="nav-item" role="presentation" id="parentTab">
                            <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button" role="tab" aria-controls="parent" aria-selected="false" disabled>Parent</button>
                        </li>
                    </ul>
            
                    <!-- Tab Content -->
                    <div class="tab-content" id="myTabContent">
                        {{-- Student Tab --}}
                        <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="first_name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('first_name') is-invalid @enderror" name="first_name" id="first_name"
                                        placeholder="First Name" value="{{ old('first_name') }}" maxlength="100">
                                    @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-md-6">
                                    <label for="second_name"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('second_name') is-invalid @enderror" name="second_name" id="second_name"
                                        placeholder="Second Name" value="{{ old('second_name') }}" maxlength="100">
                                    @error('second_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-md-6">
                                    <label for="date_of_birth"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Date Of Birth <span class="text-danger-600">*</span></label>
                                    <input type="date" class="form-control radius-8 @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth"
                                        placeholder="Date Of Birth" value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="email"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                            <span class="text-danger-600">*</span></label>
                                        <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" name="email"
                                            id="email" placeholder="Email address" value="{{ old('email') }}" maxlength="100">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>
        
                                <div class="col-md-6">
                                    <label for="phone"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" name="phone" id="phone"
                                        placeholder="Phone" value="{{ old('phone') }}" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-md-6">
                                    <label for="location_id"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Location <span class="text-danger-600">*</span></label>
                                        <select name="location_id" id="location_id" class="form-control">
                                            @if (isset($locations))
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            @endif
                                    </select>
                                    @error('location_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-md-6">
                                    <label for="primary_instrument"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Primary Instrument <span class="text-danger-600">*</span></label>
                                    <select name="primary_instrument" id="primary_instrument" class="form-control">
                                        @if(isset($instruments))
                                            @foreach ($instruments as $instrument)
                                                <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('primary_instrument')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
        
                                <div class="col-md-6">
                                    <label for="plan"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Plan <span class="text-danger-600">*</span></label>
                                        <select name="plan" id="plan" class="form-control">
                                            @if (isset($subscriptionTypes))
                                                @foreach ($subscriptionTypes as $subscriptionType)
                                                    <option value="{{ $subscriptionType->id }}">
                                                        {{ $subscriptionType->SubscriptionInfo->name ?? '' }}
                                                        ({{ $subscriptionType->amount ?? '' }})
                                                        ({{ $subscriptionType->billing_period_name ?? '' }})
                                                        ({{ $subscriptionType->discount ?? '' }}% Discount)
                                                    </option>
                                                @endforeach
                                            @endif
                                    </select>
                                    @error('plan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3 submit-button">
                                    <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="saveButton">Save</button>
                                    <button type="button" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="nextButton">Next</button>
                                </div>
                            </div>
                        </div>
            
                        {{-- Parent Tab --}}
                        <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="parent-tab">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <label for="parent_first_name" class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('parent_first_name') is-invalid @enderror" name="parent_first_name" id="parent_first_name"
                                        placeholder="First Name" value="{{ old('parent_first_name') }}" maxlength="100">
                                    @error('parent_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
            
                                <div class="col-md-6">
                                    <label for="parent_second_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('parent_second_name') is-invalid @enderror" name="parent_second_name" id="parent_second_name"
                                        placeholder="Second Name" value="{{ old('parent_second_name') }}" maxlength="100">
                                    @error('parent_second_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
            
                                <div class="col-sm-6">
                                    <div class="mb-20">
                                        <label for="parent_email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                        <input type="parent_email" class="form-control radius-8 @error('parent_email') is-invalid @enderror" name="parent_email"
                                            id="parent_email" placeholder="Email address" value="{{ old('parent_email') }}" maxlength="100">
                                        @error('parent_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="parent_phone"
                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span class="text-danger-600">*</span></label>
                                    <input type="text" class="form-control radius-8 @error('parent_phone') is-invalid @enderror" name="parent_phone" id="parent_phone"
                                        placeholder="Phone" value="{{ old('parent_phone') }}" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                    @error('parent_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-3 submit-button">
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="parentSubmitButton">Save</button>
                                {{-- <button type="button" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="nextButton">Next</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script>
        $(document).ready(function() {

            function getDatePicker (receiveID) {
                flatpickr(receiveID, {
                    enableTime: false,
                    dateFormat: "Y/m/d",
                });
            }
            getDatePicker('#date_of_birth');

            var today = new Date().toISOString().split('T')[0];
            $('#date_of_birth').attr('max', today);

            $('#studentForm').validate({
                rules: {
                    first_name: "required",
                    second_name: "required",
                    date_of_birth: "required",
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ route('admin.student.checkMail') }}',
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            dataFilter: function(response) {
                                var json = JSON.parse(response);
                                return json.exists ? `"This email is already registered."` : true;
                            }
                        }
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        digits: true
                    },
                    location_id: "required",
                    primary_instrument: "required",
                    plan: "required",
                },
                messages: {
                    first_name: "Please enter the first name",
                    second_name: "Please enter the second name",
                    date_of_birth: "Please select the date of birth",
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                        remote: "This email is already registered."
                    },
                    phone: {
                        required: "Please enter a phone number",
                        minlength: "Phone number must be 10 digits",
                        maxlength: "Phone number must be 10 digits",
                        digits: "Please enter a valid phone number"
                    },
                    location_id: "Please select a location",
                    primary_instrument: "Please select a primary instrument",
                    plan: "Please select a plan",
                },
                errorClass: "error",
                validClass: "",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                }
            });

            function switchToParentTab() {
                $('#parent-tab').tab('show');
                $('#student-tab').removeClass('active');
                $('#parent-tab').addClass('active');
                $('#student').removeClass('show active');
                $('#parent').addClass('show active');
            }

            function calculateAge(dob) {
                const today = new Date();
                const birthDate = new Date(dob);
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDifference = today.getMonth() - birthDate.getMonth();
                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                $('input[name="age"]').val(age);
                return age;
            }

            function toggleTabs() {
                const dob = $('#date_of_birth').val();
                const age = calculateAge(dob);

                if (age < 18) {
                    $('#parent-tab').show();
                    $('#parent').show();
                    $('#student-tab').tab('show');
                    $('#saveButton').hide();
                    $('#nextButton').show();
                    $('#parentTab').show();

                } else {
                    $('#parent-tab').hide();
                    $('#parent').hide();
                    $('#student-tab').tab('show');
                    $('#saveButton').show();
                    $('#nextButton').hide();
                    $('#parentTab').hide();
                }

                $('#studentForm').validate().destroy();
                $('#studentForm').validate({
                    rules: {
                        first_name: "required",
                        second_name: "required",
                        date_of_birth: "required",
                        email: {
                            required: true,
                            email: true,
                            remote: {
                                url: '{{ route('admin.student.checkMail') }}',
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                dataFilter: function(response) {
                                    var json = JSON.parse(response);
                                    return json.exists ? `"This email is already registered."` : true;
                                }
                            }
                        },
                        phone: {
                            required: true,
                            minlength: 10,
                            maxlength: 10,
                            digits: true
                        },
                        location_id: "required",
                        primary_instrument: "required",
                        plan: "required",
                    },
                    messages: {
                        first_name: "Please enter the first name",
                        second_name: "Please enter the second name",
                        date_of_birth: "Please select the date of birth",
                        email: {
                            required: "Please enter an email address",
                            email: "Please enter a valid email address",
                            remote: "This email is already registered."
                        },
                        phone: {
                            required: "Please enter a phone number",
                            minlength: "Phone number must be 10 digits",
                            maxlength: "Phone number must be 10 digits",
                            digits: "Please enter a valid phone number"
                        },
                        location_id: "Please select a location",
                        primary_instrument: "Please select a primary instrument",
                        plan: "Please select a plan",
                    },
                    errorClass: "error",
                    validClass: "",
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).addClass(validClass);
                    }
                });
            }

            $('#date_of_birth').on('change', toggleTabs);
            toggleTabs();

            $("#nextButton").on("click", function() {
                $('#studentForm').validate().destroy();
                $('#studentForm').validate({
                    rules: {
                        first_name: "required",
                        second_name: "required",
                        date_of_birth: "required",
                        email: {
                            // required: true,
                            email: true,
                            remote: {
                                url: '{{ route('admin.student.checkMail') }}',
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content')
                                },
                                dataFilter: function(response) {
                                    var json = JSON.parse(response);
                                    return json.exists ? `"This email is already registered."` : true;
                                }
                            }
                        },
                        phone: {
                            // required: true,
                            minlength: 10,
                            maxlength: 10,
                            digits: true
                        },
                        location_id: "required",
                        primary_instrument: "required",
                        plan: "required",
                    },
                    messages: {
                        first_name: "Please enter the first name",
                        second_name: "Please enter the second name",
                        date_of_birth: "Please select the date of birth",
                        email: {
                            required: "Please enter an email address",
                            email: "Please enter a valid email address",
                            remote: "This email is already registered."
                        },
                        phone: {
                            required: "Please enter a phone number",
                            minlength: "Phone number must be 10 digits",
                            maxlength: "Phone number must be 10 digits",
                            digits: "Please enter a valid phone number"
                        },
                        location_id: "Please select a location",
                        primary_instrument: "Please select a primary instrument",
                        plan: "Please select a plan",
                    },
                    errorClass: "error",
                    validClass: "",
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass(errorClass).removeClass(validClass);
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass(errorClass).addClass(validClass);
                    }
                });
                if ($('#studentForm').valid()) { 

                    switchToParentTab();

                    $('#studentForm').validate().destroy();
                    $('#studentForm').validate({
                        rules: {
                            first_name: "required",
                            second_name: "required",
                            date_of_birth: "required",
                            email: {
                                // required: true,
                                email: true,
                                remote: {
                                    url: '{{ route('admin.student.checkMail') }}',
                                    type: 'POST',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    dataFilter: function(response) {
                                        var json = JSON.parse(response);
                                        return json.exists ? `"This email is already registered."` : true;
                                    }
                                }
                            },
                            phone: {
                                // required: true,
                                minlength: 10,
                                maxlength: 10,
                                digits: true
                            },
                            location_id: "required",
                            primary_instrument: "required",
                            plan: "required",
                            parent_first_name: {
                                required: true
                            },
                            parent_second_name: {
                                required: true
                            },
                            parent_email: {
                                required: true,
                                email: true,
                                remote: {
                                    url: '{{ route('admin.student.checkMail') }}',
                                    type: 'POST',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content')
                                    },
                                    dataFilter: function(response) {
                                        var json = JSON.parse(response);
                                        return json.exists ? `"This email is already registered."` : true;
                                    }
                                }
                            },
                            parent_phone: {
                                required: true,
                                minlength: 10,
                                maxlength: 10,
                                digits: true
                            }
                        },
                        messages: {
                            first_name: "Please enter the first name",
                            second_name: "Please enter the second name",
                            date_of_birth: "Please select the date of birth",
                            email: {
                                required: "Please enter an email address",
                                email: "Please enter a valid email address",
                                remote: "This email is already registered."
                            },
                            phone: {
                                required: "Please enter a phone number",
                                minlength: "Phone number must be 10 digits",
                                maxlength: "Phone number must be 10 digits",
                                digits: "Please enter a valid phone number"
                            },
                            location_id: "Please select a location",
                            primary_instrument: "Please select a primary instrument",
                            plan: "Please select a plan",
                            parent_first_name: "Please enter the parent's first name",
                            parent_second_name: "Please enter the parent's second name",
                            parent_email: {
                                required: "Please enter the parent's email address",
                                email: "Please enter a valid email address"
                            },
                            parent_phone: {
                                required: "Please enter the parent's phone number",
                                minlength: "Phone number must be 10 digits",
                                maxlength: "Phone number must be 10 digits",
                                digits: "Please enter a valid phone number"
                            }
                        },
                        errorClass: "error",
                        validClass: "",
                        highlight: function(element, errorClass, validClass) {
                            $(element).addClass(errorClass).removeClass(validClass);
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).removeClass(errorClass).addClass(validClass);
                        }
                    });
                } 
            });

            $("#saveButton").on("click", function(event) {
                event.preventDefault();
                if ($('#studentForm').valid()) {
                    $("#saveButton").prop('disabled', true);
                    $('#studentForm').submit();
                } else {
                    $("#saveButton").prop('disabled', false);
                }
            });

            $("#parentSubmitButton").on("click", function(event) {
                event.preventDefault();
                if ($('#studentForm').valid()) {
                    $("#parentSubmitButton").prop('disabled', true);
                    $('#studentForm').submit();
                } else {
                    $("#parentSubmitButton").prop('disabled', false);
                }
            });
        });
    </script>
@endsection
