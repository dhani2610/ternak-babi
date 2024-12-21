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
                        <h4 class="header-title float-left">Data Mix Pakan</h4>
                        <p class="float-right mb-2">
                            <a href="{{ route('mix-pakan.create') }}" class="btn btn-primary text-white mb-3"
                                style="float: right">
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
                                        <th>Title</th>
                                        {{-- <th>Total Harga</th> --}}
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->title }}</td>
                                            {{-- <th>@currency($item->total_harga)</th> --}}
                                            <td>{{ $item->created_at }}</td>
                                            <td>
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">
                                                    <i class="fa-solid fa-eye"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Mix Pakan
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @php
                                                                    $pakanv = App\Models\MixPakanDetail::where(
                                                                        'id_mix',
                                                                        $item->id,
                                                                    )->get();
                                                                @endphp

                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered" id="pakan-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Pakan</th>
                                                                                <th>Qty</th>
                                                                                {{-- <th>Price</th>
                                                                                <th>Total</th> --}}
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($pakanv as $p)
                                                                                @php
                                                                                    $vp = App\Models\Pakan::where(
                                                                                        'id',
                                                                                        $p->id_pakan,
                                                                                    )->first();
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>{{ $vp->nama_pakan }}</td>
                                                                                    <td>{{ $p->qty }}</td>
                                                                                    {{-- <td>@currency($p->price)</td>
                                                                                    <td>@currency($p->total)</td> --}}
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a onclick="confirmDelete('{{ route('mix-pakan.destroy', $item->id) }}')"
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
