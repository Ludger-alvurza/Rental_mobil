<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" rel="stylesheet">
<style>
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slideUp 1s ease-out;
        /* Durasi 1 detik */
    }

    /* Gaya untuk header dropdown */
    .dropdown-header {
        font-size: 12px;
        font-weight: bold;
        padding: 10px;
        background-color: #f8f9fa;
        text-align: center;
    }

    /* Gaya untuk item dropdown */
    .dropdown-item {
        padding: 10px 15px;
        font-size: 16px;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #e9ecef;
    }

    /* Gaya untuk dropdown menu */
    .dropdown-menu {
        width: 250px;
        max-height: 300px;
        overflow-y: auto;
        padding: 5px;
        border-radius: 5px;
    }
</style>
<div class="gallery_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="gallery_taital">Mobil Rental</h1>
            </div>
        </div>
        <div class="gallery_section_2">
            <div class="row" id="resultSection">
                @if ($kendaraan->isEmpty())
                    <div class="col-md-12">
                        <h3 class="text-center">Mobil yang kamu cari nggak ada, bro!</h3>
                    </div>
                @else
                    @foreach ($kendaraan as $index => $row)
                        <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="{{ $isMobile ? 0 : $index * 200 }}">
                            <div class="gallery_box">
                                <div class="gallery_img">
                                    <img src="{{ route('storage', $row->gambar) }}" alt="{{ $row->name }}">
                                </div>
                                <h3 class="types_text">{{ $row->name }}</h3>
                                <p class="looking_text">Start per day Rp
                                    {{ number_format($row->price_per_day, 0, ',', '.') }}</p>
                                <p style="font-family: 'Arial', sans-serif; font-size: 16px; color: black;">
                                    {{ number_format($row->avg_rating, 1) }}
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($row->avg_rating >= $i)
                                            <span style="color: gold;">★</span> <!-- Bintang penuh warna kuning -->
                                        @elseif ($row->avg_rating >= $i - 0.5)
                                            <span style="color: gold;">☆</span> <!-- Bintang setengah warna kuning -->
                                        @else
                                            <span style="color: gray;">☆</span> <!-- Bintang kosong warna abu -->
                                        @endif
                                    @endfor
                                    <span style="font-weight:">({{ $row->total_ratings }})</span>
                                </p>
                                <div class="read_bt">
                                    @if ($row->availability == 'Tersedia')
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#bookingModal{{ $row->id }}">Book Now</a>
                                    @else
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#notAvailableModal{{ $row->id }}">Mobil Tidak
                                            Tersedia</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- modal not availability --}}
                        <div class="modal fade" id="notAvailableModal{{ $row->id }}" tabindex="-1"
                            aria-labelledby="notAvailableModalLabel{{ $row->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="notAvailableModalLabel{{ $row->id }}">Mobil
                                            Tidak Tersedia</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Mobil {{ $row->name }} sedang tidak tersedia saat ini. Silakan coba lagi
                                            nanti.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Form Booking -->
                        <div class="modal fade" id="bookingModal{{ $row->id }}" tabindex="-1"
                            aria-labelledby="bookingModalLabel{{ $row->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookingModalLabel{{ $row->id }}">Pesan
                                            {{ $row->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Tombol untuk menampilkan dropdown -->
                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $row->id }}" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            Lihat Tanggal Tersedia
                                        </button>

                                        <!-- Dropdown menu yang berisi tanggal -->
                                        <div class="dropdown-menu"
                                            aria-labelledby="dropdownMenuButton{{ $row->id }}">
                                            <h6 class="dropdown-header">Tanggal Tersedia untuk {{ $row->name }}</h6>
                                            <!-- Menampilkan daftar tanggal -->
                                            @foreach ($row->available_dates as $date)
                                                <span class="dropdown-item text-muted">
                                                    {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                                                </span>
                                            @endforeach
                                        </div>
                                        <form method="post" action="{{ url('pesanan/insert') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $row->id }}"
                                                required />
                                            <div class="form-group">
                                                <input type="hidden"
                                                    class="form-control @error('id_mobil') is-invalid @enderror"
                                                    value="{{ $row->id }}" name="id_mobil" readonly required>
                                                @error('id_mobil')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!-- Formulir Pesanan Mobil -->
                                            <div class="form-group">
                                                <label for="">no_plat</label>
                                                <input type="text"
                                                    class="form-control @error('no_plat') is-invalid @enderror"
                                                    value="{{ $row->no_plat }}" name="no_plat" readonly required>
                                                @error('no_plat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Mobil</label>
                                                <input type="text"
                                                    class="form-control @error('name_mobil') is-invalid @enderror"
                                                    value="{{ $row->name }}" name="name_mobil" readonly required>
                                                @error('name_mobil')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name') }}"
                                                    placeholder="silahkan masukan nama lengkap" name="name"
                                                    required>
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Lama Sewa</label>
                                                <input type="text"
                                                    class="form-control @error('lama_sewa') is-invalid @enderror"
                                                    value="{{ $row->lama_sewa }}" name="lama_sewa" required>
                                                @error('lama_sewa')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="booking_start">Tanggal Mulai Sewa</label>
                                                <input type="date"
                                                    class="form-control @error('booking_start') is-invalid @enderror"
                                                    value="{{ old('booking_start', $row->booking_start) }}"
                                                    name="booking_start" required
                                                    id="booking_start{{ $row->id }}">
                                                @error('booking_start')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="booking_end">Tanggal Akhir Sewa</label>
                                                <input type="date"
                                                    class="form-control @error('booking_end') is-invalid @enderror"
                                                    value="{{ old('booking_end', $row->booking_end) }}"
                                                    name="booking_end" required id="booking_end{{ $row->id }}">
                                                @error('booking_end')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="">Keterangan</label>
                                                <textarea type="text" class="form-control @error('keterangan') is-invalid @enderror"
                                                    value="{{ $row->keterangan }}" name="keterangan" required></textarea>
                                                @error('keterangan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden"
                                                    class="form-control @error('id_user') is-invalid @enderror"
                                                    value="{{ $userT->id }}" name="id_user" required>
                                                @error('id_user')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <!-- Tambahkan input lainnya sesuai kebutuhan -->
                                            <button class="btn btn-primary">Simpan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    .gallery_box {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 20px;
        text-align: center;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .gallery_img img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .types_text {
        font-size: 18px;
        margin: 10px 0;
        min-height: 60px;
    }

    .looking_text {
        font-size: 16px;
        margin-bottom: 15px;
    }

    .read_bt a {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
</style>
</div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isMobile = window.innerWidth <= 768;
            console.log("Is Mobile:", isMobile);

            document.querySelectorAll('[data-aos-delay]').forEach((element, index) => {
                const delay = isMobile ? 0 : index * 200;
                element.setAttribute('data-aos-delay', delay);
                console.log(`Element ${index}: AOS delay set to ${delay}`);
            });

            // Inisialisasi AOS setelah delay diterapkan
            AOS.init();
        });
    </script>

    <script>
        // Cek apakah ada hasil pencarian
        document.addEventListener('DOMContentLoaded', function() {
            const resultSection = document.getElementById('resultSection');

            // Cek jika ada elemen hasil pencarian
            if (resultSection) {
                // Auto scroll ke bagian hasil pencarian
                resultSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.24.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>

    <script>
        $(function() {
            $('form').on('submit', function(e) {
                e.preventDefault(); // Mencegah pengiriman form secara default

                // Ambil data dari form
                const formData = $(this).serialize(); // Mengambil semua data form sebagai query string

                // Validasi manual
                let isValid = true;
                let errorMessage = '';

                // Cek setiap field yang wajib diisi
                $(this).find('input, textarea').each(function() {
                    if ($(this).attr('required') && !$(this).val()) {
                        isValid = false;
                        errorMessage +=
                            `Field ${$(this).attr('name')} tidak boleh kosong!\n`; // Menyimpan pesan error
                    }
                });

                if (!isValid) {
                    Swal.fire('Gagal', errorMessage, 'error'); // Tampilkan pesan error jika ada yang kosong
                    return; // Keluar dari fungsi jika ada field yang kosong
                }

                // Tampilkan alert konfirmasi sebelum memproses peminjaman
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Pastikan Anda telah membaca ketentuan dan syarat peminjaman. Dengan mengklik OK, Anda menyetujui persyaratan dan ketentuan peminjaman.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna mengklik OK, lanjutkan proses peminjaman
                        $.ajax({
                            url: '{{ url('pesanan/insert') }}', // Pastikan ini sesuai dengan route backend
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                Swal.fire({
                                    title: 'Sukses',
                                    text: 'Pesanan berhasil, silakan tunggu verifikasi',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(function() {
                                    window.location
                                        .reload(); // Reload halaman setelah pesan sukses
                                });
                            },
                            error: function(xhr) {
                                let errorMessage =
                                    'Terjadi kesalahan saat memproses pesanan';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON
                                        .message; // Ambil pesan error dari server jika ada
                                }
                                Swal.fire({
                                    title: 'Gagal',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });


                    }
                });
            });

            // Handler klik untuk tautan Search Now
            $('#searchBtn').on('click', function(e) {
                e.preventDefault(); // Mencegah aksi default tombol

                // Ambil data dari form pencarian
                const formData = $('#searchForm').serialize();

                // Redirect ke URL pencarian dengan data form
                window.location.href = $('#searchForm').attr('action') + '?' + formData;
            });
        });
    </script>



    {{-- <script>
    $(function () {

        @if (session()->has('gagal'))
        toastr.error('{{Session::get('gagal')}}', 'Error')
        @endif
        @if (session()->has('berhasil'))
        toastr.success('{{Session::get('berhasil')}}', 'Berhasil')
        @endif
    });
</script>
</script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');
            const today = new Date().toISOString().split('T')[0]; // Tanggal hari ini dalam format YYYY-MM-DD

            modals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function() {
                    const modalId = modal.getAttribute('id').replace('bookingModal', '');
                    const bookingStart = document.getElementById(`booking_start${modalId}`);
                    const bookingEnd = document.getElementById(`booking_end${modalId}`);

                    if (bookingStart && bookingEnd) {
                        // Set minimal tanggal pada `booking_start` sebagai hari ini
                        bookingStart.setAttribute('min', today);

                        // Event listener saat `booking_start` berubah
                        bookingStart.addEventListener('change', function() {
                            if (bookingStart.value) {
                                const startDate = new Date(bookingStart.value);
                                const minDate = startDate.toISOString().split('T')[0];

                                // Reset `booking_end` jika sudah diisi
                                if (bookingEnd.value) {
                                    bookingEnd.value = ''; // Kosongkan input
                                    Swal.fire({
                                        title: 'Perhatian',
                                        text: "Tanggal akhir harus diisi ulang karena tanggal mulai telah diubah.",
                                        icon: 'warning',
                                        confirmButtonText: 'OK'
                                    });
                                }

                                // Set `min` date untuk `booking_end`
                                bookingEnd.setAttribute('min', minDate);
                            }
                        });

                        // Optional: Menambahkan listener untuk `booking_end`
                        bookingEnd.addEventListener('change', function() {
                            if (bookingEnd.value) {
                                const endDate = new Date(bookingEnd.value);
                                const startDate = new Date(bookingStart.value);
                                if (startDate && endDate < startDate) {
                                    bookingEnd.value = '';
                                    Swal.fire({
                                        title: 'Invalid Date',
                                        text: "Tanggal akhir tidak boleh sebelum tanggal mulai. Silakan pilih ulang.",
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}");
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif

@endpush
