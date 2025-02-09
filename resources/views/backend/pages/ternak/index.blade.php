@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important;
        }

        label {
            float: left;
        }
    </style>
    @php
        $usr = Auth::guard('admin')->user();
        if ($usr != null) {
            $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        }

    @endphp

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Data Ternak</h4>
                        <p class="float-right mb-2">
                            <a href="{{ route('ternak.create') }}" class="btn btn-primary text-white mb-3">
                                Tambah Data
                            </a>
                        </p>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="table text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>NO</th>
                                        <th>Name</th>
                                        <th>Tag Number</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Pig Pen</th>
                                        <th>Date</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->name ?? '-' }}</td>
                                            <td>{{ $item->tag_number ?? '-' }}</td>
                                            <td>
                                                @if ($item->date_birthday)
                                                    @php
                                                        $dob = \Carbon\Carbon::parse($item->date_birthday);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $dob->diff($now); // Menghasilkan selisih waktu yang tepat
                                            
                                                        $years = $diff->y; // Tahun
                                                        $weeks = floor($diff->d / 7); // Menghitung minggu dari sisa hari
                                                        $days = $diff->d % 7; // Sisa hari setelah dihitung minggu
                                                    @endphp
                                                    {{ $years ? $years . ' tahun' : '' }}
                                                    {{ $weeks ? $weeks . ' minggu' : '' }}
                                                    {{ $days ? $days . ' hari' : '' }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $item->gender ?? '-' }}</td>
                                            <td>{{ $item->kandang->title ?? '-' }}</td>
                                            <td>{{ $item->date_delivered_to_farm ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('ternak.pakan', $item->id) }}"
                                                    class="btn btn-warning text-white">
                                                    <i class="fa fa-cheese"></i>
                                                </a>
                                                <a href="{{ route('ternak.edit', $item->id) }}"
                                                    class="btn btn-success text-white">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a onclick="confirmDelete('{{ route('ternak.destroy', $item->id) }}')"
                                                    class="btn btn-danger text-white">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(deleteUrl) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure you want to delete this data?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
@endsection
