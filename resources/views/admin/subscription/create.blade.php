@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Subscription</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.subscription.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Subscription
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.subscription.store') }}" method="POST" id="subscriptionForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" name="name" id="name"
                                placeholder="Name" maxlength="100">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="imageUpload" class="form-label fw-semibold text-secondary-light text-md mb-8">Icon Of Subscription
                                <span class="text-secondary-light fw-normal"></span></label>
                            <input type="file" name="image" class="form-control radius-8 @error('image') is-invalid @enderror" id="imageUpload" accept=".png, .jpg, .jpeg">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="avatar-upload mt-16">
                                <div class="avatar-preview style-two">
                                    <div id="previewImage1" style="background-image: url('{{ asset('assets/images/subscription-icon.png') }}');"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="lesson_per_week"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Lesson Per Week <span class="text-danger-600">*</span></label>
                            <input type="number" class="form-control radius-8 @error('lesson_per_week') is-invalid @enderror" name="lesson_per_week" id="lesson_per_week"
                                placeholder="Lesson Per Week" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0" min="0" max="100">
                            @error('lesson_per_week')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="time"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Time(Hours) <span class="text-danger-600">*</span></label>
                            <input type="number" class="form-control radius-8 @error('time') is-invalid @enderror" name="time" id="time"
                                placeholder="Time(Hours)" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0" min="0" max="100">
                            @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="pricingContainer">
                            <div class="col-md-12 d-flex justify-content-between">
                                <h6>Pricing Details</h6>
                                <button type="button" class="btn btn-outline-primary" id="addPricingGroup">Add More Pricing</button>
                            </div>
                            <div class="col-md-12 pricing-group">
                                <div class="row gy-4">
                                    <div class="col-md-3">
                                        <label for="price" class="form-label fw-semibold text-primary-light text-sm mb-8">Price <span class="text-danger-600">*</span></label>
                                        <input type="number" class="form-control radius-8 price @error('price.*') is-invalid @enderror" name="price[]" id="price" placeholder="Price" value="0" min="0" max="100000">
                                        @error('price.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                
                                    <div class="col-md-3">
                                        <label for="billing_period" class="form-label fw-semibold text-primary-light text-sm mb-8">Billing Period <span class="text-danger-600">*</span></label>
                                        <select name="billing_period[]" id="billing_period" class="form-control billing_period">
                                            <option value="">Select Billing Period</option>
                                            <option value="0">Monthly</option>
                                            <option value="1">Quarterly</option>
                                            <option value="2">Yearly</option>
                                        </select>
                                        @error('billing_period.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                
                                    <div class="col-md-3">
                                        <label for="discount" class="form-label fw-semibold text-primary-light text-sm mb-8">Discount (in %) <span class="text-danger-600">*</span></label>
                                        <input type="number" class="form-control radius-8 discount @error('discount.*') is-invalid @enderror" name="discount[]" id="discount" placeholder="Discount (in %)" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0" min="0" max="100">
                                        @error('discount.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="amount_of_free_lessons"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Amount Of Free Lesson <span class="text-danger-600">*</span></label>
                            <input type="number" class="form-control radius-8 @error('amount_of_free_lessons') is-invalid @enderror" name="amount_of_free_lessons" id="amount_of_free_lessons"
                                placeholder="Price" onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                onkeyup="this.value=this.value.replace(/[^0-9]/g, '')" value="0" min="0" max="100000">
                            @error('amount_of_free_lessons')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="location_id"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Location <span class="text-danger-600">*</span></label>
                                <select name="location_id" id="location_id" class="form-control">
                                    <option value="">Select Location</option>
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
                            <label for="new_sign_up_allowed"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">New Sign-Ups Allowed <span class="text-danger-600">*</span></label>
                                <select name="new_sign_up_allowed" id="new_sign_up_allowed" class="form-control">
                                    <option value="1">True</option>
                                    <option value="0">False</option>
                                </select>
                            @error('new_sign_up_allowed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="description"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                            <textarea type="text" class="form-control radius-8 @error('description') is-invalid @enderror" name="description" id="description"
                                placeholder="Description" maxlength="200"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                <a href="{{ route('admin.subscription.index') }}">
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
                // $('#subscriptionForm').validate({
                //     rules: {
                //         name: {
                //             required: true,
                //         },
                //         image: {
                //             extension: "png|jpg|jpeg",   
                //         },
                //         lesson_per_week: {
                //             required: true,
                //         },
                //         time: {
                //             required: true,
                //         },
                //         amount: {
                //             required: true,
                //         },
                //         billing_period: {
                //             required: true,
                //         },
                //         discount: {
                //             required: true,
                //         },
                //         amount_of_free_lessons: {
                //             required: true,
                //         },
                //         location_id: {
                //             required: true,
                //         },
                //         new_sign_up_allowed: {
                //             required: true,
                //         },
                //         description: {
                //             required: true,
                //         },
                //     },
                //     messages: {
                //         name: {
                //             required: "Please enter name",
                //         },
                //         image: {
                //             extension: "Please upload a valid image (png, jpg, jpeg)."
                //         },
                //         lesson_per_week: {
                //             required: "Please enter lessons per week",
                //         },
                //         time: {
                //             required: "Please enter time",
                //         },
                //         amount: {
                //             required: "Please enter price",
                //         },
                //         billing_period: {
                //             required: "Please select billing period",
                //         },
                //         discount: {
                //             required: "Please enter discount",
                //         },
                //         amount_of_free_lessons: {
                //             required: "Please enter amount of free lesson",
                //         },
                //         location_id: {
                //             required: "Please select location",
                //         },
                //         new_sign_up_allowed: {
                //             required: "Please select new sign up allowed",
                //         },
                //         description: {
                //             required: "Please enter description",
                //         },
                //     },
                //     submitHandler: function(form) {
                //         form.submit();
                //     }
                // });

                
                $('#subscriptionForm').validate({
                    rules: {
                        name: { required: true },
                        image: { extension: "png|jpg|jpeg" },
                        lesson_per_week: { required: true },
                        time: { required: true },
                        // amount: { required: true },
                        // billing_period: { required: true },
                        // discount: { required: true },
                        amount_of_free_lessons: { required: true },
                        location_id: { required: true },
                        new_sign_up_allowed: { required: true },
                        description: { required: true },

                        'price[]': { required: true, number: true },
                        'billing_period[]': { required: true },
                        'discount[]': { required: true, number: true }
                    },
                    messages: {
                        name: { required: "Please enter name" },
                        image: { extension: "Please upload a valid image (png, jpg, jpeg)." },
                        lesson_per_week: { required: "Please enter lessons per week" },
                        time: { required: "Please enter time" },
                        // amount: { required: "Please enter price" },
                        // billing_period: { required: "Please select billing period" },
                        // discount: { required: "Please enter discount" },
                        amount_of_free_lessons: { required: "Please enter amount of free lesson" },
                        location_id: { required: "Please select location" },
                        new_sign_up_allowed: { required: "Please select new sign up allowed" },
                        description: { required: "Please enter description" },

                        'price[]': { required: "Please enter a price", number: "Price must be a number" },
                        'billing_period[]': { required: "Please select billing period" },
                        'discount[]': { required: "Please enter a discount", number: "Discount must be a number" }
                    },
                    submitHandler: function (form) {
                        form.submit();
                    }
                });

                let counter = 1;

                function validatePricingGroups() {
                    let isValid = true;
                    
                    $('.pricing-group').each(function () {
                        const price = $(this).find('.price').val().trim();
                        const billingPeriod = $(this).find('.billing_period').val().trim();
                        const discount = $(this).find('.discount').val().trim();
                        
                        if (!price || !billingPeriod || !discount) {
                            isValid = false;
                            return false;
                        }
                    });
                    
                    return isValid;
                }

                $('#addPricingGroup').on('click', function () {
                    if (validatePricingGroups()) {
                        counter++;
                        const newGroup = `
                            <div class="col-md-12 pricing-group">
                                <div class="row gy-4">
                                    <div class="col-md-3">
                                        <label for="price_${counter}" class="form-label fw-semibold text-primary-light text-sm mb-8">Price <span class="text-danger-600">*</span></label>
                                        <input type="number" class="form-control radius-8 price price-field" name="price[]" id="price_${counter}" placeholder="Price" value="0" min="0" max="100000">
                                    </div>

                                    <div class="col-md-3">
                                        <label for="billing_period_${counter}" class="form-label fw-semibold text-primary-light text-sm mb-8">Billing Period <span class="text-danger-600">*</span></label>
                                        <select name="billing_period[]" id="billing_period_${counter}" class="form-control billing-period-field billing_period">
                                            <option value="">Select Billing Period</option>
                                            <option value="0">Monthly</option>
                                            <option value="1">Quarterly</option>
                                            <option value="2">Yearly</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="discount_${counter}" class="form-label fw-semibold text-primary-light text-sm mb-8">Discount (in %) <span class="text-danger-600">*</span></label>
                                        <input type="number" class="form-control radius-8 discount-field discount" name="discount[]" id="discount_${counter}" placeholder="Discount (in %)" value="0" min="0" max="100">
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-outline-danger remove-pricing-group" style="margin-top: 33px">Remove</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#pricingContainer').append(newGroup);
                    } else {
                        alert('Please fill out all fields in the existing pricing details before adding more.');
                    }
                });

                $('#pricingContainer').on('click', '.remove-pricing-group', function () {
                    $(this).closest('.pricing-group').remove();
                });

                $("#saveButton").on("click", function(event) {
                    if (!validatePricingGroups()) {
                        alert('Please fill out all fields in the pricing details before submitting the form.');
                        event.preventDefault();
                        return false;
                    }
                    if ($('#subscriptionForm').valid()) {
                        $("#saveButton").prop('disabled', true);
                        $('#subscriptionForm').submit();
                    } else {
                        $("#saveButton").prop('disabled', false);
                    }
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
                // ================== Image Upload Js End ===========================
            });
    </script>
@endsection
