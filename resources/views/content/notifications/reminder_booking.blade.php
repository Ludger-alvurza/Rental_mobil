<!-- resources/views/notifications/reminder_booking.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reminder Booking</title>
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
            margin: 20px auto;
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
        <p>Ini adalah pengingat bahwa Anda memiliki jadwal rental mobil pada tanggal <strong>{{ $booking->booking_start }}</strong>.</p>
        <p>Jangan lupa untuk mempersiapkan segala keperluan sebelum jadwal rental.</p>
        <a href="{{ url('/pesanan/detail/'.$booking->id) }}" class="button">Cek Detail Booking</a>
        <p>Terima kasih telah menggunakan layanan kami!</p>
    </div>
</body>
</html>
