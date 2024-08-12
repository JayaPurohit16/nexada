@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Location</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.location.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Location
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.location.store') }}" method="POST" id="locationForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="location"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Location <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" name="name" id="name"
                                placeholder="Location" maxlength="100">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" name="phone" id="phone"
                                placeholder="Phone" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="calender_by_instruments"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Calender by instruments <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('calender_by_instruments') is-invalid @enderror" name="calender_by_instruments" id="calender_by_instruments"
                                placeholder="Calender by instruments" maxlength="100">
                            @error('calender_by_instruments')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="api_key"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">API Key <span class="text-danger-600"></span></label>
                            <input type="text" class="form-control radius-8 @error('api_key') is-invalid @enderror" name="api_key" id="api_key"
                                placeholder="API Key" maxlength="150">
                            @error('api_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="api_secret_key"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Secret Key<span class="text-danger-600"></span></label>
                            <input type="text" class="form-control radius-8 @error('api_secret_key') is-invalid @enderror" name="api_secret_key" id="api_secret_key"
                                placeholder="Secret Key" maxlength="150">
                            @error('api_secret_key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="address"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Address <span class="text-danger-600">*</span></label>
                            <textarea type="text" class="form-control radius-8 @error('address') is-invalid @enderror" name="address" id="address"
                                placeholder="Address" maxlength="200"></textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                <a href="{{ route('admin.location.index') }}">
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
                $('#locationForm').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        phone: {
                            required: true,
                        },
                        // calender_by_instruments: {
                        //     required: true,
                        // },
                        address: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "Please enter location",
                        },
                        phone: {
                            required: "Please enter phone",
                        },
                        calender_by_instruments: {
                            required: "Please enter calender by instrument",
                        },
                        address: {
                            required: "Please enter address",
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });

                $("#saveButton").on("click", function(event) {
                    event.preventDefault();
                    if ($('#locationForm').valid()) {
                        $("#saveButton").prop('disabled', true);
                        $('#locationForm').submit();
                    } else {
                        $("#saveButton").prop('disabled', false);
                    }
                });
            });
    </script>
@endsection
