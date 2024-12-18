@extends('layout.main')
@section('judul', 'Data Mobil')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('admin')
                        <a class="btn btn-primary mb-2" href="{{ url('/mobil/add') }}">Tambah Data Mobil</a>
                    @endcan
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Type</th>
                                    <th>Tahun</th>
                                    <th>Harga Per Hari</th>
                                    <th>Denda Per Hari</th>
                                    <th>Ketersediaan</th>
                                    <th>Nomor Plat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($mobils->currentPage() - 1) * $mobils->perPage() + 1;
                                @endphp
                                @foreach ($mobils as $row)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td><img src="{{ route('storage', $row->gambar) }}" width="50px" height="50px">
                                        </td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->type }}</td>
                                        <td>{{ $row->year }}</td>
                                        <td>Rp {{ number_format($row->price_per_day, 0, ',', '.') }}</td>
                                        <td>Rp {{ $row->denda }}</td>
                                        <td>
                                            <span
                                                class="badge 
                                                @if ($row->availability == 'Tersedia') bg-success 
                                                @elseif ($row->availability == 'Sold Out') 
                                                    bg-danger 
                                                @else
                                                    bg-secondary @endif">
                                                @if ($row->availability == 'Sold Out')
                                                    Tidak Tersedia
                                                @else
                                                    {{ $row->availability }}
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $row->no_plat }}</td>
                                        @can('admin')
                                            <td>
                                                <button type="button" data-id-mobil="{{ $row->id }}"
                                                    data-name="{{ $row->name }}" class="btn btn-danger btn-sm btn-hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- Modal Trigger Button -->
                                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $row->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endcan
                                            <!-- Modal -->
                                            <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $row->id }}">
                                                                Edit Data Pengguna</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Form untuk mengedit data pengguna -->
                                                            <form method="post" action="{{ url('mobil/update') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="id"
                                                                    value="{{ $row->id }}" />
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="mb-3">
                                                                                    <label for="form-label">Gambar</label>
                                                                                    <input type="file" name="gambar"
                                                                                        class="form-control @error('gambar') is-invalid @enderror"
                                                                                        accept="image/*"
                                                                                        onchange="tampilkanPreview(this, 'tampilFoto')"
                                                                                        value="{{ $row->gambar }}">
                                                                                    @error('gambar')
                                                                                        <span
                                                                                            style="color:red; font-wight: 600; font-size: 9pt">{{ $message }}</span>
                                                                                    @enderror
                                                                                    <p></p>
                                                                                    <img id="tampilFoto"
                                                                                        onerror="this.onerror=null; this.src='https://t4.ftcdn.net/jpg/04/73/25/49/360_F_473254957_bxG9yf4ly7OBO5I0O5KABLN930GwaMQz.jpg'; "
                                                                                        src="{{ route('storage', $row->gambar) }}"
                                                                                        alt="" width="15%">
                                                                                </div>
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
                                                                                    <label for="type">Pilih Type</label>
                                                                                    <select name="type"
                                                                                        class="form-control @error('type') is-invalid @enderror">
                                                                                        <option
                                                                                            value="{{ $row->type }}">
                                                                                            Pilih Type</option>
                                                                                        <option value="keluarga"
                                                                                            {{ old('type', $row->type) == 'keluarga' ? 'selected' : '' }}>
                                                                                            Keluarga</option>
                                                                                        <option value="box"
                                                                                            {{ old('type', $row->type) == 'box' ? 'selected' : '' }}>
                                                                                            Box</option>
                                                                                        <option value="sport"
                                                                                            {{ old('type', $row->type) == 'sport' ? 'selected' : '' }}>
                                                                                            Sport</option>
                                                                                    </select>
                                                                                    @error('type')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="brand">Brand</label>
                                                                                    <select name="brand"
                                                                                        class="form-control @error('brand') is-invalid @enderror">
                                                                                        <!-- Opsi default yang dipilih, menggunakan nilai yang ada pada $row->brand -->
                                                                                        <option value="{{ $row->brand }}"
                                                                                            disabled selected>
                                                                                            {{ $row->brand }}</option>

                                                                                        <!-- Opsi lainnya, pilih berdasarkan nilai old atau nilai yang ada di $row->brand -->
                                                                                        <option value="toyota"
                                                                                            {{ old('brand', $row->brand) == 'toyota' ? 'selected' : '' }}>
                                                                                            Toyota</option>
                                                                                        <option value="honda"
                                                                                            {{ old('brand', $row->brand) == 'honda' ? 'selected' : '' }}>
                                                                                            Honda</option>
                                                                                        <option value="ford"
                                                                                            {{ old('brand', $row->brand) == 'ford' ? 'selected' : '' }}>
                                                                                            Ford</option>
                                                                                        <option value="chevrolet"
                                                                                            {{ old('brand', $row->brand) == 'chevrolet' ? 'selected' : '' }}>
                                                                                            Chevrolet</option>
                                                                                        <option value="nissan"
                                                                                            {{ old('brand', $row->brand) == 'nissan' ? 'selected' : '' }}>
                                                                                            Nissan</option>
                                                                                        <option value="volkswagen"
                                                                                            {{ old('brand', $row->brand) == 'volkswagen' ? 'selected' : '' }}>
                                                                                            Volkswagen</option>
                                                                                        <option value="hyundai"
                                                                                            {{ old('brand', $row->brand) == 'hyundai' ? 'selected' : '' }}>
                                                                                            Hyundai</option>
                                                                                        <option value="kia"
                                                                                            {{ old('brand', $row->brand) == 'kia' ? 'selected' : '' }}>
                                                                                            Kia</option>
                                                                                        <option value="subaru"
                                                                                            {{ old('brand', $row->brand) == 'subaru' ? 'selected' : '' }}>
                                                                                            Subaru</option>
                                                                                        <option value="mazda"
                                                                                            {{ old('brand', $row->brand) == 'mazda' ? 'selected' : '' }}>
                                                                                            Mazda</option>
                                                                                        <option value="bmw"
                                                                                            {{ old('brand', $row->brand) == 'bmw' ? 'selected' : '' }}>
                                                                                            BMW</option>
                                                                                        <option value="mercedes"
                                                                                            {{ old('brand', $row->brand) == 'mercedes' ? 'selected' : '' }}>
                                                                                            Mercedes-Benz</option>
                                                                                        <option value="audi"
                                                                                            {{ old('brand', $row->brand) == 'audi' ? 'selected' : '' }}>
                                                                                            Audi</option>
                                                                                        <option value="lexus"
                                                                                            {{ old('brand', $row->brand) == 'lexus' ? 'selected' : '' }}>
                                                                                            Lexus</option>
                                                                                        <option value="porsche"
                                                                                            {{ old('brand', $row->brand) == 'porsche' ? 'selected' : '' }}>
                                                                                            Porsche</option>
                                                                                        <option value="jaguar"
                                                                                            {{ old('brand', $row->brand) == 'jaguar' ? 'selected' : '' }}>
                                                                                            Jaguar</option>
                                                                                        <option value="land_rover"
                                                                                            {{ old('brand', $row->brand) == 'land_rover' ? 'selected' : '' }}>
                                                                                            Land Rover</option>
                                                                                        <option value="tesla"
                                                                                            {{ old('brand', $row->brand) == 'tesla' ? 'selected' : '' }}>
                                                                                            Tesla</option>
                                                                                        <option value="volvo"
                                                                                            {{ old('brand', $row->brand) == 'volvo' ? 'selected' : '' }}>
                                                                                            Volvo</option>
                                                                                        <option value="mitsubishi"
                                                                                            {{ old('brand', $row->brand) == 'mitsubishi' ? 'selected' : '' }}>
                                                                                            Mitsubishi</option>
                                                                                        <option value="Lamborghini"
                                                                                            {{ old('brand', $row->brand) == 'Lamborghini' ? 'selected' : '' }}>
                                                                                            Lamborghini</option>
                                                                                        <option value="Ferrari"
                                                                                            {{ old('brand', $row->brand) == 'Ferrari' ? 'selected' : '' }}>
                                                                                            Ferrari</option>
                                                                                        <option value="MClaren"
                                                                                            {{ old('brand', $row->brand) == 'MClaren' ? 'selected' : '' }}>
                                                                                            MClaren</option>
                                                                                    </select>
                                                                                    @error('brand')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="">Tahun</label>
                                                                                    <input type="text"
                                                                                        class="form-control @error('year') is-invalid @enderror"
                                                                                        value="{{ $row->year }}"
                                                                                        name="year">
                                                                                    @error('year')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Harga Per
                                                                                        Hari</label>
                                                                                    <input type="price_per_day"
                                                                                        class="form-control @error('price_per_day') is-invalid @enderror"
                                                                                        value="{{ $row->price_per_day }}"
                                                                                        name="price_per_day">
                                                                                    @error('price_per_day')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}
                                                                                        </div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label
                                                                                        for="availability">Ketersediaan</label>
                                                                                    <select id="availability"
                                                                                        name="availability"
                                                                                        class="form-control @error('availability') is-invalid @enderror">
                                                                                        <option value="Tersedia"
                                                                                            {{ $row->availability === 'Tersedia' ? 'selected' : '' }}>
                                                                                            Tersedia</option>
                                                                                        <option value="Sold Out"
                                                                                            {{ $row->availability === 'Sold Out' ? 'selected' : '' }}>
                                                                                            Tidak Tersedia</option>
                                                                                    </select>
                                                                                    @error('availability')
                                                                                        <div class="invalid-feedback">
                                                                                            {{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="">Denda</label>
                                                                                    <input type="denda"
                                                                                        class="form-control @error('denda') is-invalid @enderror"
                                                                                        value="{{ $row->denda }}"
                                                                                        name="denda">
                                                                                    @error('denda')
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
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $mobils->links() }}
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
                let idMobil = $(this).data('id-mobil');
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
                            url: '/mobil/delete',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: idMobil
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
