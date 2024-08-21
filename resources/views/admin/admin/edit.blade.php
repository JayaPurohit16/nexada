@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Admin</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.admin.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Admin
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.admin.update') }}" method="POST" id="adminForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $admin->id }}">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="first_name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">First Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('first_name') is-invalid @enderror" name="first_name" id="first_name"
                                placeholder="First Name" maxlength="100" value="{{ $admin->first_name }}">
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="second_name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Second Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('second_name') is-invalid @enderror" name="second_name" id="second_name"
                                placeholder="Second Name" maxlength="100" value="{{ $admin->second_name }}">
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
                                    id="email" placeholder="Email address" maxlength="100" value="{{ $admin->email }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" name="phone" id="phone"
                                placeholder="Phone" minlength="10" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="{{ $admin->phone }}">
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

                        <div class="d-flex align-items-center justify-content-sm-end justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-sm-56 py-sm-11 px-40 py-8 radius-8">
                                <a href="{{ route('admin.admin.index') }}">
                                    Cancel
                                </a>
                            </button>
                            <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-sm-56 py-sm-11 px-40 py-10 radius-8" id="saveButton">
                                Update
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
            $('#adminForm').validate({
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
                            url: '{{ route('admin.admin.checkMail') }}',
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                id: function() {
                                    return $('input[name="id"]').val();
                                }
                            },
                            dataFilter: function(response) {
                                var json = JSON.parse(response);
                                return json.exists ? `"This email is already registered."` : true;
                            }
                        }
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
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $("#saveButton").on("click", function(event) {
                event.preventDefault();
                if ($('#adminForm').valid()) {
                    $("#saveButton").prop('disabled', true);
                    $('#adminForm').submit();
                } else {
                    $("#saveButton").prop('disabled', false);
                }
            });
        });
    </script>
@endsection
