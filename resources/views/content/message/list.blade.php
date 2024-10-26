@extends('layout.main')
@section('judul', 'Message Ratings')
<style>
    .star {
    font-size: 20px; /* Ukuran bintang */
    color: #ccc; /* Warna bintang kosong */
}

.star.filled {
    color: gold; /* Warna bintang terisi */
}

</style>

@section('content')
    <div class="container">
        {{-- <h1>Message Ratings</h1> --}}
        {{-- <a href="{{ route('message_ratings.create') }}" class="btn btn-success">Create New Rating</a> --}}
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Message</th>
                    <th>mobil</th>
                    <th>nomor plat</th>
                    <th>rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messageRatings as $rating)
                    <tr>
                        <td>{{ $rating->user->name }}</td>
                        <td>{{ $rating->message }}</td>
                        <td>{{ $rating->mobil->name }}</td>
                        <td>{{ $rating->mobil->no_plat }}</td>
                        <td>
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating->rating)
                                    <span class="star filled">★</span> <!-- Bintang terisi -->
                                @else
                                    <span class="star">☆</span> <!-- Bintang kosong -->
                                @endif
                            @endfor
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $rating->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" data-id-message="{{ $rating->id }}" data-name="{{ $rating->message }}"
                                class="btn btn-danger btn-sm btn-hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="editModal{{ $rating->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $rating->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $rating->id }}">Edit Message Rating</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="message">Message</label>
                                                <textarea name="message" class="form-control" required maxlength="30" readonly>{{ old('message', $rating->message) }}</textarea>
                                                @error('message')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>                                            
                                                <div class="form-group">
                                                    <label for="user_id">User</label> <!-- gunakan user_id -->
                                                    <select name="user_id" class="form-control" disabled> <!-- gunakan disabled -->
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}" {{ $user->id == $rating->user_id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>                                                
                                                <button data-bs-dismiss="modal" class="btn btn-primary">tutup</button>                                               
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
@endsection
@push('js')
    <script>
        $(function() {
            $('.btn-hapus').on('click', function() {
                let idMessage = $(this).data('id-message');
                let name = $(this).data('name');
                Swal.fire({
                    title: "Konfirmasi",
                    text: `Anda yakin hapus Message ${name}?`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/message_ratings/delete',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: idMessage
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
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire(
                                'Terhapus!',
                                response.success,
                                'success'
                            ).then((result) => {
                                if (result.isConfirmed || result.dismiss === Swal
                                    .DismissReason.timer) {
                                    location.reload(true); // Force reload from server
                                }
                            });
                        },
                        error: function(response) {
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
