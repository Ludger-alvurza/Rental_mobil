<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Detail Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            font-size: 16px;
            margin: 10px 0;
            line-height: 1.6;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 20px auto;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Detail Booking</h1>
        <p>ID: {{ $booking->id }}</p>
        <p>Name: {{ $booking->name }}</p>
        <p>Mobil: {{ $booking->name_mobil }}</p>
        <p>Lama Sewa: {{ $booking->lama_sewa }}</p>
        <p>Booking Start: {{ $booking->booking_start }}</p>
        <p>Booking End: {{ $booking->booking_end }}</p>
        <p>Keterangan: {{ $booking->keterangan }}</p>
        <p>Status: {{ $booking->status }}</p>
        <a href="{{ route('keranjang.pesanan') }}" class="button">Kembali ke Keranjang</a>
    </div>
</body>
</html>
