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
            <form action="{{ route('mix-pakan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Tambah</h4>
                            <hr>
                            <div class="form-group col-md-12 mb-3">
                                <label for="pakan">Title</label>
                                <input type="text" required name="title" class="form-control">
                            </div>
                            <hr>
                            <button type="button" class="btn btn-success mb-3" style="float: right" id="add-row">+</button>

                            <div class="form-group col-md-12">
                                <label for="pakan">Pilih Pakan</label>
                                <select class="form-control" id="pakan-select">
                                    <option value="" disabled selected>Pilih Pakan</option>
                                    @foreach ($pakan as $item)
                                        @php
                                            $pakanv = App\Models\Pakan::where('id', $item->id_pakan)->first();
                                        @endphp
                                        <option value="{{ $pakanv->id }}" data-qty-now="{{ $item->qty_now }}" data-price="{{ $item->price }}">
                                            {{ $pakanv->nama_pakan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <hr>
                            <table class="table table-bordered" id="pakan-table">
                                <thead>
                                    <tr>
                                        <th>Pakan</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">Grand Total:</th>
                                        <th id="grand-total">Rp 0</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                           
                            <button class="btn btn-primary mt-4" type="submit" style="float: right">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }

        document.getElementById('add-row').addEventListener('click', function () {
            const pakanSelect = document.getElementById('pakan-select');
            const selectedOption = pakanSelect.options[pakanSelect.selectedIndex];
            const pakanId = selectedOption.value;
            const pakanName = selectedOption.text;
            const qtyNow = parseInt(selectedOption.getAttribute('data-qty-now'));
            const price = parseInt(selectedOption.getAttribute('data-price'));

            if (!pakanId) {
                Swal.fire('Error', 'Silahkan pilih pakan terlebih dahulu', 'error');
                return;
            }

            const existingRows = document.querySelectorAll('#pakan-table tbody tr');
            for (let row of existingRows) {
                if (row.dataset.pakanId === pakanId) {
                    Swal.fire('Error', 'Pakan sudah ada di tabel', 'error');
                    return;
                }
            }

            Swal.fire({
                title: 'Masukkan Quantity',
                input: 'number',
                inputAttributes: {
                    min: 1,
                    max: qtyNow,
                    step: 1
                },
                inputPlaceholder: `Max: ${qtyNow}`,
                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value || isNaN(value) || value <= 0 || value > qtyNow) {
                        return `Qty harus antara 1 dan ${qtyNow}`;
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const qty = parseInt(result.value);
                    const total = qty * price;

                    const newRow = `
                        <tr data-pakan-id="${pakanId}">
                            <td>${pakanName}<input type="hidden" name="id_pakan[]" value="${pakanId}"></td>
                            <td>${qty}<input type="hidden" name="qty[]" value="${qty}"></td>
                            <td>${formatRupiah(price)}<input type="hidden" name="price[]" value="${price}"></td>
                            <td>${formatRupiah(total)}<input type="hidden" name="total[]" value="${total}"></td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    `;

                    document.querySelector('#pakan-table tbody').insertAdjacentHTML('beforeend', newRow);
                    calculateGrandTotal();
                }
            });
        });

        document.getElementById('pakan-table').addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
                calculateGrandTotal();
            }
        });

        function calculateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('#pakan-table tbody tr').forEach(row => {
                const total = parseInt(row.children[3].querySelector('input').value);
                grandTotal += total;
            });
            document.getElementById('grand-total').innerText = formatRupiah(grandTotal);
        }
    </script>
@endsection