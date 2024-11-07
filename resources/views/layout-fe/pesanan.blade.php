<!DOCTYPE html>
<html lang="en">

<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Ludger Rental</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- bootstrap css -->
    <link rel="stylesheet" type="text/css" href="/assets-fe/css/bootstrap.min.css">
    <!-- style css -->
    <link rel="stylesheet" type="text/css" href="/assets-fe/css/style.css">
    <!-- Responsive-->
    <link rel="stylesheet" href="/assets-fe/css/responsive.css">
    <!-- fevicon -->
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <!-- font css -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="/assets-fe/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Modal Custom Style */
        .modal .modal-header {
            background-color: #f8f9fa;
            /* Warna header */
            padding: 20px;
        }

        .modal .modal-title {
            font-size: 1.25rem;
            color: #343a40;
        }

        .modal .btn-close {
            color: #000;
        }

        .modal .modal-body {
            padding: 20px;
        }

        .modal .form-label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .modal .form-select {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .modal .modal-footer {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-top: 1px solid #dee2e6;
        }

        .modal .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 1rem;
        }

        .modal .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 10px 20px;
            font-size: 1rem;
        }

        .modal .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="header_section">
        <div class="container">
            @include('layout-fe.navbar')
        </div>
    </div>

    <div class="table-responsive" style="overflow-x:auto;">
        <table class="table">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Nama Mobil</th>
                                            <th>Nomor Plat</th>
                                            <th>Lama sewa</th>
                                            <th>Keterangan</th>
                                            <th>Status Pemesanan</th>
                                            @can('admin')
                                            <th>Tandai Selesai</th>
                                            @endcan
                                            <th>Pembatalan</th>
                                            <th class="text-center">status pembayaran</th>
                                            <th>Checkout</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = ($bkuser->currentPage() - 1) * $bkuser->perPage() + 1;
                                        @endphp
                                        @foreach ($bkuser as $row)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->name_mobil }}</td>
                                                <td>{{ $row->no_plat }}</td>
                                                <td>{{ $row->lama_sewa }}</td>
                                                <td>{{ $row->keterangan }}</td>
                                                <td>
                                                    <span
                                                        class="badge
                                                    {{ $row->pembatalan == 'Terverifikasi' ? 'bg-success' : ($row->pembatalan == 'Dipesan' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ $row->pembatalan }}
                                                    </span>
                                                </td>
                                                @can('admin')
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-success btn-konfirmasi" 
                                                            data-id="{{ $row->id }}" 
                                                            data-name="Pesanan {{ $row->id }}">
                                                        Konfirmasi Pengembalian
                                                    </button>
                                                </td>                                                
                                                @endcan
                                                <td>
                                                    @can('admin')
                                                        <button type="button" data-id-pesanan="{{ $row->id }}"
                                                            data-name="{{ $row->name }}"
                                                            class="btn btn-danger btn-sm btn-hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <!-- Modal Trigger Button -->
                                                        <button type="button" class="btn btn-warning btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $row->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                    @endcan
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#pembatalanPesan{{ $row->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="pembatalanPesan{{ $row->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="pembatalanPesanLabel{{ $row->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="pembatalanPesanLabel{{ $row->id }}">
                                                                        Pembatalan Pesanan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <form method="post"
                                                                    action="{{ url('pesanan/batal') }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $row->id }}" />
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label
                                                                                id="label-pembatalan{{ $row->id }}"
                                                                                for="pembatalan{{ $row->id }}"
                                                                                class="form-label">Silahkan Pilih Untuk
                                                                                Melanjutkan</label>
                                                                            <select class="form-select"
                                                                                id="pembatalan{{ $row->id }}"
                                                                                name="pembatalan">
                                                                                <option value="Dipesan" selected>
                                                                                    Lanjutkan pesanan</option>
                                                                                <option value="Dibatalkan">Batalkan
                                                                                    pesanan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editModal{{ $row->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editModalLabel{{ $row->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editModalLabel{{ $row->id }}">Edit
                                                                        Data Pesanan</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit data pengguna -->
                                                                    <form method="post"
                                                                        action="{{ url('pesanan/update') }}"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                            value="{{ $row->id }}" />
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="card">
                                                                                    <div class="card-body">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="">no_plat</label>
                                                                                            <input type="text"
                                                                                                class="form-control @error('no_plat') is-invalid @enderror"
                                                                                                value="{{ $row->no_plat }}"
                                                                                                name="no_plat">
                                                                                            @error('no_plat')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="">Name</label>
                                                                                            <input type="text"
                                                                                                class="form-control @error('name') is-invalid @enderror"
                                                                                                value="{{ $row->name }}"
                                                                                                name="name">
                                                                                            @error('name')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="">Nama
                                                                                                Mobil</label>
                                                                                            <input type="text"
                                                                                                class="form-control @error('name_mobil') is-invalid @enderror"
                                                                                                value="{{ $row->name_mobil }}"
                                                                                                name="name_mobil">
                                                                                            @error('name_mobil')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="">Lama
                                                                                                Sewa</label>
                                                                                            <input type="text"
                                                                                                class="form-control @error('lama_sewa') is-invalid @enderror"
                                                                                                value="{{ $row->lama_sewa }}"
                                                                                                name="lama_sewa">
                                                                                            @error('lama_sewa')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="">Keterangan</label>
                                                                                            <input type="text"
                                                                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                                                                value="{{ $row->keterangan }}"
                                                                                                name="keterangan">
                                                                                            @error('keterangan')
                                                                                                <div
                                                                                                    class="invalid-feedback">
                                                                                                    {{ $message }}
                                                                                                </div>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <button
                                                                                            class="btn btn-primary">Simpan</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge
                                                    {{ $row->payment_status == 'Paid' ? 'bg-success' : ($row->payment_status == 'Pending' ? 'bg-warning' : 'bg-danger') }}">
                                                        {{ $row->payment_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($row->pembatalan !== 'Terverifikasi')
                                                        Pesanan Belum Diproses
                                                    @elseif($row->payment_status === 'Paid')
                                                        Pembayaran Sudah Selesai
                                                    @else
                                                        <a href="{{ route('checkout', $row->id) }}" class="btn btn-primary">
                                                            Checkout
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $bkuser->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </table>
    </div>



    @include('layout-fe.footer')
    <!-- footer section end -->
    <!-- copyright section start -->
    <div class="copyright_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="copyright_text">2023 All Rights Reserved. Design by <a href="https://html.design">Free
                            Html Templates</a></p>
                </div>
            </div>
        </div>
    </div>
    <!-- copyright section end -->
    <!-- Javascript files-->
    <script src="/assets-fe/js/jquery.min.js"></script>
    <script src="/assets-fe/js/popper.min.js"></script>
    <script src="/assets-fe/js/bootstrap.bundle.min.js"></script>
    <script src="/assets-fe/js/jquery-3.0.0.min.js"></script>
    <script src="/assets-fe/js/plugin.js"></script>
    <!-- sidebar -->
    <script src="/assets-fe/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="/assets-fe/js/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    @push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.querySelectorAll('.form-select').forEach(function(selectElement) {
                selectElement.addEventListener('change', function() {
                    var modalId = this.id.replace('pembatalan', '');
                    var label = document.getElementById('label-pembatalan' + modalId);
                    var selectedValue = this.value;

                    if (selectedValue === 'Dibatalkan') {
                        label.textContent = 'Apakah Anda Yakin Ingin Membatalkan Pesanan?';
                    } else if (selectedValue === 'Dipesan') {
                        label.textContent = 'Apakah Anda Yakin Ingin Tetap Melanjutkan Pesanan?';
                    }
                });
            });
        </script>
        <script>
            $(function() {
                $('.btn-hapus').on('click', function() {
                    let idPesanan = $(this).data('id-pesanan');
                    let name = $(this).data('name');
                    Swal.fire({
                        title: "Konfirmasi",
                        text: `Anda yakin hapus Pesanan ${name}?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/pesanan/delete',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    id: idPesanan
                                },
                                success: function() {
                                    Swal.fire('Sukses', 'Data berhasil dihapus', 'success')
                                        .then(function() {
                                            window.location.reload();
                                        })
                                },
                                error: function() {
                                    Swal.fire('Gagal',
                                        'Terjadi kesalahan ketika hapus data', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            $(function() {
                $('.btn-konfirmasi').on('click', function() {
                    let idPesanan = $(this).data('id');
                    let name = $(this).data('name');
                    Swal.fire({
                        title: "Konfirmasi",
                        text: `Anda yakin konfirmasi pengembalian untuk ${name}?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Konfirmasi!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('admin.konfirmasiPengembalian', '') }}/" + idPesanan, // URL untuk konfirmasi pengembalian
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}', // Tambahkan token CSRF
                                },
                                success: function(response) {
                                    Swal.fire('Sukses', 'Pengembalian berhasil dikonfirmasi', 'success')
                                        .then(function() {
                                            window.location.reload(); // Reload halaman setelah konfirmasi
                                        });
                                },
                                error: function() {
                                    Swal.fire('Gagal', 'Terjadi kesalahan ketika konfirmasi pengembalian', 'error');
                                }
                            });
                        }
                    });
                });
            });
        </script>
        {{-- @if (session::has('warning'))
            <script>
                toastr.warning("{{ Session::get('warning') }}");
            </script>
        @endif --}}
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
    <!--   Core JS Files   -->
    {{-- <script src="../assets/js/core/popper.min.js"></script> --}}
    {{-- <script src="../assets/js/core/bootstrap.min.js"></script> --}}
    {{-- <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script> --}}
    {{-- <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script> --}}
    {{-- <script src="../assets/js/plugins/chartjs.min.js"></script> --}}
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    {{-- <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
    <!-- AdminLTE App -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script src="/assets/plugins/toastr/toastr.min.js"></script>


    @stack('js')

</body>

</html>
