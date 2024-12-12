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
                        <h4 class="header-title float-left">Data Inventory Pakan</h4>
                        <p class="float-right mb-2">
                            <a href="{{ route('inventory.create') }}" class="btn btn-primary text-white mb-3" style="float: right">
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
                                        <th>Pakan</th>
                                        <th>Stok</th>
                                        <th>Min Stok</th>
                                        <th>Harga</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Tanggal Update</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @php
                                                $pakan = App\Models\Pakan::where('id', $item->id_pakan)->first();
                                                if ($item->qty_now < $item->min_qty ) {
                                                    $bg = 'red';
                                                    $color = 'white';
                                                }else{
                                                    $bg = '';
                                                    $color = 'black';
                                                }
                                            @endphp
                                            <td>
                                                @if ($pakan != null)
                                                    {{ $pakan->nama_pakan }}   
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td style="background: {{ $bg }};color: {{ $color }}">
                                                {{ $item->qty_now }} ({{ $item->satuan }})
                                            </td>
                                            <td>{{ $item->min_qty }} ({{ $item->satuan }})</td>
                                            <td>@currency($item->price) / {{ $item->satuan }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td>{{ $item->updated_at }}</td>
                                            <td>
                                                <a href="{{ route('inventory.edit', $item->id) }}"
                                                    class="btn btn-success text-white">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a onclick="confirmDelete('{{ route('inventory.destroy', $item->id) }}')"
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
