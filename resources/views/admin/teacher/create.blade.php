@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Teacher</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.teacher.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Teacher
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.teacher.store') }}" method="POST" id="teacherForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="first_name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('first_name') is-invalid @enderror" name="first_name" id="first_name"
                                placeholder="First Name" maxlength="100">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="second_name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('second_name') is-invalid @enderror" name="second_name" id="second_name"
                                placeholder="Second Name" maxlength="100">
                            @error('second_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-20">
                                <label for="email"
                                    class="form-label fw-semibold text-primary-light text-sm mb-8">Email
                                    <span class="text-danger-600">*</span></label>
                                <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" name="email"
                                    id="email" placeholder="Email address" maxlength="100">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Number <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" name="phone" id="phone"
                                placeholder="Contact Number" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- <div class="col-md-6">
                            <label for="instrument_id"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Profile Picture</label>
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
                                    <div id="imagePreview" style="background-image: url('{{ asset('assets/images/user-grid/user-grid-img13.png') }}');"> 
                                    </div>
                                    <input type='file' id="imageUpload" class="@error('image') is-invalid @enderror" name="image" accept=".png, .jpg, .jpeg"
                                        hidden/>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                        </div> --}}

                        <div class="col-md-6">
                            <label for="imageUpload" class="form-label fw-semibold text-secondary-light text-md mb-8">Profile Picture <span class="text-danger-600"></span>
                                <span class="text-secondary-light fw-normal"></span></label>
                            <input type="file" name="image" class="form-control radius-8 @error('image') is-invalid @enderror" id="imageUpload" accept=".png, .jpg, .jpeg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="avatar-upload mt-16">
                                <div class="avatar-preview style-two">
                                    <div id="previewImage1" style="background-image: url('{{ asset('assets/images/user-grid/user-grid-img13.png') }}');"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="instrument_id"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Instrument/Instruments Can Teach <span class="text-danger-600">*</span></label>
                            <select name="instrument_id[]" id="instrument_id" class="form-control select2" multiple="multiple">
                                @if(isset($instruments))
                                    @foreach ($instruments as $instrument)
                                        <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('instrument_id[]')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <label id="instrument_id-error" class="error" for="instrument_id"></label>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                <a href="{{ route('admin.teacher.index') }}">
                                    Cancel
                                </a>
                            </button>
                            <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="saveButton">
                                Save
                            </button>
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
            $.validator.addMethod('extension', function(value, element, param) {
                var allowedExtensions = param.split('|');
                var fileExtension = value.split('.').pop().toLowerCase();
                return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
            }, 'Invalid file extension.');
            $('#teacherForm').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    second_name: {
                        required: true,
                    },
                    phone: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '{{ route('admin.teacher.checkMail') }}',
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
                    image: {
                        extension: "png|jpg|jpeg",
                    },
                    // newPassword: {
                    //     required: true
                    // },
                    // confirmPassword: {
                    //     required: true,
                    //     equalTo: "#newPassword"
                    // },
                    'instrument_id[]': {
                        required: true,
                    },
                },
                messages: {
                    first_name: {
                        required: "Please enter first name",
                    },
                    second_name: {
                        required: "Please enter second name",
                    },
                    phone: {
                        required: "Please enter phone",
                    },
                    email: {
                        required: "please enter email",
                        remote: "This email is already registered."
                    },
                    image: {
                        extension: "Please upload a valid image (png, jpg, jpeg)."
                    },
                    // newPassword: {
                    //     required: 'Please enter password',
                    // },
                    // confirmPassword: {
                    //     required: 'Please enter confirm password',
                    //     equalTo: 'Passwords do not match'
                    // },
                    'instrument_id[]': {
                        required: 'Please select atleast one instrument',
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $("#saveButton").on("click", function(event) {
                event.preventDefault();
                if ($('#teacherForm').valid()) {
                    $("#saveButton").prop('disabled', true);
                    $('#teacherForm').submit();
                } else {
                    $("#saveButton").prop('disabled', false);
                }
            });

            function readURL(input, previewElementId) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#' + previewElementId).css('background-image', 'url(' + e.target.result + ')');
                        $('#' + previewElementId).hide();
                        $('#' + previewElementId).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imageUpload").change(function() {
                readURL(this, 'previewImage1');
            });

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

            $('.select2').select2({
                placeholder: "Select Instrument(s)",
                allowClear: true
            });
        });

    </script>
@endsection
