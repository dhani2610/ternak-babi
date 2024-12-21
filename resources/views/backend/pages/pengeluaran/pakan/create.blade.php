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

    <div class="main-content-inner">
        <div class="row">
            <form action="{{ route('pengeluaran-pakan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Tambah</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label for="user">Supplier</label>
                                        <select class="form-control" name="id_supplier" id="id_supplier">
                                            <option value="" disabled selected>Pilih Supplier</option>
                                            @foreach ($supplier as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Title</label>
                                        <input type="text" class="form-control" id="title" name="title"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="user">Pakan</label>
                                        <select class="form-control" name="id_pakan" id="id_pakan">
                                            <option value="" disabled selected>Pilih Pakan</option>
                                            @foreach ($pakan as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_pakan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Quantity</label>
                                        <input type="number" class="form-control" id="qty" name="qty"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Harga Satuan (Rp.) </label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            required>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Tanggal Pembelian</label>
                                        <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Tanggal Pengiriman</label>
                                        <input type="date" class="form-control" id="tanggal_pengiriman" name="tanggal_pengiriman"
                                            required>
                                    </div>
                                </div>
                            </div>
                           
                            <button class="btn btn-primary mt-4" type="submit" style="float: right">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <script>
        // Initialize Dropify
        $('.dropify').dropify();

    </script>
@endsection
