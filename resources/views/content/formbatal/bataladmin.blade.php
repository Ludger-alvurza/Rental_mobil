<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Message Rating</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/assets-fe/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets-fe/css/style.css">
    <link rel="stylesheet" href="/assets-fe/css/responsive.css">
    <style>
        body {
            background-image: url('/assets-fe/images/banner-img.png');
            background-size: cover;
            background-position: center;
            color: white;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        .form-label {
            font-weight: bold;
        }
    </style>    
</head>
<body>

<div class="container mt-5">
    <h1>Detail Booking</h1>
    <p>ID: {{ $row->id }}</p>
    <p>Name: {{ $row->name }}</p>
    <p>Mobil: {{ $row->name_mobil }}</p>
    <p>Lama Sewa: {{ $row->lama_sewa }}</p>
    <p>Booking Start: {{ $row->booking_start }}</p>
    <p>Booking End: {{ $row->booking_end }}</p>
    <p>Keterangan: {{ $row->keterangan }}</p>
    <p>Status: {{ $row->status }}</p>

    <form method="post" action="{{ url('pesanan/batal') }}">
        @csrf
        <input type="hidden" name="id" value="{{ $row->id }}" />
        
        <div class="mb-3">
            <label for="pembatalan" class="form-label">Silahkan Pilih Tindakan</label>
            <select class="form-select" id="pembatalan" name="pembatalan" required>
                <option value="Dipesan" {{ $row->Pembatalan == 'Dipesan' ? 'selected' : '' }}>Lanjutkan pesanan</option>
                <option value="Dibatalkan" {{ $row->Pembatalan == 'Dibatalkan' ? 'selected' : '' }}>Batalkan pesanan</option>
                <option value="Terverifikasi" {{ $row->Pembatalan == 'Terverifikasi' ? 'selected' : '' }}>Verifikasi Pesanan</option>
            </select>
            <div class="invalid-feedback">Silakan pilih salah satu tindakan.</div>
        </div>
    
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');

        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
</body>
</html>
