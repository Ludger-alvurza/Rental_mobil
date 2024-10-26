@extends('layout.main')
@section('judul','Data Rincian Biaya')

@section('content')
<div class="col-12 mt-3">
    <form action="{{ route('table.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua data?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Semua Data</button>
    </form>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Motor</th>
                            <th>No Plat</th>
                            <th>Perhari Rp</th>
                            <th>Denda Jika telat 1 Jam</th>
                            <th>Denda Jika telat 3 Jam</th>
                            <th>Denda Jika telat 5 Jam</th>
                            <th>Denda Jika telat 1 hari</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach($rows as $row)
                        <tr>
                            <td>{{$counter++}}</td>
                            <td>{{$row->mobil->name}}</td>
                            <td>{{$row->mobil->no_plat}}</td>
                            <td>RP {{$row->mobil->price_per_day}}</td>
                            <td>{{$row->denda}} + Harga Per Hari</td>
                            <td>{{$row->denda1}} + Harga Per Hari</td>
                            <td>{{$row->denda2}} + Harga Per Hari</td>
                            <td>{{$row->denda3}} + Harga Per Hari</td>
                            <td>
                                <button type="button" data-id-mobil="{{$row->id}}" data-name="{{$row->mobil->name}}" class="btn btn-danger btn-sm btn-hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
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
        $(function () {
            $('.btn-hapus').on('click', function () {
                let idMobilT = $(this).data('id-mobil');
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
                            url: '/app/delete',
                            type: 'POST',
                            data: {
                                _token: '{{csrf_token()}}',
                                id: idMobilT
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
    <script>
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
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire(
                                'Terhapus!',
                                response.success,
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                                    location.reload(true); // Force reload from server
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
    
    @if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
    @endif
    

@endpush
