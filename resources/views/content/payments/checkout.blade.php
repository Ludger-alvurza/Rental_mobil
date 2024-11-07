<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('/assets-fe/images/banner-img.png'); /* Ganti dengan URL gambar latar belakang */
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.7); /* Transparansi hitam */
            padding: 30px;
            border-radius: 10px;
            text-align: left;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 400px; /* Lebar kontainer */
        }
        h2 {
            margin-bottom: 20px;
            font-size: 2em;
            text-align: center;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 10px;
        }
        .highlight {
            color: #ffc107; /* Warna kuning untuk highlight */
            font-weight: bold;
        }
        button {
            background-color: #28a745; /* Warna hijau */
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%; /* Tombol lebar penuh */
        }
        button:hover {
            background-color: #218838; /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Checkout</h2>
        <p><span class="highlight">Nama Mobil:</span> {{$order->name}}</p>
        <p><span class="highlight">ID Pesanan:</span> {{$order->id}}</p>
        <p><span class="highlight">Lama Sewa:</span> {{$order->lama_sewa}} hari</p>
        <p><span class="highlight">Tanggal Sewa:</span> {{$order->booking_start}}</p>
        <button id="pay-button">Bayar Sekarang</button>
        <!-- Contoh: ID pesanan disimpan dalam elemen input tersembunyi -->
        <input type="hidden" id="order-id" value="{{ $order->id }}">

    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        var orderId = document.getElementById('order-id').value;

        payButton.addEventListener('click', function () {
            var snapToken = '{{ $snapToken }}';
            if (snapToken) {
                window.snap.pay(snapToken, {
                    onSuccess: function(result) {
                        Swal.fire("Pembayaran berhasil!").then(() => {
                            // Kirim notifikasi ke server
                            fetch('/pesanan/pembayaran/' + orderId, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify(result)
})
.then(response => {
    console.log('Response:', response);
    return response.text().then(text => ({ status: response.status, body: text }));
})
.then(({ status, body }) => {
    if (status === 200) {
        console.log('Notifikasi Pembayaran Berhasil Sudah Di Kirimkan Ke email anda');
        window.location.href = '/pesanan/keranjang';
    } else {
        console.error('Gagal mengirim notifikasi:', body);
        Swal.fire("Gagal mengirim notifikasi: " + body).then(() => {
            window.location.href = '/pesanan/keranjang';
        });
    }
})
.catch(error => {
    console.error('Error:', error);
    Swal.fire("Terjadi kesalahan saat mengirim notifikasi: " + error.message).then(() => {
        window.location.href = '/pesanan/keranjang';
    });
});

                        });
                        console.log(result);
                    },
                    onPending: function(result) {
                        Swal.fire("Pembayaran sedang diproses!").then(() => {
                            window.location.href = '/pesanan/keranjang'; // Ganti dengan URL yang kamu mau
                        });
                        console.log(result);
                    },
                    onError: function(result) {
                        Swal.fire("Pembayaran gagal!").then(() => {
                            window.location.href = '/pesanan/keranjang'; // Ganti dengan URL yang kamu mau
                        });
                        console.log(result);
                    },
                    onClose: function() {
                        Swal.fire('Anda menutup pop-up tanpa menyelesaikan pembayaran.');
                    }
                });
            } else {
                Swal.fire('Token pembayaran tidak tersedia. Silakan coba lagi.');
            }
        });
    </script>
    @if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
    @endif
    
    @if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
    @endif
</body>
</html>
