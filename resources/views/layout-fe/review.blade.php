<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Message Rating</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Tambahkan ini -->
    <style>
        body {
            background-image: url('/assets-fe/images/banner-img.png'); /* Ganti dengan path gambar kamu */
            background-size: cover;
            background-position: center;
            color: white; /* Mengubah warna teks agar terlihat di background */
        }
    
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Membuat latar belakang transparan di kontainer */
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(5px); /* Menambahkan efek blur */
            -webkit-backdrop-filter: blur(5px); /* Untuk dukungan browser Safari */
        }
    
        .star {
            font-size: 2rem;
            cursor: pointer;
            color: lightgray;
        }
        .star.selected {
            color: gold;
        }
    </style>    
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Tambah Data Message Rating</h2>
    <form method="post" action="{{ url('message_ratings/insert') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_mobil" value="{{ $mobil->id }}" />
        
        <div class="form-group">
            <label for="rating">Rating</label>
            <div id="rating" class="mb-2">
                <span class="star" data-value="1">&#9733;</span>
                <span class="star" data-value="2">&#9733;</span>
                <span class="star" data-value="3">&#9733;</span>
                <span class="star" data-value="4">&#9733;</span>
                <span class="star" data-value="5">&#9733;</span>
            </div>
            <input type="hidden" name="rating" id="rating-input" value="0">
            <div class="invalid-feedback">
                Mohon pilih rating.
            </div>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" 
                      class="form-control @error('message') is-invalid @enderror" 
                      required maxlength="30">{{ old('message') }}</textarea>
            @error('message')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('.star').on('click', function() {
            const ratingValue = $(this).data('value');
            $('#rating-input').val(ratingValue);
            $('.star').removeClass('selected');
            for (let i = 1; i <= ratingValue; i++) {
                $(`.star[data-value="${i}"]`).addClass('selected');
            }
        });
    });
</script>
</body>
</html>
