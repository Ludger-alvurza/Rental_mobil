@extends('layout.main')
@section('judul','Data Users')

@section('content')
<div class="container">
    <h2>Profil Pengguna</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Telepon</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Sebagai</th>
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
            </tr>
        </tbody>
    </table>
    <a href="" data-bs-toggle="modal" data-bs-target="#editModal">Edit Profil</a>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form untuk mengedit data pengguna -->
                <form action="">
                    @csrf
                    <input type="hidden" name="id" value="{{$user->id}}"/>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Formulir pengeditan data pengguna -->
                                    Anda Hanya Dapat Mengubah Data Profil Anda Atas Izin Admin,
                                    Hubungi <a href="https://api.whatsapp.com/send?phone=085849165477" target="_blank">WhatsApp Admin</a> Untuk Melakukan Perubahan Data
                                    <!-- Tambahkan input lainnya sesuai kebutuhan -->
                            </div>
                        </div>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')

@endpush
