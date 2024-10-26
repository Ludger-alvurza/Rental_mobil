<!DOCTYPE html>
<html lang="en">

<head>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container-fluid {
            padding: 0;
            margin: 0;
        }

        /* Style untuk link edit profil */
        .edit-profile-link {
            display: inline-block;
            padding: 5px 10px;
            font-size: 16px;
            font-weight: 500;
            color: #fff;
            background-color: #007bff;
            /* Warna biru Bootstrap, bisa diubah sesuai preferensi */
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .edit-profile-link:hover,
        .edit-profile-link:focus {
            background-color: #cf7f3d;
            /* Warna biru gelap saat hover */
            text-decoration: none;
            transform: scale(1.05);
            /* Sedikit membesar saat hover */
        }

        .edit-profile-link:active {
            background-color: #004080;
            /* Warna biru lebih gelap saat diklik */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="header_section">
            <div class="container">
                @include('layout-fe.navbar')
            </div>
        </div>
        <div class="table-responsive" style="padding: 20px;">
            <h2>Profi edite</h2> <!-- Tambahin ini buat table responsive -->
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>Sebagai</th>
                        <th>Edite Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ auth()->user()->name }}</td>
                        <td>{{ auth()->user()->alamat }}</td>
                        <td>{{ auth()->user()->no_telepon }}</td>
                        <td>{{ auth()->user()->age }} Tahun</td>
                        <td>{{ auth()->user()->jk }}</td>
                        <td>{{ auth()->user()->role }}</td>
                        <td>
                            <a class="nav-link me-2" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fas fa-key opacity-6 text-dark me-1"></i>
                                Ubah Password
                            </a>
                            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="{{ url('user/change-password') }}">
                                                @csrf
                                                <div class="form-group mb-3">
                                                    <label for="old_password">Password Lama</label>
                                                    <input required type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror">
                                                    @error('old_password')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="password">Password Baru</label>
                                                    <input required type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                                                    <input required type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                                    @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <button type="button" id="btn-submit" class="btn btn-primary">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="" class="edit-profile-link" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profil</a>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered"> <!-- Tambahin class modal-dialog-centered -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}" />
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            Anda Hanya Dapat Mengubah Data Profil Anda Atas Izin Admin,
                                            Hubungi <a href="https://api.whatsapp.com/send?phone=085849165477"
                                                target="_blank">WhatsApp Admin</a> Untuk Melakukan Perubahan Data
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    @push('js')
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
        <script>
            $(function () {
                $('#btn-submit').on('click', function (e) {
                    e.preventDefault();
            
                    Swal.fire({
                        title: "Konfirmasi",
                        text: "Apakah Anda yakin ingin mengubah password?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Ubah!",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ url("user/change-password") }}',
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    old_password: $('input[name="old_password"]').val(),
                                    password: $('input[name="password"]').val(),
                                    password_confirmation: $('input[name="password_confirmation"]').val()
                                },
                                success: function (response) {
                                    if (response.status === 'success') {
                                        Swal.fire('Sukses', response.message, 'success')
                                            .then(function () {
                                                window.location.reload(); // Reload halaman
                                            });
                                    }
                                },
                                error: function (xhr) {
                                    let errorMessage = 'Terjadi kesalahan saat mengubah password';
            
                                    if (xhr.status === 422) {
                                        const errors = xhr.responseJSON;
                                        if (errors.message) {
                                            errorMessage = errors.message; // Pesan error dari backend
                                        }
                                    }
            
                                    Swal.fire('Gagal', errorMessage, 'error');
                                }
                            });
                        }
                    });
                });
            });
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @stack('js')
</body>

</html>
