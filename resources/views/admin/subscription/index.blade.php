@extends('admin.layouts.app')
@section('content')
<div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Subscription</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Subscription</li>
        </ul>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.subscription.RegistrationFee.store') }}" method="POST" id="registrationFeeForm"
            enctype="multipart/form-data">
            @csrf
            <div class="row gy-4 mb-5 align-items-end">
                <div class="col-md-5 w-25">
                    <label for="registration_fee"
                        class="form-label fw-semibold text-primary-light text-sm mb-8">Registration Fee <span
                            class="text-danger-600">*</span></label>
                    <input type="number" class="form-control radius-8 @error('price') is-invalid @enderror" name="price"
                        id="price" value="{{ $registrationFee->price ?? '' }}" placeholder="Registration Fee"
                        maxlength="8">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <button type="submit"
                        class="btn btn-primary border border-primary-600 text-md px-56 py-10 radius-8">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card basic-data-table">
        <div class="card-header d-flex flex-row align-items-center justify-content-between">
            <h5 class="card-title mb-0">Subscription List</h5>
            <a href="{{ route('admin.subscription.create') }}" class="btn btn-sm btn-primary-600"><i
                    class="ri-add-line"></i>
                Add Subscription</a>
        </div>
        <div class="card-body table-border-set">
            <table class="table bordered-table m-0 w-100" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        {{-- <th scope="col">
                            <div class="form-check style-check d-flex align-items-center">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    S.L
                                </label>
                            </div>
                        </th> --}}
                        <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Lesson Per Week</th>
                        <th scope="col">Time(Hours)</th>
                        <th scope="col">Amount Of Free Lesson</th>
                        <th scope="col">Location</th>
                        <th scope="col">New Sign-Ups Allowed</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script-js')
<script>
    // let table = new DataTable('#dataTable');

    $(document).ready(function () {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            "sScrollX": "100%",
            "sScrollXInner": "110%",
            "bScrollCollapse": true,
            ajax: {
                url: "{{ route('admin.subscription.getSubscription') }}",
                type: "POST",
                data: function (data) {
                    data.search = $('input[type="search"]').val();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            order: [
                [0, 'desc']
            ],
            pageLength: 10,
            searching: true,
            columnDefs: [{
                targets: 0,
                width: '100px'
            },
            {
                targets: 1,
                width: '100px'
            },
            {
                targets: 2,
                width: '100px'
            },
            {
                targets: 3,
                width: '100px'
            },
            {
                targets: 4,
                width: '100px'
            },
            {
                targets: 5,
                width: '100px'
            },
            {
                targets: 6,
                width: '100px'
            },
            {
                targets: 7,
                width: '100px'
            },
            {
                targets: 8,
                width: '100px'
            },
            ],
            columns: [{
                data: null,
                // defaultContent: '', 
                // className: 'dt-center',
                orderable: false
            },
            {
                data: 'name'
            },
            {
                data: 'image',
                render: function (data, type, row) {
                    if (data !== null) {
                        // return `<img src="#" alt="Image" style="padding: .25rem;
                        //         max-width: 100px;
                        //         height: auto">`;
                        return `<a href="{{ asset('${data}') }}"
                                    class="glightbox" data-glightbox="avatar-1" style="padding: .25rem; max-width: 100px; height: auto">
                                    <img src="{{ asset('${data}') }}" alt="image" />
                                </a>`;
                    } else {
                        // return `<img src="#" alt="Image" style="padding: .25rem;
                        //                 max-width: 50px;
                        //                 height: auto">`;
                        return `<a href="{{ asset('assets/images/subscription-icon.png') }}"
                                    class="glightbox" data-glightbox="avatar-1" style="padding: .25rem; max-width: 50px; height: auto">
                                    <img src="{{ asset('assets/images/subscription-icon.png') }}" alt="image" />
                                </a>`;
                    }
                },
                orderable: false
            },

            {
                data: 'lesson_per_week',
                orderable: false
            },
            {
                data: 'time',
                orderable: false
            },
            // {
            //     data: 'amount',
            //     orderable: false
            // },
            // {
            //     data: 'billing_period',
            //     render: function(data, type, row) {
            //         if (data === "0") {
            //             return "Monthly";
            //         } else if (data === "1") {
            //             return "Quarterly";
            //         } else if (data === "2") {
            //             return "Yearly";
            //         } else {
            //             return "N/A";
            //         }
            //     },
            //     orderable: false
            // },
            // {
            //     data: 'discount',
            //     orderable: false
            // },
            {
                data: 'amount_of_free_lessons',
                orderable: false
            },
            {
                data: 'location',
                render: function (data, type, row) {
                    return data ? data.name : '';
                },
                orderable: false,
            },
            {
                data: 'new_sign_up_allowed',
                render: function (data, type, row) {
                    if (data === "0") {
                        return "False";
                    } else if (data === "1") {
                        return "True";
                    } else {
                        return "N/A";
                    }
                },
                orderable: false
            },
            {
                data: 'id',
                render: function (data, type, row) {
                    let editUrl =
                        '{{ route('admin.subscription.edit', ['id' => '__id__']) }}'
                            .replace('__id__', data);
                    let deleteUrl =
                        '{{ route('admin.subscription.destroy', ['id' => '__id__']) }}'
                            .replace('__id__', data);

                    return `<a href="${editUrl}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="javascript:void(0)"
                                        data-url="${deleteUrl}"
                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete-role">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>`;
                },
                orderable: false,
            }
            ],
            createdRow: function (row, data, dataIndex) {
                // Cell index column
                $('td:eq(0)', row).html(dataIndex + 1);
            },
            drawCallback: function (settings) {
                lightbox.destroy();
                lightbox = GLightbox({
                    selector: '.glightbox'
                });
            }
        });

        $(document).on('click', '.delete-role', function (e) {
            e.preventDefault();

            var url = $(this).data('url');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });

        $('#registrationFeeForm').validate({
            rules: {
                price: {
                    required: true,
                },
            },
            messages: {
                price: {
                    required: "Please enter registration fee",
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>
@endsection