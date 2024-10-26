<!DOCTYPE html>
<html>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- font css -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Raleway:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="/assets-fe/css/jquery.mCustomScrollbar.min.css">
    <!-- Tweaks for older IEs-->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
</head>

<body>
    <!-- header section start -->
    <div class="header_section">
        <div class="container">
            @include('layout-fe.navbar')
        </div>
    </div>
    <!-- header section end -->
    <div class="call_text_main">
        <div class="container">
            <div class="call_taital">
                <div class="call_text"><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span
                            class="padding_left_15">Location</span></a></div>
                <div class="call_text"><a href="#"><i class="fa fa-phone" aria-hidden="true"></i><span
                            class="padding_left_15">(+71) 8522369417</span></a></div>
                @auth
                    <div class="call_text"><a class="nav-link" href="/user/profil">
                            <i class="far fa-user"></i> {{ auth()->user()->email }}
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <!-- banner section start -->
    <div class="banner_section layout_padding" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                    <div id="banner_slider" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="banner_taital_main">
                                    <h1 class="banner_taital">Mobil Rental <br><span style="color: #fe5b29;">Untuk
                                            Kamu</span></h1>
                                    <p class="banner_text">Temukan kebebasan berkendara dengan RentalCar! Aplikasi
                                        rental Mobil kami menawarkan berbagai pilihan kendaraan berkualitas yang siap
                                        menemani setiap petualanganmu</p>
                                    <div class="btn_main">
                                        <div class="contact_bt"><a href="#info">Selengkapnya</a></div>
                                        <div class="contact_bt active"><a href="#footer">Hubungi Kami</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner_taital_main">
                                    <h1 class="banner_taital">Mobil Rental <br><span style="color: #fe5b29;">For
                                            You</span></h1>
                                    <p class="banner_text">Proses pemesanan yang mudah dan cepat membuat perjalananmu
                                        semakin menyenangkan, tanpa repot. Apakah kamu mencari motor untuk berkeliling
                                        kota atau perjalanan jauh? RentalCar punya solusinya!</p>
                                    <div class="btn_main">
                                        <div class="contact_bt"><a href="#info">Read More</a></div>
                                        <div class="contact_bt active"><a href="#footer">Contact Us</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="banner_taital_main">
                                    <h1 class="banner_taital">Mobil Rental <br><span style="color: #fe5b29;">For
                                            You</span></h1>
                                    <p class="banner_text">Dengan harga yang bersaing, kamu bisa menikmati pengalaman
                                        sewa motor yang aman dan nyaman.</p>
                                    <div class="btn_main">
                                        <div class="contact_bt"><a href="#info">Read More</a></div>
                                        <div class="contact_bt active"><a href="#footer">Contact Us</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#banner_slider" role="button" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#banner_slider" role="button" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="banner_img"><img src="/assets-fe/images/banner-img.png" alt="Motor"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="about_section layout_padding" data-aos="fade-up" data-aos-duration="1000" id="info">
        <div class="container">
            <div class="about_section_2">
                <div class="row">
                    <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                        <div class="image_iman"><img src="/assets-fe/images/banner-img.png" class="about_img"
                                alt="Motor"></div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                        <div class="about_taital_box">
                            <h1 class="about_taital">Tentang <span style="color: #fe5b29;">Kami</span></h1>
                            <p class="about_text">Selamat datang di RentalCar, aplikasi rental motor yang siap memenuhi
                                kebutuhan perjalananmu! Dengan berbagai pilihan mobil yang berkualitas dan proses
                                pemesanan yang cepat dan mudah, RentalCar memastikan pengalaman sewa mobil yang nyaman
                                dan aman. Nikmati kebebasan menjelajahi kota dengan gaya, tanpa khawatir soal harga yang
                                bersaing. Mulai petualanganmu bersama RentalCar sekarang!</p>
                            <div class="readmore_btn"><a href="#">Read More</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- about section end -->
    <div class="search_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="search_taital">Search Your Best Car</h1>
                    <p class="search_text">Using 'Content here, content here', making it look like readable</p>
                    <!-- select box section start -->
                    <form action="{{ route('mobil.search') }}" method="GET">
                        <div class="container">
                            <div class="select_box_section">
                                <div class="select_box_main">
                                    <div class="row">
                                        <div class="col-md-3 select-outline">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Masukkan Nama Mobil"
                                                style="border: 1px solid #007BFF; border-radius: 5px; padding: 10px; font-size: 16px;">

                                        </div>
                                        <div class="col-md-3 select-outline">
                                            <select name="type"
                                                class="mdb-select md-form md-outline colorful-select dropdown-primary">
                                                <option value="" disabled selected>Type</option>
                                                <option value="keluarga">keluarga</option>
                                                <option value="sport">sport</option>
                                                <option value="box">box</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 select-outline">
                                            <select name="harga"
                                                class="mdb-select md-form md-outline colorful-select dropdown-primary">
                                                <option value="" disabled selected>Harga</option>
                                                <option value="10000">Di bawah 10.000</option>
                                                <option value="20000">Di bawah 20.000</option>
                                                <option value="30000">Di bawah 30.000</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-danger">Search Now</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- select box section end -->
                </div>
            </div>
        </div>
    </div>
    <!-- gallery section start -->
    <div class="gallery_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="gallery_taital">Our best offers</h1>
                </div>
            </div>
            <div class="gallery_section_2">
                <div class="row">
                    @foreach ($kendaraan as $index => $row)
                        <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000"
                            data-aos-delay="{{ $index * 200 }}">
                            <div class="gallery_box">
                                <div class="gallery_img">
                                    <img src="{{ route('storage', $row->gambar) }}" alt="{{ $row->name }}">
                                </div>
                                <h3 class="types_text">{{ $row->name }} <br>{{ $row->availability }}</h3>
                                <p class="looking_text">Start per day {{ $row->price_per_day }}</p>
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
                                        <h5 class="modal-title" id="bookingModalLabel{{ $row->id }}">Untuk
                                            Melanjutkan Pesanan <br> Anda Harus Login Dulu</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/login/verify" method="post" class="login-form">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Email">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-envelope"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary btn-block login-btn">Login</button>
                                            <a href="/register"
                                                class="btn btn-info btn-block register-btn">Register</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <style>
                .modal-body {
                    background: #f9f9f9;
                    padding: 2rem;
                    border-radius: 10px;
                    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
                }

                .input-group .form-control {
                    border-radius: 30px;
                    padding: 1rem;
                    border: 2px solid #ddd;
                    transition: border-color 0.3s ease;
                }

                .input-group .form-control:focus {
                    border-color: #007bff;
                    box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.2);
                }

                .input-group-text {
                    background-color: #007bff;
                    border-radius: 50%;
                    color: white;
                    padding: 0.5rem;
                }

                .login-btn,
                .register-btn {
                    border-radius: 30px;
                    font-size: 1.2rem;
                    padding: 0.8rem;
                    transition: background-color 0.3s ease, transform 0.2s ease;
                }

                .login-btn:hover,
                .register-btn:hover {
                    background-color: #0056b3;
                    transform: translateY(-2px);
                }

                .login-form {
                    max-width: 400px;
                    margin: 0 auto;
                }

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

    <!-- gallery section end -->
    <!-- choose section start -->
    <div class="choose_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="choose_taital">WHY CHOOSE US</h1>
                </div>
            </div>
            <div class="choose_section_2">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="icon_1"><img src="/assets-fe/images/icon-1.png"></div>
                        <h4 class="safety_text">SAFETY & SECURITY</h4>
                        <p class="ipsum_text">Kami Menyediakan Mobil yang  aman dan nyaman untuk digunakan.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="icon_1"><img src="/assets-fe/images/icon-2.png"></div>
                        <h4 class="safety_text">Online Booking</h4>
                        <p class="ipsum_text">Anda Bisa Memesan  Mobil dengan Mudah dan Cepat.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="icon_1"><img src="/assets-fe/images/icon-3.png"></div>
                        <h4 class="safety_text">Best Drivers</h4>
                        <p class="ipsum_text">Kami Juga Menyiapkan Banyak Driver Handal Dan Juga Ramah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- choose section end -->
    <!-- client section start -->
    @include('layout-fe.client-review')
    <!-- contact section end -->
    <!-- footer section start -->
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
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        $(function() {

            @if (session()->has('gagal'))
                toastr.error('{{ Session::get('gagal') }}', 'Error')
            @endif
            @if (session()->has('berhasil'))
                toastr.success('{{ Session::get('berhasil') }}', 'Berhasil')
            @endif
        });
    </script>
    @stack('js')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>
