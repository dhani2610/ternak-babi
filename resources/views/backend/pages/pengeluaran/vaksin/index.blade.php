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
                        <h4 class="header-title float-left">Data Pengeluaran Vaksin</h4>
                        <p class="float-right mb-2">
                            <a href="{{ route('pengeluaran-vaksin.create') }}" class="btn btn-primary text-white mb-3" style="float: right">
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
                                        <th>Supplier</th>
                                        <th>Title</th>
                                        <th>Vaksin</th>
                                        <th>Quantity</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Tanggal Pengiriman</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @php
                                                $supplier = App\Models\Supplier::where('id', $item->id_supplier)->first();
                                            @endphp
                                            @if ($supplier != null)
                                                <td>{{ $supplier->nama ?? '-' }}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{ $item->title }}</td>
                                            <td>
                                                {{ $item->vaksin->nama ?? '-' }}   
                                            </td>
                                            <td>
                                                {{ $item->qty }} 
                                            </td>
                                            <td>@currency($item->price)</td>
                                            <td>@currency($item->price * $item->qty)</td>
                                            <td>{{ $item->tanggal_pembelian }}</td>
                                            <td>{{ $item->tanggal_pengiriman }}</td>
                                            <td>
                                                <a onclick="confirmDelete('{{ route('pengeluaran-vaksin.destroy', $item->id) }}')"
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
