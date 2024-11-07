<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil Diverifikasi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; font-size: 24px; font-weight: bold; color: #333; }
        .content { margin-top: 20px; }
        .footer { margin-top: 30px; font-size: 12px; color: #555; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Pesanan Anda Berhasil Diverifikasi</div>
        
        <div class="content">
            <p>Halo, {{ $bkuser->name }},</p>
            <p>Pesanan Anda dengan ID <strong>{{ $bkuser->id }}</strong> telah berhasil diverifikasi. Berikut adalah detail pesanan Anda:</p>

            <table>
                <tr>
                    <td><strong>Nama Pengguna:</strong></td>
                    <td>{{ $bkuser->name }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor Plat:</strong></td>
                    <td>{{ $bkuser->no_plat }}</td>
                </tr>
                <tr>
                    <td><strong>Nama Mobil:</strong></td>
                    <td>{{ $bkuser->name_mobil }}</td>
                </tr>
                <tr>
                    <td><strong>Lama Sewa:</strong></td>
                    <td>{{ $bkuser->lama_sewa }}</td>
                </tr>
                <tr>
                    <td><strong>Keterangan:</strong></td>
                    <td>{{ $bkuser->keterangan }}</td>
                </tr>
                <tr>
                    <td><strong>Status Pembayaran:</strong></td>
                    <td>{{ $bkuser->payment_status }}</td>
                </tr>
                {{-- <tr>
                    <td><strong>Status Booking:</strong></td>
                    <td>{{ $bkuser->status_booking }}</td>
                </tr> --}}
                <tr>
                    <td><strong>Tanggal Mulai Booking:</strong></td>
                    <td>{{ $bkuser->booking_start }}</td>
                </tr>
                <tr>
                    <td><strong>Tanggal Akhir Booking:</strong></td>
                    <td>{{ $bkuser->booking_end }}</td>
                </tr>
            </table>

            <p>Terima kasih telah menggunakan layanan kami!</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Layanan Kami</p>
        </div>
    </div>
</body>
</html>
