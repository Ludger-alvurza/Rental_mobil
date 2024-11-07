<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Pembatalan Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Halo Admin,</h2>
        <p>Pesanan dengan ID <strong>{{ $bkuser->id }}</strong> telah dibatalkan oleh pengguna.</p>
        <p><strong>Detail Pesanan:</strong></p>
        <ul>
            <li>User ID: {{ $bkuser->id_user }}</li>
            <li>Status: {{ $bkuser->pembatalan }}</li>
            <li>Pesanan Dibuat Pada: {{ $bkuser->created_at }}</li>
        </ul>
        <a class="button" href="{{ url('/pesanan/batal/' . $bkuser->id) }}">Lihat Pesanan</a>
        <p>Silakan periksa sistem untuk informasi lebih lanjut.</p>
        <p>Terima kasih telah menggunakan aplikasi kami!</p>
    </div>
</body>
</html>
