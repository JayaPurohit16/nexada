@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Role</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.roles.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Role
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12">
            <div class="card-body p-24">
                <form action="{{ route('admin.roles.update') }}" method="POST" id="rolesForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $role->id }}">
                    <div class="row gy-4">
                        <div class="col-md-6">
                            <label for="facebook_link"
                                class="form-label fw-semibold text-primary-light text-sm mb-8">Role <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('role') is-invalid @enderror" name="role" id="role"
                                placeholder="Role" maxlength="50" value="{{ $role->name ?? '' }}">
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        @if(isset($modules))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Module</th>
                                        <th style="text-align: center">Permissions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($modules as $module)
                                        <tr>
                                            <td><strong>{{ $module->formatted_name ?? '' }}</strong></td>
                                            <td>
                                                @foreach($module->permissions as $permission)
                                                <label>
                                                    <input type="checkbox" name="permission[]" value="{{ $permission->name }}" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                    class="name" style="appearance: auto">
                                                    @php
                                                        $formatName = ucfirst(strtolower(str_replace('_', ' ', str_replace('-', ' ', $permission->name))));
                                                    @endphp
                                                    {{ $formatName ?? '' }}
                                                </label>
                                                    <br/>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach --}}

                                    @foreach ($modules as $module)
                                        <tr>
                                            <td>
                                                <strong>{{ $module->formatted_name ?? '' }}</strong>
                                            </td>
                                            <td>
                                                <input type="checkbox" name="module" class="module-checkbox" data-module-id="{{ $module->id }}" style="appearance: auto"> 
                                                All
                                                <br/>
                                                @foreach($module->permissions as $permission)
                                                    <label>
                                                        <input type="checkbox" name="permission[]" value="{{ $permission->name }}" data-module-id="{{ $module->id }}" class="permission-checkbox"
                                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                        class="name" style="appearance: auto">
                                                        @php
                                                            $formatName = ucfirst(strtolower(str_replace('_', ' ', str_replace('-', ' ', $permission->name))));
                                                        @endphp
                                                        {{ $formatName ?? '' }}
                                                    </label>
                                                    <br/>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                        
                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="button"
                                class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                <a href="{{ route('admin.roles.index') }}">
                                    Cancel
                                </a>
                            </button>
                            <button type="submit"
                                class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8" id="saveButton">
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
                $('#rolesForm').validate({
                    rules: {
                        role: {
                            required: true,
                        },
                    },
                    messages: {
                        role: {
                            required: "Please enter role",
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });

                $("#saveButton").on("click", function(event) {
                    // event.preventDefault();
                    if ($('#rolesForm').valid()) {
                        $("#saveButton").prop('disabled', true);
                        $('#rolesForm').submit();
                    } else {
                        $("#saveButton").prop('disabled', false);
                    }
                });

                function updateModuleCheckboxes() {
                    $('.module-checkbox').each(function() {
                        var moduleId = $(this).data('module-id');
                        var allChecked = true;

                        $('.permission-checkbox[data-module-id="' + moduleId + '"]').each(function() {
                            if (!$(this).is(':checked')) {
                                allChecked = false;
                                return false;
                            }
                        });
                        $(this).prop('checked', allChecked);
                    });
                }

                $('.module-checkbox').change(function() {
                    var isChecked = $(this).is(':checked');
                    var moduleId = $(this).data('module-id');
                    $('.permission-checkbox[data-module-id="' + moduleId + '"]').prop('checked', isChecked);
                });

                $('.permission-checkbox').change(function() {
                    var moduleId = $(this).data('module-id');
                    var allChecked = true;

                    $('.permission-checkbox[data-module-id="' + moduleId + '"]').each(function() {
                        if (!$(this).is(':checked')) {
                            allChecked = false;
                            return false;
                        }
                    });
                    $('.module-checkbox[data-module-id="' + moduleId + '"]').prop('checked', allChecked);
                });

                updateModuleCheckboxes();
            });
    </script>
@endsection
