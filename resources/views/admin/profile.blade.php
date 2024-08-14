@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">View Profile</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{route('admin.dashboard')}}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">View Profile</li>
            </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="{{ asset('assets/images/user-grid/user-grid-bg1.png')}}" alt=""
                        class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="{{ (!empty($user->profile_image) && file_exists($user->profile_image)) ? asset($user->profile_image) :  asset('assets/images/user-grid/user-grid-img13.png') }}" alt="" 
                            class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mb-0 mt-16">{{ $user->fullName ?? '' }}</h6>
                            <span class="text-secondary-light mb-16">{{ $user->email ?? '' }}</span>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->fullName ?? '' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">:
                                        {{ $user->email ?? '' }}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{ $user->phone ?? '' }}</span>
                                </li>
                                {{-- <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Design</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Designation</span>
                                    <span class="w-70 text-secondary-light fw-medium">: UI UX Designer</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Languages</span>
                                    <span class="w-70 text-secondary-light fw-medium">: English</span>
                                </li>
                                <li class="d-flex align-items-center gap-1">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Bio</span>
                                    <span class="w-70 text-secondary-light fw-medium">: Lorem Ipsum is simply dummy
                                        text of the printing and typesetting industry.</span>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab"
                            role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24 active"
                                    id="pills-edit-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-edit-profile" type="button" role="tab"
                                    aria-controls="pills-edit-profile" aria-selected="true">
                                    Edit Profile
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24"
                                    id="pills-change-passwork-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-change-passwork" type="button" role="tab"
                                    aria-controls="pills-change-passwork" aria-selected="false" tabindex="-1">
                                    Change Password
                                </button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center px-24"
                                    id="pills-notification-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-notification" type="button" role="tab"
                                    aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                    Notification Settings
                                </button>
                            </li> --}}
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel"
                                    aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                    <h6 class="text-md text-primary-light mb-16">Profile Image</h6>
                                    <form action="{{route('admin.profile.update')}}" method="POST" id="profileForm" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <!-- Upload Image Start -->
                                        <div class="mb-24 mt-16">
                                            <div class="avatar-upload">
                                                <div
                                                    class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">

                                                    <label for="imageUpload"
                                                        class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
                                                        <iconify-icon icon="solar:camera-outline"
                                                            class="icon"></iconify-icon>
                                                    </label>
                                                </div>
                                                <div class="avatar-preview">
                                                    <div id="imagePreview" style="background-image: url('{{ (!empty($user->profile_image) && file_exists($user->profile_image)) ? asset($user->profile_image) : asset('assets/images/user-grid/user-grid-img13.png') }}');"> 
                                                    </div>
                                                    <input type='file' id="imageUpload" class="@error('image') is-invalid @enderror" name="image" accept=".png, .jpg, .jpeg"
                                                        hidden/>
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div id="imageError" class="error-message" style="color: red; display: none;"></div>
                                        </div>
                                        <!-- Upload Image End -->
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="name"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">First
                                                        Name <span class="text-danger-600">*</span></label>
                                                    <input type="text" class="form-control radius-8 @error('first_name') is-invalid @enderror" name="first_name"
                                                        id="first_name" value="{{ $user->first_name ?? '' }}" placeholder="First Name" maxlength="100">
                                                        @error('first_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="name"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Second
                                                        Name <span class="text-danger-600">*</span></label>
                                                    <input type="text" class="form-control radius-8 @error('second_name') is-invalid @enderror" name="second_name"
                                                        id="second_name" value="{{ $user->second_name ?? '' }}" placeholder="First Name" maxlength="100">
                                                        @error('second_name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="email"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                                        <span class="text-danger-600">*</span></label>
                                                    <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" name="email"
                                                        id="email" value="{{ $user->email ?? '' }}" placeholder="Enter email address" maxlength="100">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="number"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
                                                    <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" name="phone"
                                                        id="phone" value="{{ $user->phone ?? '' }}" placeholder="Enter phone number" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                                        onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="depart"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Department
                                                        <span class="text-danger-600">*</span> </label>
                                                    <select class="form-control radius-8 form-select" id="depart">
                                                        <option>Enter Event Title </option>
                                                        <option>Enter Event Title One </option>
                                                        <option>Enter Event Title Two</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="desig"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Designation
                                                        <span class="text-danger-600">*</span> </label>
                                                    <select class="form-control radius-8 form-select" id="desig">
                                                        <option>Enter Designation Title </option>
                                                        <option>Enter Designation Title One </option>
                                                        <option>Enter Designation Title Two</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-20">
                                                    <label for="Language"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Language
                                                        <span class="text-danger-600">*</span> </label>
                                                    <select class="form-control radius-8 form-select" id="Language">
                                                        <option> English</option>
                                                        <option> Bangla </option>
                                                        <option> Hindi</option>
                                                        <option> Arabic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="mb-20">
                                                    <label for="desc"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                                                    <textarea name="#0" class="form-control radius-8" id="desc" placeholder="Write description..."></textarea>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center gap-3">
                                            <button type="button"
                                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="saveButton">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            <form action="{{route('admin.password.update')}}" method="POST" id="PasswordForm">
                                @csrf
                                <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel"
                                    aria-labelledby="pills-change-passwork-tab" tabindex="0">
                                    <div class="mb-20">
                                        <label for="newPassword"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">New Password
                                            <span class="text-danger-600">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control radius-8" id="newPassword" name="newPassword"
                                                placeholder="Enter New Password*" minlength="6" maxlength="30" required>
                                            <span
                                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                data-toggle="#newPassword"></span>
                                        </div>
                                    </div>
                                    <div class="mb-20">
                                        <label for="confirmPassword"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Confirmed
                                            Password <span class="text-danger-600">*</span></label>
                                        <div class="position-relative">
                                            <input type="password" class="form-control radius-8"
                                                id="confirmPassword" name="confirmPassword" placeholder="Confirm Password*" minlength="6" maxlength="30" required>
                                            <span
                                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                                data-toggle="#confirmPassword"></span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <button type="button"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                            class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
                                            Save
                                        </button>
                                    </div>
                                </div>  
                            </form>

                            {{-- <div class="tab-pane fade" id="pills-notification" role="tabpanel"
                                aria-labelledby="pills-notification-tab" tabindex="0">
                                <div
                                    class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="companzNew"
                                        class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span
                                            class="form-check-label line-height-1 fw-medium text-secondary-light">Company
                                            News</span>
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="companzNew">
                                    </div>
                                </div>
                                <div
                                    class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="pushNotifcation"
                                        class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span
                                            class="form-check-label line-height-1 fw-medium text-secondary-light">Push
                                            Notification</span>
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="pushNotifcation" checked>
                                    </div>
                                </div>
                                <div
                                    class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="weeklyLetters"
                                        class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span
                                            class="form-check-label line-height-1 fw-medium text-secondary-light">Weekly
                                            News Letters</span>
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="weeklyLetters" checked>
                                    </div>
                                </div>
                                <div
                                    class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="meetUp"
                                        class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span
                                            class="form-check-label line-height-1 fw-medium text-secondary-light">Meetups
                                            Near you</span>
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="meetUp">
                                    </div>
                                </div>
                                <div
                                    class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="orderNotification"
                                        class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span
                                            class="form-check-label line-height-1 fw-medium text-secondary-light">Orders
                                            Notifications</span>
                                        <input class="form-check-input" type="checkbox" role="switch"
                                            id="orderNotification" checked>
                                    </div>
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    
    <script>
        $(document).ready(function() {

            $.validator.addMethod('extension', function(value, element, param) {
                var allowedExtensions = param.split('|');
                var fileExtension = value.split('.').pop().toLowerCase();
                return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
            }, 'Invalid file extension.');

            $('#profileForm').validate({
                rules: {
                    image: {
                        extension: "png|jpg|jpeg", 
                    },
                    first_name: {
                        required: true,
                    },
                    second_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ route('admin.teacher.checkMail') }}',
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
                    },
                },
                messages: {
                    image: {
                        extension: "Please upload a valid image (png, jpg, jpeg)."
                    },
                    first_name: {
                        required: 'Please enter first name',
                    },
                    second_name: {
                        required: 'Please enter second name',
                    },
                    email: {
                        required: 'Please enter email',
                        email: 'Please enter a valid email',
                    },
                    phone: {
                        required: 'Please enter phone number',
                    },
                },
                submitHandler: function(form) {
                    var fileInput = $('#profileForm').find('input[type="file"]')[0];
                    if (fileInput && fileInput.files.length > 0) {
                        var fileInputValid = validateFile(fileInput);

                        if (fileInputValid) {
                            $("#saveButton").prop('disabled', true);
                            form.submit();
                        }
                    } else {
                        $("#saveButton").prop('disabled', true);
                        form.submit();
                    }
                }
            });

            function validateFile(input) {
                var file = input.files[0];
                var isValid = true;
                var errorMessage = '';

                if (file) {
                    var fileName = file.name;
                    var allowedExtensions = ['png', 'jpg', 'jpeg'];
                    var fileExtension = fileName.split('.').pop().toLowerCase();

                    if (!allowedExtensions.includes(fileExtension)) {
                        errorMessage = 'Please upload a valid image (.png, .jpg, .jpeg).';
                        isValid = false;
                    }

                    // var fileSize = file.size / 1024 / 1024;
                    // if (fileSize > 2) {
                    //     errorMessage = 'File size must be less than 2 MB.';
                    //     isValid = false;
                    // }
                }

                // Display error message
                if (isValid) {
                    $('#imageError').text('').hide();
                } else {
                    $('#imageError').text(errorMessage).show();
                }

                return isValid;
            }

            // Attach event handler to file input
            $('#profileForm').on('change', 'input[type="file"]', function() {
                validateFile(this);
            });



            $('#PasswordForm').validate({
                rules: {
                    newPassword: {
                        required: true
                    },
                    confirmPassword: {
                        required: true,
                        equalTo: "#newPassword"
                    },
                },
                messages: {
                    newPassword: {
                        required: 'Please enter password',
                    },
                    confirmPassword: {
                        required: 'Please enter confirm password',
                        equalTo: 'Passwords do not match'
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        // ======================== Upload Image Start =====================
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
        // ======================== Upload Image End =====================

        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle('.toggle-password');
        // ========================= Password Show Hide Js End ===========================
    </script>
@endsection
