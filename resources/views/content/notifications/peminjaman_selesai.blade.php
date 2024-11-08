<!-- resources/views/notifications/peminjaman_selesai.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Selesai</title>
    <style>
        /* Custom styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            color: #ffffff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Halo, {{ $user->name }}!</h1>
        <p>Pengembalian mobil dengan nama "<strong>{{ $peminjaman->mobil->name }}</strong>" telah berhasil dikonfirmasi.
        </p>
        <p>Anda dapat memberikan rating untuk pengalaman peminjaman ini.</p>
        <a href="{{ url('message_ratings/review/' . $peminjaman->mobil->id) }}" class="button">Berikan Rating</a>
        <p>Terima kasih telah menggunakan aplikasi kami!</p>
    </div>
</body>

</html>
