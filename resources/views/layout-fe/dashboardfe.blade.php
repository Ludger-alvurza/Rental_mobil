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
    <style>
        .container {
            margin-top: 20px;
        }

        .select_box_section {
            padding: 20px;
            /* Memberikan jarak di dalam */
            border-radius: 10px;
            /* Membuat sudut menjadi melengkung */
            box-shadow: none;
            /* Menghilangkan bayangan */
        }

        .select_box_main {
            display: flex;
            /* Menggunakan flexbox untuk tata letak */
            flex-wrap: wrap;
            /* Membungkus elemen agar rapi */
            justify-content: space-between;
            /* Mengatur jarak antar elemen secara rata */
        }

        .select-outline {
            flex: 1;
            /* Mengatur elemen agar memiliki ukuran yang sama */
            min-width: 200px;
            /* Ukuran minimum agar tidak terlalu kecil */
            margin-right: 15px;
            /* Jarak antar kolom */
        }

        .select-outline:last-child {
            margin-right: 0;
            /* Menghapus margin pada kolom terakhir */
        }

        .form-control,
        .mdb-select {
            width: 100%;
            /* Membuat input mengisi penuh area kontainer */
            border: 1px solid #007BFF;
            /* Warna border */
            border-radius: 5px;
            /* Sudut border melengkung */
            padding: 10px;
            /* Jarak di dalam input */
            font-size: 16px;
            /* Ukuran font */
            transition: border-color 0.3s;
            /* Efek transisi saat fokus */
        }

        .form-control:focus,
        .mdb-select:focus {
            border-color: #0056b3;
            /* Warna border saat fokus */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Efek bayangan saat fokus */
        }

        .btn-danger {
            background-color: #dc3545;
            /* Warna tombol merah */
            border: none;
            /* Menghilangkan border default */
            border-radius: 5px;
            /* Sudut tombol melengkung */
            padding: 10px 20px;
            /* Jarak di dalam tombol */
            font-size: 16px;
            /* Ukuran font */
            transition: background-color 0.3s;
            /* Efek transisi saat hover */
        }

        .btn-danger:hover {
            background-color: #c82333;
            /* Warna tombol saat hover */
        }
    </style>
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
                <div class="call_text"><a class="nav-link" href="/user/profil">
                        <i class="far fa-user"></i> {{ auth()->user()->email }}
                    </a></div>
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
                                        rental motor kami menawarkan berbagai pilihan kendaraan berkualitas yang siap
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
                    <div class="banner_img"><img src="/assets-fe/images/gambarMotor1.jpg" alt="Motor"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="about_section layout_padding" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="about_section_2">
                <div class="row">
                    <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                        <div class="image_iman"><img src="/assets-fe/images/banner-img.png" class="about_img"
                                alt="Motor"></div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000" id="info">
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
                    <form id="searchForm" action="{{ route('mobil.search') }}" method="GET">
                        <div class="container">
                            <div class="select_box_section">
                                <div class="select_box_main">
                                    <div class="row">
                                        <div class="col-md-3 select-outline">
                                            <input type="text" name="name" class="form-control"
                                                placeholder="Masukkan Nama Mobil"
                                                style="border: 1px solid #007BFF; border-radius: 5px; padding: 10px; font-size: 16px;"
                                                onkeydown="return event.key !== 'Enter';">
                                        </div>
                                        <div class="col-md-3 select-outline">
                                            <select name="type"
                                                class="mdb-select md-form md-outline colorful-select dropdown-primary">
                                                <option value="" disabled selected>Type</option>
                                                <option value="keluarga">Keluarga</option>
                                                <option value="sport">Sport</option>
                                                <option value="box">Box</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 select-outline">
                                            <select name="brand"
                                                class="mdb-select md-form md-outline colorful-select dropdown-primary">
                                                <option value="" disabled selected>Pilih Brand</option>
                                                <option value="toyota">Toyota</option>
                                                <option value="honda">Honda</option>
                                                <option value="ford">Ford</option>
                                                <option value="chevrolet">Chevrolet</option>
                                                <option value="nissan">Nissan</option>
                                                <option value="volkswagen">Volkswagen</option>
                                                <option value="hyundai">Hyundai</option>
                                                <option value="kia">Kia</option>
                                                <option value="subaru">Subaru</option>
                                                <option value="mazda">Mazda</option>
                                                <option value="bmw">BMW</option>
                                                <option value="mercedes">Mercedes-Benz</option>
                                                <option value="audi">Audi</option>
                                                <option value="lexus">Lexus</option>
                                                <option value="porsche">Porsche</option>
                                                <option value="jaguar">Jaguar</option>
                                                <option value="land_rover">Land Rover</option>
                                                <option value="tesla">Tesla</option>
                                                <option value="volvo">Volvo</option>
                                                <option value="mitsubishi">Mitsubishi</option>
                                                <option value="Lamborghini">Lamborghini</option>
                                                <option value="Ferrari">Ferrari</option>
                                                <option value="MClaren">MClaren</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 select-outline">
                                            <select name="harga"
                                                class="mdb-select md-form md-outline colorful-select dropdown-primary">
                                                <option value="" disabled selected>Harga</option>
                                                <option value="1000000">Di bawah 1.000.000</option>
                                                <option value="5000000">Di bawah 5.000.000</option>
                                                <option value="30000000">Di bawah 30.000.000</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-danger" id="searchBtn">Search
                                                Now</button>
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
    @include('layout-fe.motor-content')
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
                        <p class="ipsum_text">Kami Menyediakan Mobil yang aman dan nyaman untuk digunakan.
                        </p>
                    </div>
                    <div class="col-sm-4">
                        <div class="icon_1"><img src="/assets-fe/images/icon-2.png"></div>
                        <h4 class="safety_text">Online Booking</h4>
                        <p class="ipsum_text">Anda Bisa Memesan Mobil dengan Mudah dan Cepat.
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
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init();
        });
    </script>
    <script>
        // Menginisialisasi AOS dan mengubah delay berdasarkan ukuran layar
        window.addEventListener('load', function() {
            // Memperbarui delay berdasarkan ukuran layar saat halaman dimuat
            adjustAOSDelay();
        });

        window.addEventListener('resize', function() {
            // Memperbarui delay saat ukuran layar berubah (misalnya jika pengguna mengubah ukuran jendela)
            adjustAOSDelay();
        });

        function adjustAOSDelay() {
            const width = window.innerWidth;

            // Dapatkan semua elemen dengan atribut data-aos-delay
            const elements = document.querySelectorAll('[data-aos-delay]');

            elements.forEach((element, index) => {
                // Sesuaikan delay berdasarkan lebar layar
                if (width <= 768) { // Untuk perangkat mobile
                    element.setAttribute('data-aos-delay', '0'); // Menghapus delay di mobile
                } else {
                    element.setAttribute('data-aos-delay', index * 200); // Mengatur delay normal di desktop
                }
            });

            // Memaksa AOS untuk melakukan refresh
            AOS.refresh();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengatur delay untuk elemen
            adjustAOSDelay();

            // Inisialisasi AOS setelah delay disesuaikan
            AOS.init();
        });
    </script> --}}
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
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const isMobile = window.innerWidth <= 768;
            document.querySelectorAll('[data-aos-delay]').forEach((element, index) => {
                const delay = isMobile ? 0 : index * 200;
                element.setAttribute('data-aos-delay', delay);
            });

            // Memaksa AOS untuk melakukan refresh
            AOS.refresh();
        });
    </script> --}}
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script> --}}
</body>

</html>
