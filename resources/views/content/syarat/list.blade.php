@extends('layout.main')
@section('judul','Data Syarat')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a class="btn btn-primary mb-2" href="{{url('/syarat/add')}}">Tambah Data Syarat</a>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Keterangan</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = (($syarats->currentPage() -1)* $syarats->perPage())+1;
                            @endphp
                            @foreach($syarats as $syarat)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$syarat->keterangan}}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$syarat->id}}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button"
                                                data-id-syarat="{{$syarat->id}}"
                                                data-name="{{$syarat->keterangan}}"
                                                class="btn btn-danger btn-sm btn-hapus">
                                            <i class="fas fa-trash  "></i>
                                        </button>
                                        <div class="modal fade" id="editModal{{$syarat->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$syarat->id}}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{$syarat->id}}">Edit Data Pengguna</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Form untuk mengedit data pengguna -->
                                                        <form method="post" action="{{url('syarat/update')}}">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$syarat->id}}"/>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                        <div class="form-group">
                                                                                <label for="">Keterangan</label>
                                                                                <textarea type="text"
                                                                                       class="form-control @error('keterangan') is-invalid @enderror"
                                                                                       value="{{$syarat->keterangan}}"
                                                                                       name="keterangan"></textarea>
                                                                                @error('keterangan')
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>
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
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$syarats->links()}}
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
                let idSyarat = $(this).data('id-syarat');
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
                            url: '/syarat/delete',
                            type: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                id: idSyarat
                            },
                            success: function () {
                                Swal.fire('Sukses', 'Data berhasil dihapus', 'success')
                                    .then(function () {
                                        window.location.reload();
                                    })
                            },
                            error: function () {
                                Swal.fire('Gagal', 'Terjadi kesalahan ketika hapus data', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
