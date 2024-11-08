@extends('layout.main')
@section('judul', 'Pemesanan Motor')
@section('content')
<style>
    .id_booking {
    width: 80px; /* Adjust the width as needed */
    padding: 5px; /* Reduce padding for a smaller look */
    font-size: 0.9rem; /* Adjust font size for compact display */
    text-align: center;
    border-radius: 5px;
}

    body {
    background-color: #f4f6f9;
}

.container {
    max-width: 900px;
}

.card {
    border-radius: 15px;
    overflow: hidden;
}

.card .card-body {
    padding: 1.5rem;
}

.form-control {
    border-radius: 10px;
    font-size: 1rem;
}

input[type="text"],
input[type="number"] {
    padding: 10px;
    font-weight: bold;
}

.table thead {
    background-color: #4a5568;
    color: white;
}

.table {
    margin-top: 15px;
}

.btn-primary {
    background-color: #4a90e2;
    border: none;
    font-size: 1.1rem;
    font-weight: bold;
}

.btn-primary:hover {
    background-color: #357ABD;
}

.rounded-pill {
    border-radius: 50px !important;
}

.shadow-sm {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Flexbox untuk rata kanan atas */
.card-body.d-flex.flex-column {
    justify-content: flex-start;
    align-items: flex-end;
}

.d-flex.flex-column.align-items-end > .mb-3 {
    width: 100%;
    max-width: 250px; /* Atur width form input */
}

</style>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <input type="text" id="input-barcode" name="barcode" class="form-control rounded-pill shadow-sm"
                placeholder="Masukkan nomor plat kendaraan" />
        </div>
    </div>
    <form method="post" action="{{ url('/app/insert') }}">
        <div class="row">
            @csrf
            <div class="col-12 mt-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table class="table table-striped" id="table-cart">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Plat</th>
                                    <th>Nama</th>
                                    <th>Harga Sewa</th>
                                    <th>Lama Sewa</th>
                                    <th>Total Harga Sewa</th>
                                    <th>ID Booking</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <!-- Data dari JavaScript -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="card shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-column align-items-end">
                            <div class="mb-3 w-100">
                                <label for="subtotal" class="form-label">Harga Sewa Perhari</label>
                                <input type="text" readonly name="subtotal" id="subtotal"
                                    class="form-control text-right shadow-sm rounded-pill">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="discount" class="form-label">Diskon < 24 Jam (%)</label>
                                <input type="number" min="0" max="100" name="discount" id="discount"
                                    class="form-control text-right shadow-sm rounded-pill" value="0">
                            </div>
                            <div class="mb-3 w-100">
                                <label for="total" class="form-label">Total</label>
                                <input type="text" readonly name="total" id="total"
                                    class="form-control text-right shadow-sm rounded-pill">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block rounded-pill shadow-sm">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



@endsection

@push('js')
<script>
    // Ambil elemen form input dan tombol submit
    const inputField = document.getElementById('inputField');
    const submitButton = document.getElementById('submitButton');

    // Fungsi untuk mengecek nilai input
    function checkInput() {
        if (inputField.value.trim() !== '') {
            submitButton.disabled = false; // Aktifkan tombol jika input tidak kosong
        } else {
            submitButton.disabled = true; // Nonaktifkan tombol jika input kosong
        }
    }

    // Jalankan checkInput saat input berubah
    inputField.addEventListener('input', checkInput);

    // Jalankan checkInput saat pertama kali load (untuk handle kondisi form kosong)
    checkInput();
</script>
    <script>
        $(function() {
            $('#input-barcode').on('keypress', function(e) {
                if (e.which === 13) {
                    console.log('Enter di klik');
                    //pencarian data via ajax
                    $.ajax({
                        url: '/app/search-barcode',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            no_plat: $(this).val()
                        },
                        success: function(data) {
                            addProductToTable(data);
                            toastr.success('Detail Rental berhasil ditambahkan', 'Berhasil');
                            $('#input-barcode').val('');

                        },
                        error: function() {
                            toastr.error('nomor Plat yang dicari tidak ditemukan', 'Error');
                            $('#input-barcode').val('');
                        }
                    })
                }
            });

            function addProductToTable(mobil) {
                let rowExist = $('#table-cart tbody').find('#p-' + mobil.no_plat);
                let telat = 1; // Hitung keterlambatan pengembalian di sini
                let telat1 = 3; // Hitung keterlambatan pengembalian di sini
                let telat2 = 5; // Hitung keterlambatan pengembalian di sini
                let telat3 = 24; // Hitung keterlambatan pengembalian di sini
                let denda = hitungDenda(telat);
                let denda1 = hitungDenda(telat1);
                let denda2 = hitungDenda(telat2);
                let denda3 = hitungDenda(telat3);

                if (rowExist.length > 0) {
                    let qtyInput = rowExist.find('.qty').eq(0);
                    let qty = parseInt(qtyInput.val().split(' ')[0]);
                    qty += 1;
                    qtyInput.val(qty);
                    rowExist.find('td').eq(3).text(qty + ' hari');
                    rowExist.find('td').eq(4).text((qty * mobil.price_per_day));
                } else {
                    let row = '';
                    row += `<tr id='p-${mobil.no_plat}'>`;
                    row += `<td>${mobil.no_plat}</td>`;
                    row += `<td>${mobil.name}</td>`;
                    row += `<td>${mobil.price_per_day}</td>`;
                    row += `<input type='hidden' name='price[]' class='price' value="${mobil.price_per_day}" />`;
                    row += `<input type='hidden' name='qty[]' class='qty' value="1" />`;
                    row += `<input type='hidden' name='id_mobil[]' value="${mobil.id}" />`;
                    row += `<td>1 hari</td>`;
                    row += `<td>${mobil.price_per_day}</td>`;
                    row += `<input type='hidden' name='denda[]' value='${denda}' />`;
                    row += `<input type='hidden' name='denda1[]' value='${denda1}' />`;
                    row += `<input type='hidden' name='denda2[]' value='${denda2}' />`;
                    row += `<input type='hidden' name='denda3[]' value='${denda3}' />`;
                  //  row += `<td>${denda}</td>`; 
                  //  row += `<td>${denda1}</td>`; 
                  //  row += `<td>${denda2}</td>`;
                  //  row += `<td>${denda3}</td>`;
                    row += `<td><input type='number' name='id_booking[]' class='id_booking' /></td>`;
                    row += `</tr>`;
                    $('#table-cart tbody').append(row);
                }
                hitungTotalBelanja();
            }

            function hitungTotalBelanja() {
                let subtotal = 0;
                $.each($('.price'), function(index, obj) {
                    let price_per_hour = $(this).val(); // Ubah menjadi harga per jam
                    let qty = $('.qty').eq(index).val();
                    subtotal += parseInt(price_per_hour) * parseInt(
                    qty); // Hitung subtotal berdasarkan harga per jam dan jumlah jam sewa
                    console.log(price_per_hour, qty);
                });
                let discount = parseInt($('#discount').val());
                let total = subtotal - (subtotal * discount / 100);
                $('#subtotal').val(subtotal);
                $('#total').val(total);
            }

            $('#discount').on('change', function() {
                hitungTotalBelanja();
            })

        });

        function hitungDenda(telat) {
            let denda = 0;
            const denda_1_jam = 5000;
            const denda_3_jam = 10000;
            const denda_5_jam = 15000;
            const denda_24_jam = 40000;

            if (telat >= 1 && telat < 3) {
                denda = denda_1_jam;
            } else if (telat >= 3 && telat < 5) {
                denda = denda_3_jam;
            } else if (telat >= 5 && telat < 24) {
                denda = denda_5_jam;
            } else if (telat >= 24) {
                denda = denda_24_jam;
            }
            return denda;
        }
    </script>
@endpush
