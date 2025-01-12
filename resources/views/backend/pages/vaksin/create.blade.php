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
            <form action="{{ route('vaksin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Tambah Vaksin</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Nama Vaksin</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="user">Satuan</label>
                                        <select class="form-control" name="id_satuan" id="id_satuan">
                                            <option value="" disabled selected>Pilih Satuan</option>
                                            @foreach ($satuan as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Dosis</label>
                                        <input type="text" class="form-control" id="dosis" name="dosis" required>
                                    </div>
                                    
                                </div>
                               
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Cara Pemakaian</label>
                                        <textarea name="cara_pemakaian" class="form-control" id="" cols="30" rows="10"></textarea>
                                    </div>
                                    
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Catatan</label>
                                        <textarea name="catatan" class="form-control" id="" cols="30" rows="10"></textarea>
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
