@extends('admin.layouts.app')
@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add Instrument</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.instrument.index') }}"
                    class="d-flex align-items-center gap-1 hover-text-primary">
                    Instrument
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Add</li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12">
        <div class="card-body p-24">
            <form action="{{ route('admin.instrument.store') }}" method="POST" id="instrumentForm"
                enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6">
                        <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Display name
                            <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" name="name"
                            id="name" placeholder="Display name" value="{{ old('name') }}" maxlength="100">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <label for="tag" class="form-label fw-semibold text-primary-light text-sm mb-8">Tag <span
                                class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 @error('tag') is-invalid @enderror" name="tag"
                            id="tag" placeholder="tag" value="{{ old('tag') }}" maxlength="100">
                        @error('tag')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <label for="imageUpload"
                            class="form-label fw-semibold text-secondary-light text-md mb-8">Instrument Image <span
                                class="text-danger-600">*</span>
                            <span class="text-secondary-light fw-normal"></span></label>
                        <div class="d-flex gap-2">
                            <input type="file" name="image"
                                class="form-control radius-8 @error('image') is-invalid @enderror" id="imageUpload"
                                accept=".png, .jpg, .jpeg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="avatar-upload">
                                <div class="avatar-preview style-two">
                                    <div id="previewImage1"
                                        style="background-image: url('{{ asset('assets/images/instrument-image.jpg') }}');">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-sm-end justify-content-center gap-3">
                        <button type="button"
                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-sm-56 py-sm-11 px-40 py-8 radius-8">
                            <a href="{{ route('admin.instrument.index') }}">
                                Cancel
                            </a>
                        </button>
                        <button type="submit"
                            class="btn btn-primary border border-primary-600 text-md px-sm-56 py-sm-11 px-40 py-10 radius-8"
                            id="saveButton">
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
    $(document).ready(function () {
        $.validator.addMethod('extension', function (value, element, param) {
            var allowedExtensions = param.split('|');
            var fileExtension = value.split('.').pop().toLowerCase();
            return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
        }, 'Invalid file extension.');
        $('#instrumentForm').validate({
            rules: {
                name: {
                    required: true,
                },
                tag: {
                    required: true,
                },
                // calender_by_instruments: {
                //     required: true,
                // },
                image: {
                    required: true,
                    extension: "png|jpg|jpeg"
                },
            },
            messages: {
                name: {
                    required: "Please enter name",
                },
                tag: {
                    required: "Please enter tag",
                },
                image: {
                    required: "Please upload instrument image",
                    extension: "Please upload a valid image (png, jpg, jpeg)."
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        $("#saveButton").on("click", function (event) {
            event.preventDefault();
            if ($('#instrumentForm').valid()) {
                $("#saveButton").prop('disabled', true);
                $('#instrumentForm').submit();
            } else {
                $("#saveButton").prop('disabled', false);
            }
        });
    });

    // ================== Image Upload Js Start ===========================
    function readURL(input, previewElementId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + previewElementId).css('background-image', 'url(' + e.target.result + ')');
                $('#' + previewElementId).hide();
                $('#' + previewElementId).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imageUpload").change(function () {
        readURL(this, 'previewImage1');
    });

    // $("#imageUploadTwo").change(function() {
    //     readURL(this, 'previewImage2');
    // });
    // ================== Image Upload Js End ===========================
</script>
@endsection