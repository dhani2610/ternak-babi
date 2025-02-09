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
            <form action="{{ route('penggunaan-vaksin.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Tambah</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group col-md-12">
                                        <label for="user">Vaksin</label>
                                        <select class="form-control" name="id_vaksin" id="id_vaksin">
                                            <option value="" disabled selected>Pilih Vaksin</option>
                                            @foreach ($vaksin as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Quantity</label>
                                        <input type="number" class="form-control" id="jumlah" name="jumlah"
                                            required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Tanggal Penggunaan</label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                                            required>
                                    </div>
                                  
                                </div>
                                <div class="col-lg-6">
                                  
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="perusahaan">Catatan</label>
                                        <textarea name="catatan" class="form-control" required id="" cols="30" rows="10"></textarea>
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
        document.addEventListener('DOMContentLoaded', function () {
                const qtyInput = document.getElementById('qty');
                const priceInput = document.getElementById('price');
                const totalPriceInput = document.getElementById('total_price');

                function formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                }

                function calculateTotal() {
                    const qty = parseFloat(qtyInput.value) || 0;
                    const price = parseFloat(priceInput.value) || 0;
                    const total = qty * price;
                    totalPriceInput.value = formatRupiah(total);
                }

                qtyInput.addEventListener('input', calculateTotal);
                priceInput.addEventListener('input', calculateTotal);
            });



    </script>
    
@endsection
