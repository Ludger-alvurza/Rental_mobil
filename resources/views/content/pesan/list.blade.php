@extends('layout.main')
@section('judul', 'Data Pesanan')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('admin')
                    @endcan
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">ID Booking</th>
                                    <th class="text-center">Status Pemesanan</th>
                                    <th>Action</th>
                                    <th class="text-center">Verifikasi Pesanan</th>
                                    <th class="text-center">Status Pengembalian</th>
                                    <th>Status Pembayaran</th>
                                    <th>Tandai Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($bkuser->currentPage() - 1) * $bkuser->perPage() + 1;
                                @endphp
                                @foreach ($bkuser as $row)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">{{ $row->id }}</td>
                                        <td class="text-center"> <!-- Menambahkan kelas text-center untuk meratakan teks di tengah -->
                                            <span class="badge
                                                {{ $row->pembatalan == 'Terverifikasi' ? 'bg-success' : ($row->pembatalan == 'Dipesan' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $row->pembatalan }}
                                            </span>
                                        </td>                                        
                                        <td>
                                            @can('admin')
                                                <button type="button" data-id-pesanan="{{ $row->id }}"
                                                    data-name="{{ $row->name }}" class="btn btn-danger btn-sm btn-hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- Modal Trigger Button -->
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $row->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $row->id }}" data-bs-toggle="tooltip" title="Lihat Detail Pesanan">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            @endcan
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="pembatalanPesan{{ $row->id }}" tabindex="-1"
                                                aria-labelledby="pembatalanPesanLabel{{ $row->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="pembatalanPesanLabel{{ $row->id }}">Verifikasi
                                                                Pesanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form method="post" action="{{ url('pesanan/batal') }}">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $row->id }}" />
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="pembatalan" class="form-label">Silahkan
                                                                        Pilih Untuk Melanjutkan</label>
                                                                    <select class="form-select" id="pembatalan"
                                                                        name="pembatalan">
                                                                        <option value="Dipesan"
                                                                            {{ $row->Pembatalan == 'Dipesan' ? 'selected' : '' }}>
                                                                            Lanjutkan pesanan</option>
                                                                        <option value="Dibatalkan"
                                                                            {{ $row->Pembatalan == 'Dibatalkan' ? 'selected' : '' }}>
                                                                            Batalkan pesanan</option>
                                                                        <option value="Terverifikasi"
                                                                            {{ $row->Pembatalan == 'Terverifikasi' ? 'selected' : '' }}>
                                                                            Verifikasi Pesanan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $row->id }}">
                                                                Edit Data Pesanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form untuk mengedit data pengguna -->
                                                            <form method="post" action="{{ url('pesanan/update') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $row->id }}" />
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="form-group">
                                                                                    <label for="">no_plat</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('no_plat') is-invalid @enderror"
                                                                                        value="{{ $row->no_plat }}"
                                                                                        name="no_plat">
                                                                                    @error('no_plat')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Name</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('name') is-invalid @enderror"
                                                                                        value="{{ $row->name }}"
                                                                                        name="name">
                                                                                    @error('name')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Nama Mobil</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('name_mobil') is-invalid @enderror"
                                                                                        value="{{ $row->name_mobil }}"
                                                                                        name="name_mobil">
                                                                                    @error('name_mobil')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Lama Sewa</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('lama_sewa') is-invalid @enderror"
                                                                                        value="{{ $row->lama_sewa }}"
                                                                                        name="lama_sewa">
                                                                                    @error('lama_sewa')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="">Keterangan</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('keterangan') is-invalid @enderror"
                                                                                        value="{{ $row->keterangan }}"
                                                                                        name="keterangan">
                                                                                    @error('keterangan')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <button
                                                                                    class="btn btn-primary">Simpan</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="detailModal{{ $row->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $row->id }}">
                                                                Detail Pesanan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <p><strong>Nama Pemesan:</strong> {{ $row->name }}</p>
                                                                            <p><strong>No Plat:</strong> {{ $row->no_plat }}</p>
                                                                            <p><strong>Nama Mobil:</strong> {{ $row->name_mobil }}</p>
                                                                            <p><strong>Lama Sewa:</strong> {{ $row->lama_sewa }}</p>
                                                                            <p><strong>Keterangan:</strong> {{ $row->keterangan }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#pembatalanPesan{{ $row->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>                                            
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge 
                                                {{ $row->status == 'selesai' ? 'bg-success' : ($row->status == 'pending' ? 'bg-warning' : 'bg-danger') }} mx-auto">
                                                {{ $row->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge 
                                                {{ $row->payment_status == 'Paid' ? 'bg-success' : ($row->payment_status == 'Pending' ? 'bg-warning' : 'bg-danger') }} mx-auto">
                                                {{ $row->payment_status }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-konfirmasi"
                                                data-id="{{ $row->id }}" data-name="Pesanan {{ $row->id }}">
                                                Konfirmasi Pengembalian
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $bkuser->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('.btn-hapus').on('click', function() {
                let idPesanan = $(this).data('id-pesanan');
                let name = $(this).data('name');
                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin hapus Pesanan ${name}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/pesanan/delete',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: idPesanan
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
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>    
    <script>
        $(function() {
            $('.btn-konfirmasi').on('click', function() {
                let idPesanan = $(this).data('id');
                let name = $(this).data('name');

                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin konfirmasi pengembalian untuk ${name}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Konfirmasi!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.konfirmasiPengembalian', '') }}/" +
                                idPesanan,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                if (response.message === 'Pesanan ini sudah selesai') {
                                    Swal.fire('Info', response.message, 'info');
                                } else {
                                    Swal.fire('Sukses',
                                            'Pengembalian berhasil dikonfirmasi',
                                            'success')
                                        .then(function() {
                                            window.location.reload();
                                        });
                                }
                            },
                            error: function() {
                                Swal.fire('Gagal',
                                    'Terjadi kesalahan ketika konfirmasi pengembalian',
                                    'error');
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
