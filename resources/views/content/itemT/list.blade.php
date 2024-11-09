@extends('layout.main')
@section('judul', 'Data Rincian Biaya')

@section('content')
    <form action="{{ route('itemT.search') }}" method="GET">
        <input type="text" name="id_booking" placeholder="Cari ID Booking">
        <button type="submit">Cari</button>
    </form>

    <div class="col-12 mt-3">
        <button type="button" class="btn btn-danger" onclick="showConfirmationModal()">Hapus Semua Data</button>

        <!-- Modal Konfirmasi -->
        <div id="confirmationModal" style="display: none;">
            <div class="modal-overlay" onclick="closeConfirmationModal()"></div>
            <div class="modal-content">
                <h3>Konfirmasi Hapus Data</h3>
                <p>Apakah Anda yakin ingin menghapus semua data ini? Ini akan berpengaruh terhadap pesanan user.</p>
                <button type="button" class="btn btn-danger" id="delete-all">Ya, Hapus</button>
                <button type="button" class="btn btn-secondary" onclick="closeConfirmationModal()">Batal</button>
            </div>
        </div>

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
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Motor</th>
                            <th class="text-center">No Plat</th>
                            <th class="text-center">Perhari Rp</th>
                            <th class="text-center">total transaksi</th>
                            <th class="text-center">id_booking</th>
                            <th class="text-center">denda</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($counter = 1)
                        @foreach ($rows as $row)
                            <tr>
                                <td class="text-center">{{ $counter++ }}</td>
                                <td class="text-center">{{ $row->mobil->name }}</td>
                                <td class="text-center">{{ $row->mobil->no_plat }}</td>
                                <td class="text-center">Rp {{ number_format($row->mobil->price_per_day, 0, ',', '.') }}</td>
                                <td class="text-center">Rp {{ number_format($row->transaction->total, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $row->id_booking }}</td>
                                <td class="text-center">Rp {{ number_format($row->transaction->denda ?? 0, 0, ',', '.') }}
                                </td>
                                <td>
                                    <button type="button" data-id-mobil="{{ $row->id }}"
                                        data-name="{{ $row->mobil->name }}" class="btn btn-danger btn-sm btn-hapus">
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
        $(function() {
            $('.btn-hapus').on('click', function() {
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
                                _token: '{{ csrf_token() }}',
                                id: idMobilT
                            },
                            success: function() {
                                Swal.fire('Sukses', 'Data berhasil dihapus', 'success')
                                    .then(function() {
                                        window.location.reload();
                                    })
                            },
                            error: function() {
                                Swal.fire('Gagal',
                                    'Terjadi kesalahan ketika hapus data', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function showConfirmationModal() {
            $('#confirmationModal').show();
        }

        function closeConfirmationModal() {
            $('#confirmationModal').hide();
        }

        $(document).ready(function() {
            $('#delete-all').click(function(e) {
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
                            success: function(response) {
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil dihapus.',
                                    'success'
                                ).then((result) => {
                                    if (result.isConfirmed || result.dismiss ===
                                        Swal.DismissReason.timer) {
                                        location.reload(
                                            true); // Force reload from server
                                    }
                                });
                            },
                            error: function() {
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

    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}");
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif

@endpush
