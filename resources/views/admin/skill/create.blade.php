@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add Skill</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.skill.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Skill
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.skill.store') }}" method="POST" id="skillForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="name"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" name="name" id="name"
                                placeholder="Name" value="{{ old('name') }}" maxlength="100">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="instrument_id"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Instrument <span class="text-danger-600">*</span></label>
                            {{-- <input type="text" class="form-control radius-8 @error('instrument_id') is-invalid @enderror" name="instrument_id" id="instrument_id"
                                placeholder="Instrument" maxlength="100"> --}}
                            
                            <select name="instrument_id" id="instrument_id" class="form-control">
                                @if(isset($instruments))
                                    <option value="">Select Instrument</option>
                                    @foreach ($instruments as $instrument)
                                        <option value="{{ $instrument->id }}">{{ $instrument->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('instrument_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="category"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Category <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('category') is-invalid @enderror" name="category" id="category"
                                placeholder="Category" value="{{ old('category') }}" maxlength="100">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="description"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Description <span class="text-danger-600">*</span></label>
                            <textarea type="text" class="form-control radius-8 @error('description') is-invalid @enderror" name="description" id="description"
                                placeholder="Description" maxlength="1000">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">External Videos URL</label>
                            <div id="external-videos-container">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control radius-8" name="external_videos[]" placeholder="External Video URL" maxlength="100">
                                    {{-- <button type="button" class="btn btn-outline-danger remove-btn">Remove</button> --}}
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-external-video">Add</button>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Notes</label>
                            <div id="notes-container">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control radius-8" name="notes[]" placeholder="Note" maxlength="500">
                                    {{-- <button type="button" class="btn btn-outline-danger remove-btn">Remove</button> --}}
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-note">Add</button>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Supporting Documents</label>
                            <div id="supporting-docs-container">
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control radius-8" name="supporting_docs[]" accept=".pdf, .doc, .docx, .ppt, .pptx" multiple>
                                    {{-- <button type="button" class="btn btn-outline-danger remove-btn">Remove</button> --}}
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-supporting-doc">Add</button>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Tutorial Videos</label>
                            <div id="tutorial-videos-container">
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control radius-8" name="tutorial_videos[]" accept=".mp4, .avi, .mov, .mkv," multiple>
                                    {{-- <button type="button" class="btn btn-outline-danger remove-btn">Remove</button> --}}
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-tutorial-video">Add</button>
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                <a href="{{ route('admin.skill.index') }}">
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
                $.validator.addMethod('videoExtension', function(value, element, param) {
                    var allowedExtensions = param.split('|');
                    var fileExtension = value.split('.').pop().toLowerCase();
                    return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
                }, 'Invalid file extension.');
                $.validator.addMethod('docsExtension', function(value, element, param) {
                    var allowedExtensions = param.split('|');
                    var fileExtension = value.split('.').pop().toLowerCase();
                    return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
                }, 'Invalid file extension.');
                $('#skillForm').validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        instrument_id: {
                            required: true,
                        },
                        category: {
                            required: true,
                        },
                        description: {
                            required: true,
                        },
                        'external_videos[]': {
                            url: true,
                            // required: {
                            //     depends: function(element) {
                            //         return $('#external-videos-container input').length > 0;
                            //     }
                            // }
                        },
                        'tutorial_videos[]': {
                            videoExtension: "mp4|avi|mov|mkv",
                            // required: {
                            //     depends: function(element) {
                            //         return $('#tutorial-videos-container input').length > 0;
                            //     }
                            // }
                        },
                        'supporting_docs[]': {
                            docsExtension: "pdf|doc|docx|ppt|pptx",
                            // required: {
                            //     depends: function(element) {
                            //         return $('#supporting-docs-container input').length > 0;
                            //     }
                            // }
                        },
                        // 'notes[]': {
                        //     required: true,
                        // }
                    },
                    messages: {
                        name: {
                            required: "Please enter name",
                        },
                        instrument_id: {
                            required: "Please select instrument",
                        },
                        category: {
                            required: "Please enter category",
                        },
                        description: {
                            required: "Please enter description",
                        },
                        'external_videos[]': {
                            // required: "Please enter external video url",
                            url: "Please enter a valid URL",
                        },
                        'tutorial_videos[]': {
                            // required: "Please upload tutorial video",
                            videoExtension: "Please upload a valid video file(mp4|avi|mov|mkv)",
                        },
                        'supporting_docs[]': {
                            // required: "Please upload supporting doc",
                            docsExtension: "Please upload a valid document file(pdf|doc|docx|ppt|pptx)",
                        },
                        // 'notes[]': {
                        //     required: "Please enter notes",
                        // },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });

                $("#saveButton").on("click", function(event) {
                    event.preventDefault();
                    if ($('#skillForm').valid()) {
                        $("#saveButton").prop('disabled', true);
                        $('#skillForm').submit();
                    } else {
                        $("#saveButton").prop('disabled', false);
                    }
                });

                // Add External Video
                $('#add-external-video').on('click', function() {
                    $('#external-videos-container').append(`
                        <div class="input-group mb-3">
                            <input type="text" class="form-control radius-8" name="external_videos[]" placeholder="External Video URL" maxlength="500">
                            <button type="button" class="btn btn-outline-danger remove-btn">Remove</button>
                        </div>
                    `);
                });

                // Add Tutorial Video
                $('#add-tutorial-video').on('click', function() {
                    $('#tutorial-videos-container').append(`
                        <div class="input-group mb-3">
                            <input type="file" class="form-control radius-8" name="tutorial_videos[]" multiple>
                            <button type="button" class="btn btn-outline-danger remove-btn">Remove</button>
                        </div>
                    `);
                });

                // Add Supporting Document
                $('#add-supporting-doc').on('click', function() {
                    $('#supporting-docs-container').append(`
                        <div class="input-group mb-3">
                            <input type="file" class="form-control radius-8" name="supporting_docs[]" accept=".pdf, .doc, .docx, ppt, pptx" multiple>
                            <button type="button" class="btn btn-outline-danger remove-btn">Remove</button>
                        </div>
                    `);
                });

                // Add Note
                $('#add-note').on('click', function() {
                    $('#notes-container').append(`
                        <div class="input-group mb-3">
                            <input type="text" class="form-control radius-8" name="notes[]" placeholder="Note" maxlength="500">
                            <button type="button" class="btn btn-outline-danger remove-btn">Remove</button>
                        </div>
                    `);
                });

                // Remove Field
                $(document).on('click', '.remove-btn', function() {
                    $(this).closest('.input-group').remove();
                });
            
            });

    </script>
@endsection
