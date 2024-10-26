@extends('layout.main')
@section('judul','Data Users')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('admin')
                    <a class="btn btn-primary mb-2" href="{{url('/user/add')}}">Tambah Data Users</a>
                    <a target="_blank" href="{{route('export.excel')}}" class="btn btn-success mt-2">
                        <i class="fas fa-file-excel"></i>Export XLS
                    </a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telepon</th>
                                <th>Umur</th>
                                <th>Jenis Kelamin</th>
                                <th>Sebagai</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = (($users->currentPage() -1)* $users->perPage())+1;
                            @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->alamat}}</td>
                                    <td>{{$user->no_telepon}}</td>
                                    <td>{{$user->age}} Tahun</td>
                                    <td>{{$user->jk}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        @can('admin')
                                        <button type="button" data-id-user="{{$user->id}}" data-name="{{$user->name}}" class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <!-- Modal Trigger Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$user->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{$user->id}}">Edit Data Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form untuk mengedit data pengguna -->
                                                        <form method="post" action="{{url('user/update')}}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$user->id}}"/>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <div class="form-group">
                                                                                <label for="">Name</label>
                                                                                <input type="text"
                                                                                       class="form-control @error('name') is-invalid @enderror"
                                                                                       value="{{$user->name}}"
                                                                                       name="name">
                                                                                @error('name')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Email</label>
                                                                                <input type="email"
                                                                                       class="form-control @error('email') is-invalid @enderror"
                                                                                       value="{{$user->email}}"
                                                                                       name="email">
                                                                                @error('email')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">No Telepon</label>
                                                                                <input type="tel"
                                                                                       class="form-control @error('no_telepon') is-invalid @enderror"
                                                                                       value="{{$user->no_telepon}}"
                                                                                       name="no_telepon">
                                                                                @error('no_telepon')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Alamat</label>
                                                                                <input type="text"
                                                                                       class="form-control @error('alamat') is-invalid @enderror"
                                                                                       value="{{ $user->alamat }}"
                                                                                       name="alamat">
                                                                                @error('alamat')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Tanggal Lahir</label>
                                                                                <input type="date"
                                                                                       class="form-control @error('dob') is-invalid @enderror"
                                                                                       value="{{$user->dob}}"
                                                                                       name="dob">
                                                                                @error('dob')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="jk">Jenis Kelamin</label>
                                                                                <select id="jk" name="jk" class="form-control @error('jk') is-invalid @enderror">
                                                                                    <option value="laki-laki" {{ $user->jk === 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                                    <option value="perempuan" {{ $user->jk === 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                                </select>
                                                                                @error('jk')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <input type="hidden"
                                                                                       class="form-control @error('password') is-invalid @enderror"
                                                                                       value="{{$user->password}}"
                                                                                       name="password">
                                                                                @error('password')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="">Role</label>
                                                                                <select class="form-control @error('role') is-invalid @enderror" name="role">
                                                                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                                                </select>
                                                                                @error('role')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                    
                                                                            <button class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <div>
                                {{$users->firstItem()}}
                                to
                                {{$users->lastItem()}}
                                of
                                {{$users->total()}}
                                entries
                            </div>
                            <div class="ml-auto">
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            $('.btn-hapus').on('click', function () {
                let idUser = $(this).data('id-user');
                let name = $(this).data('name');
                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin hapus data ${name}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/user/delete',
                            type: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                id: idUser
                            },
                            success: function () {
                                Swal.fire('Sukses', 'Data berhasil dihapus', 'success')
                                    .then(function () {
                                        window.location.reload();
                                    })
                            },
                            error: function () {
                                Swal.fire('Gagal', 'Terjadi kesalahan ketika menghapus data Mungkin Anda Bukan Admin', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
