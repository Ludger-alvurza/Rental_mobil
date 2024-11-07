<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembayaran Sukses</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 8px; }
        .title { font-size: 24px; font-weight: bold; color: #4CAF50; }
        .detail-item { margin: 15px 0; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Pembayaran Berhasil</h1>
        <p>Terima kasih telah melakukan pembayaran. Berikut adalah detail transaksi Anda:</p>
        <div class="detail-item">
            <span class="label">Nama Mobil:</span> {{ $bkuser->name_mobil }}
        </div>
        <div class="detail-item">
            <span class="label">Harga:</span> Rp {{ number_format($transaction->transaction->total, 0, ',', '.') }}
        </div>
        <div class="detail-item">
            <span class="label">Tanggal Pembayaran:</span> {{ \Carbon\Carbon::now()->format('Y-m-d') }}
        </div>
        <div class="detail-item">
            <span class="label">Status:</span> <span style="color: #4CAF50;">Sukses</span>
        </div>
        <a href="{{ url('/sewa-mobil') }}" style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
