<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
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
                            data-aos-delay="{{ $index * 200 }}">
                            <div class="gallery_box">
                                <div class="gallery_img">
                                    <img src="{{ route('storage', $row->gambar) }}" alt="{{ $row->name }}">
                                </div>
                                <h3 class="types_text">{{ $row->name }} <br>{{ $row->availability }}</h3>
                                <p class="looking_text">Start per day Rp.{{ $row->price_per_day }}</p>
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
                                        <form method="post" action="{{ url('pesanan/insert') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $row->id }}" required/>
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
                                                    placeholder="silahkan masukan nama lengkap" name="name" required>
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
    
    <script>
        $(function () {
            $('form').on('submit', function (e) {
                e.preventDefault(); // Mencegah pengiriman form secara default
            
                // Ambil data dari form
                const formData = $(this).serialize(); // Mengambil semua data form sebagai query string
            
                // Validasi manual
                let isValid = true;
                let errorMessage = '';
            
                // Cek setiap field yang wajib diisi
                $(this).find('input, textarea').each(function () {
                    if ($(this).attr('required') && !$(this).val()) {
                        isValid = false;
                        errorMessage += `Field ${$(this).attr('name')} tidak boleh kosong!\n`; // Menyimpan pesan error
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
                            url: '{{ url("pesanan/insert") }}', // Pastikan ini sesuai dengan route backend
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                Swal.fire('Sukses', 'Pesanan berhasil, silakan tunggu verifikasi', 'success')
                                    .then(function () {
                                        window.location.reload(); // Reload halaman setelah pesan sukses
                                    });
                            },
                            error: function (xhr) {
                                let errorMessage = 'Terjadi kesalahan saat memproses pesanan';
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message; // Ambil pesan error dari server jika ada
                                }
                                Swal.fire('Gagal', errorMessage, 'error');
                            }
                        });
                    }
                });
            });
        
            // Handler klik untuk tautan Search Now
            $('#searchBtn').on('click', function (e) {
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
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
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
