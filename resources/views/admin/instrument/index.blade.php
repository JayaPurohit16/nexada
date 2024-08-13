@extends('admin.layouts.app')
@section('content')
    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Instrument</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Instrument</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex flex-row align-items-center justify-content-between">
                <h5 class="card-title mb-0">Instrument List</h5>
                <a href="{{ route('admin.instrument.create') }}" class="btn btn-sm btn-primary-600"><i
                    class="ri-add-line"></i>
                Add Instrument</a>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
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
                            <th scope="col">Tag</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @if (isset($locations))
                            <?php
                            $i = 1;
                            ?>
                            @foreach ($locations as $location)
                                <tr>
                                    <td>{{ $i }}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $location->name ?? '' }}</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.location.edit', ['id' => $location->id]) }}"
                                            class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="lucide:edit"></iconify-icon>
                                        </a>
                                        <a href="javascript:void(0)"
                                            data-url="{{ route('admin.location.destroy', ['id' => $location->id]) }}"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center delete-role">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    </td>
                                    <?php
                                    $i++;
                                    ?>
                                </tr>
                            @endforeach
                        @endif
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
    <script>
        // let table = new DataTable('#dataTable');


        $(document).ready(function() {

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.instrument.getInstrument') }}",
                    type: "POST",
                    data: function(data) {
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
                columnDefs: [
                    { targets: 0, width: '100px' }, 
                    { targets: 1, width: '100px' },  
                    { targets: 2, width: '100px' }, 
                    { targets: 3, width: '100px' },  
                    { targets: 4, width: '100px' }, 
                ],
                columns: [{
                        data: null,
                        // defaultContent: '',
                        // className: 'dt-center',
                        orderable: false
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'tag',
                    },
                    // {
                    //     data: 'image',
                    //     render: function(data, type, row) {
                    //         return `<img src="{{ asset('${data}') }}" class="img-thumbnail" alt="Image">`;
                    //     },
                    //     orderable: false
                    // },
                    {
                        data: 'image',
                        render: function(data, type, row) {
                            if (data !== null) {
                                return `<img src="{{ asset('${data}') }}" class="img-thumbnail" alt="Image">`;
                            } else {
                                return `<img src="{{ asset('assets/images/instrument-image.jpg') }}" class="img-thumbnail" alt="Image">`;
                            }
                        },
                        orderable: false
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            let editUrl =
                                '{{ route('admin.instrument.edit', ['id' => '__id__']) }}'
                                .replace('__id__', data);
                            let deleteUrl =
                                '{{ route('admin.instrument.destroy', ['id' => '__id__']) }}'
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
                        orderable:false,
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Cell index column
                    $('td:eq(0)', row).html(dataIndex + 1);
                }
            });

            $(document).on('click', '.delete-role', function(e) {
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
        });

    </script>
@endsection
