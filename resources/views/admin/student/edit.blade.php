@extends('admin.layouts.app')
@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Student</h6>
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
            <li class="fw-medium">Edit</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <form action="{{ route('admin.student.update') }}" method="POST" id="studentForm"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="age" id="age">
                <input type="hidden" name="id" value="{{ $student->id ?? '' }}">
                <input type="hidden" name="user_id" value="{{ $student->user_id ?? '' }}">
                <input type="hidden" name="parent_user_id" value="{{ $student->parentInfo->user_id ?? '' }}">
                <input type="hidden" name="student_plan" value="{{ $student->plan ?? '' }}">
                <!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="true">Student</button>
                        </li>
                        <li class="nav-item" role="presentation" id="parentTab">
                            <button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button" role="tab" aria-controls="parent" aria-selected="false" disabled>Parent</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="cardDetails-tab" data-bs-toggle="tab" data-bs-target="#cardDetails" type="button" role="tab" aria-controls="CardDetails" aria-selected="false" disabled>Card Details</button>
                        </li>
                    </ul> -->

                <ul class="nav border-gradient-tab nav-pills d-inline-flex mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center px-24 active" id="student-tab"
                            data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab"
                            aria-controls="student" aria-selected="true">
                            Student
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" id="parentTab">
                        <button class="nav-link d-flex align-items-center px-24" id="parent-tab" data-bs-toggle="tab"
                            data-bs-target="#parent" type="button" role="tab" aria-controls="parent"
                            aria-selected="false" disabled tabindex="-1">
                            Parent
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center px-24" id="cardDetails-tab"
                            data-bs-toggle="tab" data-bs-target="#cardDetails" type="button" role="tab"
                            aria-controls="CardDetails" aria-selected="false" disabled>
                            Card Details
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="myTabContent">
                    {{-- Student Tab --}}
                    <div class="tab-pane fade show active" id="student" role="tabpanel" aria-labelledby="student-tab">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <label for="first_name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('first_name') is-invalid @enderror"
                                    name="first_name" id="first_name" placeholder="First Name" maxlength="100"
                                    value="{{ $student->userInfo->first_name ?? '' }}">
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="second_name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('second_name') is-invalid @enderror"
                                    name="second_name" id="second_name" placeholder="Second Name" maxlength="100"
                                    value="{{ $student->userInfo->second_name ?? '' }}">
                                @error('second_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="date_of_birth"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Date Of Birth <span
                                        class="text-danger-600">*</span></label>
                                <input type="date"
                                    class="form-control radius-8 @error('date_of_birth') is-invalid @enderror"
                                    name="date_of_birth" id="date_of_birth" placeholder="Date Of Birth"
                                    value="{{ $student->date_of_birth ?? '' }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6"> 
                                <label for="email"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                    <span class="text-danger-600">*</span></label>
                                <input type="email"
                                    class="form-control radius-8 @error('email') is-invalid @enderror" name="email"
                                    id="email" placeholder="Email address" maxlength="100"
                                    value="{{ $student->userInfo->email ?? '' }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror 
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone
                                    <span class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror"
                                    name="phone" id="phone" placeholder="Phone" minlength="10" maxlength="10"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"
                                    value="{{ $student->userInfo->phone ?? '' }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="primary_instrument"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Primary Instrument
                                    <span class="text-danger-600">*</span></label>
                                <select name="primary_instrument[]" id="primary_instrument" class="form-control select2" multiple="multiple">
                                    @if(isset($instruments))
                                        @foreach ($instruments as $instrument)
                                            <option value="{{ $instrument->id }}" {{ in_array($instrument->id, $selectedInstruments) ? 'selected' : '' }}>
                                                {{ $instrument->name }}
                                            </option>
                                        @endforeach
                                    @endif

                                </select>
                                @error('primary_instrument[]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <label id="primary_instrument-error" class="error" for="primary_instrument"></label>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="location_id"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Location <span
                                        class="text-danger-600">*</span></label>
                                <select name="location_id" id="location_id" class="form-control">
                                    @if (isset($locations))
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}" @if ($location->id == $student->location_id)
                                            selected @endif>{{ $location->name }}</option>
                                        @endforeach
                                    @endif

                                </select>
                                @error('location_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="plan" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Plan <span class="text-danger-600">*</span>
                                </label>
                                <select name="plan" id="plan" class="form-control">
                                    <option value="">Select Plan</option>
                                </select>
                                @error('plan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="col-lg-4 col-md-6">
                                <label for="plan" class="form-label fw-semibold text-primary-light text-sm mb-8">Plan
                                    <span class="text-danger-600">*</span></label>
                                <select name="plan" id="plan" class="form-control">
                                    @if (isset($subscriptionTypes))
                                    @foreach ($subscriptionTypes as $subscriptionType)
                                    <option value="{{ $subscriptionType->id }}" @if ($subscriptionType->id ==
                                        $student->plan) selected @endif>
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
                            </div> --}}
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3 submit-button">
                            {{-- <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                id="saveButton">Save</button> --}}
                            <button type="button"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                id="studentNextButton">Next</button>
                        </div>
                    </div>

                    {{-- Parent Tab --}}
                    <div class="tab-pane fade" id="parent" role="tabpanel" aria-labelledby="parent-tab">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <label for="parent_first_name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('parent_first_name') is-invalid @enderror"
                                    name="parent_first_name" id="parent_first_name" placeholder="First Name"
                                    maxlength="100" value="{{ $student->parentInfo->userInfo->first_name ?? '' }}">
                                @error('parent_first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="parent_second_name"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('parent_second_name') is-invalid @enderror"
                                    name="parent_second_name" id="parent_second_name" placeholder="Second Name"
                                    maxlength="100" value="{{ $student->parentInfo->userInfo->second_name ?? '' }}">
                                @error('parent_second_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6"> 
                                <label for="parent_email"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span
                                        class="text-danger-600">*</span></label>
                                <input type="parent_email"
                                    class="form-control radius-8 @error('parent_email') is-invalid @enderror"
                                    name="parent_email" id="parent_email" placeholder="Email address"
                                    maxlength="100" value="{{ $student->parentInfo->userInfo->email ?? '' }}">
                                @error('parent_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror 
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="parent_phone"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('parent_phone') is-invalid @enderror"
                                    name="parent_phone" id="parent_phone" placeholder="Phone" minlength="10"
                                    maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')"
                                    value="{{ $student->parentInfo->userInfo->phone ?? '' }}">
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3 submit-button">
                            {{-- <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                id="parentSubmitButton">Save</button> --}}
                            <button type="button"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                id="parentNextButton">Next</button>
                        </div>
                    </div>

                    {{-- Card Details Tab --}}
                    <div class="tab-pane fade" id="cardDetails" role="tabpanel" aria-labelledby="cardDetails-tab">
                        <div class="row gy-4">
                            <div class="col-lg-4 col-md-6">
                                <label for="card_number"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Card Number <span
                                        class="text-danger-600">*</span></label>
                                <input type="text"
                                    class="form-control radius-8 @error('card_number') is-invalid @enderror"
                                    name="card_number" id="card_number" placeholder="Card Number"
                                    value="{{ $cardDetails->card_number ?? '' }}" minlength="16" maxlength="16"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                @error('card_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="expiry_month"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Month<span
                                        class="text-danger-600">*</span></label>
                                <select name="expiry_month" id="expiry_month" class="form-control">
                                    <option value="">Select Month</option>
                                    <option value="1" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "1") selected @endif>January
                                    </option>
                                    <option value="2" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "2") selected @endif>February
                                    </option>
                                    <option value="3" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "3") selected @endif>March
                                    </option>
                                    <option value="4" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "4") selected @endif>April
                                    </option>
                                    <option value="5" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "5") selected @endif>May</option>
                                    <option value="6" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "6") selected @endif>June
                                    </option>
                                    <option value="7" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "7") selected @endif>July
                                    </option>
                                    <option value="8" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "8") selected @endif>August
                                    </option>
                                    <option value="9" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "9") selected @endif>September
                                    </option>
                                    <option value="10" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "10") selected @endif>October
                                    </option>
                                    <option value="11" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "11") selected @endif>November
                                    </option>
                                    <option value="12" @if (isset($cardDetails->expiry_month) && $cardDetails->expiry_month == "12") selected @endif>December
                                    </option>
                                </select>
                                @error('expiry_month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <label for="expiry_year"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Year<span
                                        class="text-danger-600">*</span></label>
                                <select name="expiry_year" id="expiry_year" class="form-control">
                                    <option value="">Select year</option>
                                    <option value="2024" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2024") selected @endif>2024
                                    </option>
                                    <option value="2025" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2025") selected @endif>2025
                                    </option>
                                    <option value="2026" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2026") selected @endif>2026
                                    </option>
                                    <option value="2027" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2027") selected @endif>2027
                                    </option>
                                    <option value="2028" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2028") selected @endif>2028
                                    </option>
                                    <option value="2029" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2029") selected @endif>2029
                                    </option>
                                    <option value="2030" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2030") selected @endif>2030
                                    </option>
                                    <option value="2031" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2031") selected @endif>2031
                                    </option>
                                    <option value="2032" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2032") selected @endif>2032
                                    </option>
                                    <option value="2033" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2033") selected @endif>2033
                                    </option>
                                    <option value="2034" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2034") selected @endif>2034
                                    </option>
                                    <option value="2035" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2035") selected @endif>2035
                                    </option>
                                    <option value="2036" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2036") selected @endif>2036
                                    </option>
                                    <option value="2037" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2037") selected @endif>2037
                                    </option>
                                    <option value="2038" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2038") selected @endif>2038
                                    </option>
                                    <option value="2039" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2039") selected @endif>2039
                                    </option>
                                    <option value="2040" @if (isset($cardDetails->expiry_year) && $cardDetails->expiry_year == "2040") selected @endif>2040
                                    </option>
                                </select>
                                @error('expiry_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-6"> 
                                <label for="cvv" class="form-label fw-semibold text-primary-light text-sm mb-8">CVV
                                    <span class="text-danger-600">*</span></label>
                                <input type="cvv" class="form-control radius-8 @error('cvv') is-invalid @enderror"
                                    name="cvv" id="cvv" placeholder="CVV" value="{{ $cardDetails->cvv ?? '' }}"
                                    minlength="3" maxlength="3"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                @error('cvv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror 
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3 submit-button">
                            <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8"
                                id="SubmitButton">Save</button>
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

                $('.select2').select2({
                    placeholder: "Select Instrument(s)",
                    allowClear: true
                });

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
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    id: function() {
                                        return $('input[name="user_id"]').val();
                                    }
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
                        'primary_instrument[]': "required",
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
                        'primary_instrument[]': "Please select a primary instrument",
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
                    $('#parent').css('display','block');
                }

                function switchToCardDetailsTab() {
                    $('#cardDetails-tab').tab('show');
                    $('#student-tab').removeClass('active');
                    $('#parent-tab').removeClass('active');
                    $('#cardDetails-tab').addClass('active');
                    $('#student').removeClass('show active');
                    $('#parent').removeClass('show active');
                    $('#cardDetails').addClass('show active');
                    $('#parent').css('display','none');
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
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            id: function() {
                                                return $('input[name="user_id"]').val();
                                            }
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
                                'primary_instrument[]': "required",
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
                                'primary_instrument[]': "Please select a primary instrument",
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
                        $('#parent-tab').show();
                        $('#parent').show();
                        $('#student-tab').tab('show');
                        // $('#saveButton').hide();
                        // $('#nextButton').show();
                        $('#parentTab').show();

                    } else {
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
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            id: function() {
                                                return $('input[name="user_id"]').val();
                                            }
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
                                'primary_instrument[]': "required",
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
                                'primary_instrument[]': "Please select a primary instrument",
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
                        $('#parent-tab').hide();
                        $('#parent').hide();
                        $('#student-tab').tab('show');
                        // $('#saveButton').show();
                        // $('#nextButton').hide();
                        $('#parentTab').hide();
                    }

                    // $('#studentForm').validate().destroy();
                    // $('#studentForm').validate({
                    //     rules: {
                    //         first_name: "required",
                    //         second_name: "required",
                    //         date_of_birth: "required",
                            // email: {
                            //     required: true,
                            //     email: true,
                            //     remote: {
                            //         url: '{{ route('admin.student.checkMail') }}',
                            //         type: 'POST',
                            //         data: {
                            //             _token: $('meta[name="csrf-token"]').attr('content'),
                            //             id: function() {
                            //                 return $('input[name="user_id"]').val();
                            //             }
                            //         },
                            //         dataFilter: function(response) {
                            //             var json = JSON.parse(response);
                            //             return json.exists ? `"This email is already registered."` : true;
                            //         }
                            //     }
                            // },
                    //         phone: {
                    //             required: true,
                    //             minlength: 10,
                    //             maxlength: 10,
                    //             digits: true
                    //         },
                    //         location_id: "required",
                    //         primary_instrument: "required",
                    //         plan: "required",
                    //     },
                    //     messages: {
                    //         first_name: "Please enter the first name",
                    //         second_name: "Please enter the second name",
                    //         date_of_birth: "Please select the date of birth",
                    //         email: {
                    //             required: "Please enter an email address",
                    //             email: "Please enter a valid email address",
                    //             remote: "This email is already registered."
                    //         },
                    //         phone: {
                    //             required: "Please enter a phone number",
                    //             minlength: "Phone number must be 10 digits",
                    //             maxlength: "Phone number must be 10 digits",
                    //             digits: "Please enter a valid phone number"
                    //         },
                    //         location_id: "Please select a location",
                    //         primary_instrument: "Please select a primary instrument",
                    //         plan: "Please select a plan",
                    //     },
                    //     errorClass: "error",
                    //     validClass: "",
                    //     highlight: function(element, errorClass, validClass) {
                    //         $(element).addClass(errorClass).removeClass(validClass);
                    //     },
                    //     unhighlight: function(element, errorClass, validClass) {
                    //         $(element).removeClass(errorClass).addClass(validClass);
                    //     }
                    // });
                }

                $('#date_of_birth').on('change', toggleTabs);
                toggleTabs();

                $("#studentNextButton").on("click", function() {
                    if ($('#studentForm').valid()) { 
                        const dob = $('#date_of_birth').val();
                        const age = calculateAge(dob);
                        if (age < 18) {
                            switchToParentTab();
                        } else {
                            switchToCardDetailsTab();
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
                                                _token: $('meta[name="csrf-token"]').attr('content'),
                                                id: function() {
                                                    return $('input[name="user_id"]').val();
                                                }
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
                                    'primary_instrument[]': "required",
                                    plan: "required",
                                    // parent_first_name: {
                                    //     required: true
                                    // },
                                    // parent_second_name: {
                                    //     required: true
                                    // },
                                    // parent_email: {
                                    //     required: true,
                                    //     email: true,
                                    //     remote: {
                                    //         url: '{{ route('admin.student.checkMail') }}',
                                    //         type: 'POST',
                                    //         data: {
                                    //             _token: $('meta[name="csrf-token"]').attr('content')
                                    //         },
                                    //         dataFilter: function(response) {
                                    //             var json = JSON.parse(response);
                                    //             return json.exists ? `"This email is already registered."` : true;
                                    //         }
                                    //     }
                                    // },
                                    // parent_phone: {
                                    //     required: true,
                                    //     minlength: 10,
                                    //     maxlength: 10,
                                    //     digits: true
                                    // },
                                    card_number:{
                                        required:true,
                                        minlength: 16,
                                        maxlength: 16,
                                        digits: true
                                    },
                                    expiry_month:{
                                        required:true,
                                    },
                                    expiry_year:{
                                        required:true,
                                    },
                                    cvv:{
                                        required:true,
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
                                    'primary_instrument[]': "Please select a primary instrument",
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
                                    },
                                    card_number:{
                                        required: "Please enter card number",
                                    },
                                    expiry_month:{
                                        required: "Please enter month",
                                    },
                                    expiry_year:{
                                        required: "Please enter year",
                                    },
                                    cvv:{
                                        required: "Please enter CVV",
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
                    } 
                });

                $("#parentNextButton").on("click", function() {
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
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        id: function() {
                                            return $('input[name="user_id"]').val();
                                        }
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
                            'primary_instrument[]': "required",
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
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        id: function() {
                                            return $('input[name="user_id"]').val();
                                        }
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
                            },
                            card_number:{
                                required:true,
                                minlength: 16,
                                maxlength: 16,
                                digits: true
                            },
                            expiry_month:{
                                required:true,
                            },
                            expiry_year:{
                                required:true,
                            },
                            cvv:{
                                required:true,
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
                            'primary_instrument[]': "Please select a primary instrument",
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
                            },
                            card_number:{
                                required: "Please enter card number",
                            },
                            expiry_month:{
                                required: "Please select month",
                            },
                            expiry_year:{
                                required: "Please select year",
                            },
                            cvv:{
                                required: "Please enter CVV",
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
                    if ($('#studentForm').valid()) { 

                        switchToCardDetailsTab();

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
                                            _token: $('meta[name="csrf-token"]').attr('content'),
                                            id: function() {
                                                return $('input[name="user_id"]').val();
                                            }
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
                                'primary_instrument[]': "required",
                                plan: "required",
                                // parent_first_name: {
                                //     required: true
                                // },
                                // parent_second_name: {
                                //     required: true
                                // },
                                // parent_email: {
                                //     required: true,
                                //     email: true,
                                //     remote: {
                                //         url: '{{ route('admin.student.checkMail') }}',
                                //         type: 'POST',
                                //         data: {
                                //             _token: $('meta[name="csrf-token"]').attr('content')
                                //         },
                                //         dataFilter: function(response) {
                                //             var json = JSON.parse(response);
                                //             return json.exists ? `"This email is already registered."` : true;
                                //         }
                                //     }
                                // },
                                // parent_phone: {
                                //     required: true,
                                //     minlength: 10,
                                //     maxlength: 10,
                                //     digits: true
                                // },
                                card_number:{
                                    required:true,
                                    minlength: 16,
                                    maxlength: 16,
                                    digits: true
                                },
                                expiry_month:{
                                    required:true,
                                },
                                expiry_year:{
                                    required:true,
                                },
                                cvv:{
                                    required:true,
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
                                'primary_instrument[]': "Please select a primary instrument",
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
                                },
                                card_number:{
                                    required: "Please enter card number",
                                },
                                expiry_month:{
                                    required: "Please enter month",
                                },
                                expiry_year:{
                                    required: "Please enter year",
                                },
                                cvv:{
                                    required: "Please enter CVV",
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

                // $("#nextButton").on("click", function() {
                //     $('#studentForm').validate().destroy();
                //     $('#studentForm').validate({
                //         rules: {
                //             first_name: "required",
                //             second_name: "required",
                //             date_of_birth: "required",
                //             email: {
                //                 // required: true,
                //                 email: true,
                //                 remote: {
                //                     url: '{{ route('admin.student.checkMail') }}',
                //                     type: 'POST',
                //                     data: {
                //                         _token: $('meta[name="csrf-token"]').attr('content'),
                //                         id: function() {
                //                             return $('input[name="user_id"]').val();
                //                         }
                //                     },
                //                     dataFilter: function(response) {
                //                         var json = JSON.parse(response);
                //                         return json.exists ? `"This email is already registered."` : true;
                //                     }
                //                 }
                //             },
                //             phone: {
                //                 // required: true,
                //                 minlength: 10,
                //                 maxlength: 10,
                //                 digits: true
                //             },
                //             location_id: "required",
                //             primary_instrument: "required",
                //             plan: "required",
                //         },
                //         messages: {
                //             first_name: "Please enter the first name",
                //             second_name: "Please enter the second name",
                //             date_of_birth: "Please select the date of birth",
                //             email: {
                //                 required: "Please enter an email address",
                //                 email: "Please enter a valid email address",
                //                 remote: "This email is already registered."
                //             },
                //             phone: {
                //                 required: "Please enter a phone number",
                //                 minlength: "Phone number must be 10 digits",
                //                 maxlength: "Phone number must be 10 digits",
                //                 digits: "Please enter a valid phone number"
                //             },
                //             location_id: "Please select a location",
                //             primary_instrument: "Please select a primary instrument",
                //             plan: "Please select a plan",
                //         },
                //         errorClass: "error",
                //         validClass: "",
                //         highlight: function(element, errorClass, validClass) {
                //             $(element).addClass(errorClass).removeClass(validClass);
                //         },
                //         unhighlight: function(element, errorClass, validClass) {
                //             $(element).removeClass(errorClass).addClass(validClass);
                //         }
                //     });
                //     if ($('#studentForm').valid()) { 

                //         switchToParentTab();

                //         $('#studentForm').validate().destroy();
                //         $('#studentForm').validate({
                //             rules: {
                //                 first_name: "required",
                //                 second_name: "required",
                //                 date_of_birth: "required",
                //                 email: {
                //                     // required: true,
                //                     email: true,
                //                     remote: {
                //                         url: '{{ route('admin.student.checkMail') }}',
                //                         type: 'POST',
                //                         data: {
                //                             _token: $('meta[name="csrf-token"]').attr('content'),
                //                             id: function() {
                //                                 return $('input[name="user_id"]').val();
                //                             }
                //                         },
                //                         dataFilter: function(response) {
                //                             var json = JSON.parse(response);
                //                             return json.exists ? `"This email is already registered."` : true;
                //                         }
                //                     }
                //                 },
                //                 phone: {
                //                     // required: true,
                //                     minlength: 10,
                //                     maxlength: 10,
                //                     digits: true
                //                 },
                //                 location_id: "required",
                //                 primary_instrument: "required",
                //                 plan: "required",
                //                 parent_first_name: {
                //                     required: true
                //                 },
                //                 parent_second_name: {
                //                     required: true
                //                 },
                //                 parent_email: {
                //                     required: true,
                //                     email: true,
                //                     remote: {
                //                         url: '{{ route('admin.student.checkMail') }}',
                //                         type: 'POST',
                //                         data: {
                //                             _token: $('meta[name="csrf-token"]').attr('content'),
                //                             id: function() {
                //                                 return $('input[name="parent_user_id"]').val();
                //                             }
                //                         },
                //                         dataFilter: function(response) {
                //                             var json = JSON.parse(response);
                //                             return json.exists ? `"This email is already registered."` : true;
                //                         }
                //                     }
                //                 },
                //                 parent_phone: {
                //                     required: true,
                //                     minlength: 10,
                //                     maxlength: 10,
                //                     digits: true
                //                 }
                //             },
                //             messages: {
                //                 first_name: "Please enter the first name",
                //                 second_name: "Please enter the second name",
                //                 date_of_birth: "Please select the date of birth",
                //                 email: {
                //                     required: "Please enter an email address",
                //                     email: "Please enter a valid email address",
                //                     remote: "This email is already registered."
                //                 },
                //                 phone: {
                //                     required: "Please enter a phone number",
                //                     minlength: "Phone number must be 10 digits",
                //                     maxlength: "Phone number must be 10 digits",
                //                     digits: "Please enter a valid phone number"
                //                 },
                //                 location_id: "Please select a location",
                //                 primary_instrument: "Please select a primary instrument",
                //                 plan: "Please select a plan",
                //                 parent_first_name: "Please enter the parent's first name",
                //                 parent_second_name: "Please enter the parent's second name",
                //                 parent_email: {
                //                     required: "Please enter the parent's email address",
                //                     email: "Please enter a valid email address"
                //                 },
                //                 parent_phone: {
                //                     required: "Please enter the parent's phone number",
                //                     minlength: "Phone number must be 10 digits",
                //                     maxlength: "Phone number must be 10 digits",
                //                     digits: "Please enter a valid phone number"
                //                 }
                //             },
                //             errorClass: "error",
                //             validClass: "",
                //             highlight: function(element, errorClass, validClass) {
                //                 $(element).addClass(errorClass).removeClass(validClass);
                //             },
                //             unhighlight: function(element, errorClass, validClass) {
                //                 $(element).removeClass(errorClass).addClass(validClass);
                //             }
                //         });
                //     } 
                // });

                // $("#saveButton").on("click", function(event) {
                //     event.preventDefault();
                //     if ($('#studentForm').valid()) {
                //         $("#saveButton").prop('disabled', true);
                //         $('#studentForm').submit();
                //     } else {
                //         $("#saveButton").prop('disabled', false);
                //     }
                // });

                // $("#parentSubmitButton").on("click", function(event) {
                //     event.preventDefault();
                //     if ($('#studentForm').valid()) {
                //         $("#parentSubmitButton").prop('disabled', true);
                //         $('#studentForm').submit();
                //     } else {
                //         $("#parentSubmitButton").prop('disabled', false);
                //     }
                // });

                $("#SubmitButton").on("click", function(event) {
                    event.preventDefault();
                    if ($('#studentForm').valid()) {
                        $("#SubmitButton").prop('disabled', true);
                        $('#studentForm').submit();
                    } else {
                        $("#SubmitButton").prop('disabled', false);
                    }
                });

                function populatePlans(locationId) {
                    $('#plan').empty();
                    
                    if (locationId) {
                        $.ajax({
                            url: '{{ route('admin.student.subscriptions.getByLocation', ['locationId' => '__locationId__']) }}'.replace('__locationId__', locationId),
                            method: 'GET',
                            success: function(data) {
                                console.log('AJAX Success:', data);

                                var studentPlan = $('input[name="student_plan"]').val();
                                
                                if (data.length > 0) {
                                    $('#plan').append('<option value="">Select Plan</option>');
                                    
                                    $.each(data, function(index, subscriptionType) {
                                        var isSelected = subscriptionType.id == studentPlan ? 'selected' : '';
                                        $('#plan').append(
                                            '<option value="' + subscriptionType.id + '" ' + isSelected + '>' +
                                            (subscriptionType.subscription_info.name ?? '') + ' (' +
                                            (subscriptionType.amount ?? '') + ') (' +
                                            (subscriptionType.billing_period_name ?? '') + ') (' +
                                            (subscriptionType.discount ?? '') + '% Discount)' +
                                            '</option>'
                                        );
                                    });
                                } else {
                                    $('#plan').append('<option value="">No Plans Available</option>');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', status, error);
                                $('#plan').append('<option value="">Select Plan</option>');
                            }
                        });
                    } else {
                        $('#plan').append('<option value="">Select Plan</option>');
                    }
                }

                $('#location_id').change(function() {
                    var locationId = $(this).val();
                    populatePlans(locationId);
                });

                var initialLocationId = $('#location_id').val();
                if (initialLocationId) {
                    populatePlans(initialLocationId);
                }
            });
    </script>
@endsection
