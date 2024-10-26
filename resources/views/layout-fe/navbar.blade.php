<style>
    .nav-item.active .nav-link {
        color: #d13030 !important;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/sewa-mobil"><img src="/assets-fe/images/logo.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item {{ Request::is('/sewa-mobil') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/sewa-mobil') }}">Dashboard</a>
                </li>
            @endauth
            @guest
                <li class="nav-item {{ Request::is('/rental-mobil') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/rental-mobil') }}">Dashboard</a>
                </li>
            @endguest
            <li class="nav-item {{ Request::is('pesanan/keranjang') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/pesanan/keranjang') }}">Pesanan Anda</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Persyaratan Peminjaman</a>
            </li>
            <!-- Add Modal Here -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Persyaratan Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Modal Content Goes Here -->
                            {{ $syarat && $syarat->keterangan ? $syarat->keterangan : 'Tidak ada syarat' }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Modal -->
            @auth
                <li class="nav-item" {{ Request::is('pesanan/keranjang') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/logout') }}">Log Out</a>
                </li>
                <li class="nav-item {{ Request::is('user/profil') ? 'active' : '' }}">
                    <a class="nav-link" href="/user/profil">
                        <i class="fa fa-user"></i> {{ auth()->user()->email }}
                    </a>
                </li>
            @endauth
            @can('superadmin')
                <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('/dashboard')}}">Analytics</a>
                </li>
            @endcan
        </ul>
        <form class="form-inline my-2 my-lg-0"></form>
    </div>
</nav>
