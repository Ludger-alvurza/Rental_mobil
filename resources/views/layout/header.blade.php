<style>
    .navbar-main {
        max-width: 100%;
        overflow: hidden;
    }

    .container {
        max-width: 1200px;
        /* Sesuaikan dengan layout yang kamu inginkan */
        margin: 0 auto;
        /* Agar konten berada di tengah */
    }

    .navbar-nav {
        display: flex;
        flex-wrap: wrap;
        /* Agar elemen yang melebihi baris akan pindah ke bawah */
        justify-content: space-between;
        /* Agar konten terdistribusi dengan baik */
    }

    .navbar-nav .nav-item {
        flex: 1 0 auto;
        /* Atur agar item mengambil ruang sesuai kebutuhan */
    }

    @media (max-width: 768px) {
        .navbar-nav {
            flex-direction: column;
            /* Ubah navbar menjadi vertikal di layar kecil */
        }
    }

    .navbar-nav .nav-item {
        display: flex;
        align-items: center;
        /* Biar icon sama teks sejajar secara vertikal */
        padding: 5px 10px;
        /* Biar ada spasi yang cukup di sekitar item */
    }

    .navbar-nav .nav-item i {
        margin-right: 8px;
        /* Spasi antara ikon sama teks */
        font-size: 16px;
        /* Sesuaikan ukuran ikon biar lebih pas */
    }

    .navbar-nav .nav-link {
        padding: 5px 15px;
        /* Tambahkan padding biar ada spasi di sekitar link */
    }

    @media (max-width: 768px) {
        .navbar-nav {
            flex-direction: column;
            /* Jadikan vertikal di mobile */
            text-align: left;
            /* Align text ke kiri */
        }

        .navbar-nav .nav-item {
            justify-content: flex-start;
            /* Biar ikon tetap di kiri */
        }
    }
</style>
<nav class="navbar navbar-expand-lg blur blur-rounded z-index-3 shadow position-sticky my-3 py-2 start-0 end-0 mx-4"
    id="navbarBlur" navbar-scroll="true" style="top: 0;">
    <div class="container-fluid pe-0">
        <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3">
            @yield('judul', 'content')
        </a>
        <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
            data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav mx-auto ms-xl-auto me-xl-7">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center me-2 active" aria-current="page"
                        href="{{ url('/sewa-mobil') }}">
                        <i class="fa fa-chart-pie opacity-6 text-dark me-1"></i>
                        Go to Web
                    </a>
                    <a href="javascript:;" class="nav-link text-body p-0 d-flex align-items-center"
                        id="iconNavbarSidenav">
                        <bold>Lihat Semua Halaman</bold>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/user/profil">
                        <i class="far fa-user"></i> {{ auth()->user()->email }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="{{ url('user/profil') }}">
                        <i class="fas fa-key opacity-6 text-dark me-1"></i>
                        Ubah Password
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="{{ url('/logout') }}">
                        <i class="fas fa-sign-out-alt opacity-6 text-dark me-1"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
