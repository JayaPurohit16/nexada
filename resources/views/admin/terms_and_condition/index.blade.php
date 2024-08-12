@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Terms & Conditions</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Terms & Conditions</li>
            </ul>
        </div>

        <div class="card basic-data-table radius-12 overflow-hidden">
            <form action="{{ route('admin.termsAndCondition.store') }}" method="POST" id="termsAndConditionForm">
                @csrf
                <div class="card-body p-0">
                    <!-- Editor Toolbar Start -->
                    <div id="toolbar-container">
                        <span class="ql-formats">
                            <select class="ql-font"></select>
                            <select class="ql-size"></select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-strike"></button>
                        </span>
                        <span class="ql-formats">
                            <select class="ql-color"></select>
                            <select class="ql-background"></select>
                        </span>
                        {{-- <span class="ql-formats">
                            <button class="ql-script" value="sub"></button>
                            <button class="ql-script" value="super"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-header" value="1"></button>
                            <button class="ql-header" value="2"></button>
                            <button class="ql-blockquote"></button>
                            <button class="ql-code-block"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                            <button class="ql-indent" value="-1"></button>
                            <button class="ql-indent" value="+1"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-direction" value="rtl"></button>
                            <select class="ql-align"></select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-link"></button>
                            <button class="ql-image"></button>
                            <button class="ql-video"></button>
                            <button class="ql-formula"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-clean"></button>
                        </span> --}}
                    </div>
                    <!-- Editor Toolbar Start -->

                    <!-- Editor start -->
                    <div id="editor">
                        {!! $termsAndConditions->title ?? ''!!}
                    </div>
                    <!-- Edit End -->
                </div>

                <input type="hidden" name="content" id="hiddenContent">

                <div class="card-footer p-24 bg-base border border-bottom-0 border-end-0 border-start-0">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="button"
                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary border border-primary-600 text-md px-28 py-12 radius-8">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script-js')

    <script>
        // Editor Js Start
        const quill = new Quill('#editor', {
            modules: {
                syntax: true,
                toolbar: '#toolbar-container',
            },
            placeholder: 'Terms & Conditions...',
            theme: 'snow',
        });
        // Editor Js End


        // let table = new DataTable('#dataTable');

        $('#termsAndConditionForm').on('submit', function(e) {
            $('#hiddenContent').val(quill.root.innerHTML);
        });
        
    </script>
@endsection
