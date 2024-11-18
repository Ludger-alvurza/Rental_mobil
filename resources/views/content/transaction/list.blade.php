@extends('layout.main')
@section('judul','Data Peminjaman Mobil')

@section('content')
<div class="col-12 mt-3">
    <button type="button" class="btn btn-danger" id="delete-all">Hapus Semua Data</button>
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            width: 300px;
            text-align: center;
        }
    </style>
</div>
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
                            <th>denda</th>
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
                            <td class="text-right">Rp {{ number_format($row->total, 0, ',', '.') }}</td>
                            <td class="right">
                                Rp {{ $row->denda !== null ? number_format($row->denda, 0, ',', '.') : '-' }}
                            </td>
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
    function showConfirmationModal() {
        $('#confirmationModal').show();
    }

    function closeConfirmationModal() {
        $('#confirmationModal').hide();
    }

    $(document).ready(function () {
        $('#delete-all').click(function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data Rincian Biaya yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('table.clear') }}',
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                                    location.reload(true); // Force reload from server
                                }
                            });
                        },
                        error: function () {
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
    });
</script>
@if(Session::has('success'))
<script>
    toastr.success("{{ Session::get('success') }}");
</script>
@endif
@endpush
