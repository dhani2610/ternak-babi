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
            color: black;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
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
            <div class="col-lg-6 mb-lg-0 mb-2">
                <div class="card" style="background: green">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex flex-column h-100">
                                    <h2 class="font-weight-bolder" style="color: white">Sisa Pakan
                                    </h2>
                                    <h2 class="font-weight-bolder" style="color: white">
                                        {{ $count . ' Kg' }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0 mb-2">
                <div class="card" style="background: green">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="d-flex flex-column h-100">
                                    <h2 class="font-weight-bolder" style="color: white">Pakan Digunakan
                                    </h2>
                                    <h2 class="font-weight-bolder" style="color: white">
                                        {{ $pakan_use->sum('qty') . ' Kg' }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form action="{{ route('ternak.pakan.store',$pig->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Pakan</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Quantity</label>
                                        <div class="input-group">
                                            <input class="form-control" type="number" step="any" placeholder="Quantity"
                                                data-val="true" id="qty" name="qty" value="0" required>
                                            <div class="input-group-text">KG</div>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Catatan</label>
                                        <textarea name="catatan" class="form-control" id=""></textarea>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary mt-4" type="submit" style="float: right">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">History</h4>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="table text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>NO</th>
                                        <th>Quantity</th>
                                        <th>Catatan</th>
                                        <th>Tanggal</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pakan_use as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->qty .' Kg' }}</td>
                                            <td>{{ $item->catatan ?? '-' }}</td>
                                            <td>{{ $item->tanggal ?? '-' }}</td>
                                            
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
