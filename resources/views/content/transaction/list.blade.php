@extends('layout.main')
@section('judul','Data Peminjaman Mobil')

@section('content')
<div class="col-12 mt-3">
    <form action="{{ route('table.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data transaksi?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Semua Data Transaksi</button>
    </form>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>tanggal</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($rows as $row)
                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$row->code}}</td>
                            <td>{{$row->date}}</td>
                            <td class="text-right">Rp {{$row->total}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{$row->id}}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{url("transaksi/$row->id/pdf")}}" target="_blank" class="btn btn-sm btn-danger">
                                    <i class="fas fa-file-pdf"></i> 
                                </a>
                                <div class="modal fade" id="editModal{{$row->id}}" tabindex="-1" aria-labelledby="editModalLabel{{$row->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{$row->id}}">Edit Data Pengguna</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form untuk mengedit data pengguna -->
                                                <form action="">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$row->id}}"/>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="form-group">
                                                                        <label for="">Kode Transaksi</label>
                                                                        <input type="text"
                                                                               class="form-control @error('no_plat') is-invalid @enderror"
                                                                               value="{{$row->code}}"
                                                                               name="no_plat" readonly>
                                                                        @error('no_plat')
                                                                        <div class="invalid-feedback">
                                                                            {{$message}}
                                                                        </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Tanggal Transaksi</label>
                                                                        <input type="text"
                                                                               class="form-control @error('name') is-invalid @enderror"
                                                                               value="{{$row->date}}"
                                                                               name="name" readonly>
                                                                        @error('name')
                                                                        <div class="invalid-feedback">
                                                                            {{$message}}
                                                                        </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Total Transaksi</label>
                                                                        <input type="text"
                                                                               class="form-control @error('type') is-invalid @enderror"
                                                                               value="{{$row->total}}"
                                                                               name="type" readonly>
                                                                        @error('type')
                                                                        <div class="invalid-feedback">
                                                                            {{$message}}
                                                                        </div>
                                                                        @enderror
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ok</button>
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
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
    $('#delete-all').click(function (e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data Transaksi yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('table.trans') }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        Swal.fire(
                            'Terhapus!',
                            response.success,
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function (response) {
                        Swal.fire(
                            'Gagal!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@if(Session::has('success'))
<script>
    toastr.success("{{ Session::get('success') }}");
</script>
@endif
@endpush
