@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">CMS Settings</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">CMS Settings</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.CmsSetting.store') }}" method="POST" id="CmsSettingForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="imageUpload" class="form-label fw-semibold text-secondary-light text-md mb-8">Website Logo
                                <span class="text-secondary-light fw-normal">(140px X 140px)</span></label>
                            <input type="file" name="website_logo" class="form-control radius-8 @error('website_logo') is-invalid @enderror" id="imageUpload" accept=".png, .jpg, .jpeg">
                            @error('website_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="avatar-upload mt-16">
                                <div class="avatar-preview style-two">
                                    <div id="previewImage1" style="background-image: url('{{ (!empty($cmsSettings['website_logo']) && file_exists($cmsSettings['website_logo'])) ? asset($cmsSettings['website_logo']) : asset('assets/images/payment/upload-image.png') }}');"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="imageUploadTwo"
                                class="form-label fw-semibold text-secondary-light text-md mb-8">Favicon Logo<span
                                    class="text-secondary-light fw-normal">(140px X 140px)</span></label>
                            <input type="file" name="favicon_logo" class="form-control radius-8 @error('favicon_logo') is-invalid @enderror" id="imageUploadTwo" accept=".png, .jpg, .jpeg">
                            @error('favicon_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="avatar-upload mt-16">
                                <div class="avatar-preview style-two">
                                    <div id="previewImage2" style="background-image: url('{{ (!empty($cmsSettings['favicon_logo']) && file_exists($cmsSettings['favicon_logo'])) ? asset($cmsSettings['favicon_logo']) : asset('assets/images/payment/upload-image.png') }}');"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="fw-medium">Social Links:<p>
                        </div>
                        <div class="col-md-6">
                            <label for="facebook_link"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Facebook Link <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('facebook_link') is-invalid @enderror" name="facebook_link" id="facebook_link"
                                placeholder="Facebook Link" maxlength="100" value="{{ old('facebook_link', $cmsSettings['facebook_link'] ?? '') }}">
                            @error('facebook_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="instagram_link"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Instagram Link <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('instagram_link') is-invalid @enderror" name="instagram_link" id="instagram_link"
                                placeholder="Instagram Link" maxlength="100" value="{{ old('instagram_link', $cmsSettings['instagram_link'] ?? '') }}">
                            @error('instagram_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="twitter_link"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Twitter Link <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('twitter_link') is-invalid @enderror" name="twitter_link" id="twitter_link"
                                placeholder="Twitter Link" maxlength="100" value="{{ old('twitter_link', $cmsSettings['twitter_link'] ?? '') }}">
                            @error('twitter_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="youtube_link"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Youtube Link <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('youtube_link') is-invalid @enderror" name="youtube_link" id="youtube_link"
                                placeholder="Youtube Link" maxlength="100" value="{{ old('youtube_link', $cmsSettings['youtube_link'] ?? '') }}">
                            @error('youtube_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                $('#CmsSettingForm').validate({
                    rules: {
                        facebook_link: {
                            url: true
                        },
                        instagram_link: {
                            url: true
                        },
                        twitter_link: {
                            url: true
                        },
                        youtube_link: {
                            url: true
                        },
                        website_logo: {
                            extension: "png|jpg|jpeg"
                        },
                        favicon_logo: {
                            extension: "png|jpg|jpeg"
                        }
                    },
                    messages: {
                        facebook_link: {
                            url: "Please enter valid Facebook URL",
                        },
                        instagram_link: {
                            url: "Please enter valid Instagram URL",
                        },
                        twitter_link: {
                            url: "Please enter valid Twitter URL",
                        },
                        youtube_link: {
                            url: "Please enter valid Youtube URL",
                        },
                        website_logo: {
                            extension: "Please upload a valid image (png, jpg, jpeg)."
                        },
                        favicon_logo: {
                            extension: "Please upload a valid image (png, jpg, jpeg)."
                        }
                    },
                    submitHandler: function(form) {
                        console.log('Form is valid, submitting...');
                        form.submit();
                    }
                });
            });
        // ================== Image Upload Js Start ===========================
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

        $("#imageUploadTwo").change(function() {
            readURL(this, 'previewImage2');
        });
        // ================== Image Upload Js End ===========================
    </script>
@endsection


        
