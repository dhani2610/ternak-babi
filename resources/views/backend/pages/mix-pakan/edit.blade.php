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
            <form action="{{ route('inventory.update',$inventory->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Edit Inventory</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label for="user">Pakan</label>
                                        <select class="form-control" name="id_pakan" id="id_pakan">
                                            <option value="" disabled selected>Pilih Pakan</option>
                                            @foreach ($pakan as $item)
                                                <option value="{{ $item->id }}" {{ $inventory->id_pakan == $item->id ? 'selected' : '' }}>{{ $item->nama_pakan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Quantity Saat ini</label>
                                        <input type="number" class="form-control" id="qty_now" value="{{ $inventory->qty_now }}" name="qty_now"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Min Quantity </label>
                                        <input type="number" class="form-control" id="min_qty" value="{{ $inventory->min_qty }}" name="min_qty"
                                            required>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-6">
                                    
                                    <div class="form-group col-md-12">
                                        <label for="user">Satuan</label>
                                        @php
                                            $satuan = [
                                                'Kg','Gram','lbs','ml','Ons'
                                            ]
                                        @endphp
                                        <select class="form-control" name="satuan" id="satuan">
                                            <option value="" disabled selected>Pilih Satuan</option>
                                            @foreach ($satuan as $s)
                                                <option value="{{ $s }}" {{ $s == $inventory->satuan ? 'selected' : '' }}>{{ $s }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Harga (Rp.) 
                                            <small style="color: red"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-custom-class="custom-tooltip"
                                                    data-bs-title="Average Berdasarkan Pengeluaran Pembelian Pakan.">
                                            info
                                            </small>
                                        </label>
                                        <input type="number" class="form-control" id="price" value="{{ $inventory->price }}" name="price"
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

        // Add new Dropify input
        $('#add-row').on('click', function() {
            const newRow = `
                <div class="dropify-row mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-row" style="float: right">-</button>
                    <input type="file" name="foto_deviasi[]" class="form-control" data-height="200" accept="image/*" />
                </div>
            `;
            $('#dropify-wrapper').append(newRow);

            // Reinitialize only new Dropify elements
            $('#dropify-wrapper .dropify').each(function() {
                if (!$(this).hasClass('dropify-initialized')) {
                    $(this).dropify();
                }
            });
        });


        // Remove Dropify input
        $('#dropify-wrapper').on('click', '.remove-row', function() {
            $(this).closest('.dropify-row').remove();
        });
    </script>
@endsection
