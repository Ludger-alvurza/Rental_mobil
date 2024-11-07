<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Berhasil</title>
</head>
<body>
    <h1>Pembayaran Berhasil</h1>
    <p>Halo, <strong> {{$pembayaran->name}} </strong></p>
    <p>Pembayaran untuk pesanan <strong>{{ $pembayaran->name_mobil }}</strong> telah berhasil.</p>
    <p>Silakan klik tombol di bawah untuk melihat detail pesanan yang sudah kamu bayar</p>
    <a href="{{ url('/pesanan/pembayaran/detail/' . $pembayaran->id) }}" 
       style="display: inline-block; padding: 10px 20px; color: white; background-color: #4CAF50; text-decoration: none; border-radius: 5px;">
        Lihat Pesanan
    </a>
    <p>Terima kasih telah bertransaksi dengan kami!</p>
</body>
</html>
