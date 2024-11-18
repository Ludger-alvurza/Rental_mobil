@extends('layout.main')
<style>
    .chart-container {
        position: relative;
        width: 100%;
        max-width: 1000px;
        height: auto;
        margin: 20px;
    }

    #myLineChart {
        width: 100% !important;
        height: 300px !important;
    }

    @media (max-width: 768px) {
        .chart-container {
            max-width: 100%;
            padding: 10px;
        }

        #myLineChart {
            height: 200px !important;
        }

        .col-8,
        .col-4 {
            flex: 1 0 50%;
        }

        .numbers h5 {
            font-size: 16px;
        }

        .numbers p {
            font-size: 12px;
        }
    }

    form {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    label {
        font-size: 16px;
        font-weight: bold;
    }

    select,
    button {
        padding: 5px 10px;
        font-size: 14px;
        border-radius: 5px;
    }

    button {
        background-color: #3085d6;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #1e6aad;
    }

    .chart-container {
        width: 100%;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    canvas {
        width: 100% !important;
        height: auto !important;
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease-out, transform 0.5s ease-out;
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

@section('judul', 'Dashboard')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-start"> <!-- Untuk dashboard di kiri -->
            <!-- Total User -->
            <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total User</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $user }}
                                        <span class="text-success text-sm font-weight-bolder">User</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Mobil -->
            <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Mobil</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $motor }}
                                        <span class="text-success text-sm font-weight-bolder">Mobil</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pesanan -->
            <div class="col-xl-2 col-sm-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Pesanan saat Ini</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $pesanan }}
                                        <span class="text-success text-sm font-weight-bolder">Pesanan Saat Ini</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-sm-6">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Mobil Yang Butuh Service</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ count($mobilForService) }} <!-- Hitung jumlah mobil yang perlu di service -->
                                        <span class="text-success text-sm font-weight-bolder">Service Saat Ini</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @can('superadmin')
                <!-- Pendapatan -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Pendapatan</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            Rp {{ number_format($totalUang, 0, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Filter Tahun (Form) -->
                    <div class="col-lg-3 mb-4">
                        <form method="GET" action="{{ route('dashboard.index') }}" class="bg-white shadow rounded p-4">
                            <h6 class="font-weight-bold mb-3">Pilih Tahun</h6>
                            <div class="mb-3">
                                <select name="year" id="year" class="form-select form-select-lg w-100"
                                    style="width: 100%; min-width: 75px;">
                                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                                        <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
                            </div>
                        </form>
                    </div>

                    <!-- Chart -->
                    <div class="col-lg-8">
                        <div class="chart-container bg-white shadow rounded p-4">
                            <h5 class="font-weight-bold mb-3">Grafik Pendapatan</h5>
                            <canvas id="myLineChart" style="width: 100%; height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
        {{-- Form Input Search Report Tracking --}}
        <h5 class="mb-3 mt-4 text-center">Daftar Keluar Masuk Mobil</h5>
        <div class="row mt-4">
            <!-- Form Input Search Report Tracking -->
            <div class="col-lg-3 col-md-4 col-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('search') }}" method="GET">
                            <div class="form-group">
                                <label for="id">Booking ID:</label>
                                <input type="text" name="id" id="id" class="form-control" required
                                    placeholder="Masukkan Booking ID">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 w-100">Cari</button>
                        </form>
                        @if (session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (isset($booking))
                            <div class="alert alert-info mt-3">
                                <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                                <p><strong>Booking Name:</strong> {{ $booking->name }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tabel Keluar Masuk Mobil -->
            <div class="col-lg-9 col-md-8 col-12">
                <div class="card">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Booking ID</th>
                                    <th class="text-center">No Plat</th>
                                    <th class="text-center">Nama Mobil</th>
                                    <th class="text-center">Lama Sewa</th>
                                    <th class="text-center">Waktu Booking</th>
                                    <th class="text-center">Status Mobil</th>
                                    <th class="text-center">Service</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = ($report->currentPage() - 1) * $report->perPage() + 1;
                                @endphp
                                @foreach ($report as $booking)
                                    <tr>
                                        <td class="text-center">{{ $i++ }}</td>
                                        <td class="text-center">{{ $booking->id }}</td>
                                        <td class="text-center">{{ $booking->no_plat }}</td>
                                        <td class="text-center">{{ $booking->name_mobil }}</td>
                                        <td class="text-center">{{ $booking->lama_sewa }}</td>
                                        <td class="text-center">{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $booking->status == 'selesai' ? 'bg-success' : ($booking->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                {{ $booking->status == 'pending' ? 'Mobil Keluar' : ($booking->status == 'selesai' ? 'Mobil Masuk' : $booking->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if (in_array($booking->no_plat, array_keys($mobilForService)))
                                                <button type="button" class="badge bg-danger" data-bs-toggle="modal"
                                                    data-bs-target="#serviceModal{{ $booking->id }}">
                                                    Perlu Service
                                                </button>
                                            @else
                                                <span class="badge bg-success">Belum Perlu Service</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="serviceModal{{ $booking->id }}" tabindex="-1"
                                        aria-labelledby="serviceModalLabel{{ $booking->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="serviceModalLabel{{ $booking->id }}">
                                                        Detail Mobil yang Perlu Service
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6>No Plat: {{ $booking->no_plat }}</h6>
                                                    <p>Nama Mobil: {{ $booking->name_mobil }}</p>
                                                    <p>Lama Sewa: {{ $booking->lama_sewa }}</p>
                                                    <p>Waktu Booking: {{ $booking->created_at->format('d-m-Y H:i') }}</p>
                                                    <p>Status Mobil:
                                                        <span
                                                            class="badge 
                                                            {{ $booking->status == 'selesai' ? 'bg-success' : ($booking->status == 'pending' ? 'bg-warning' : 'bg-danger') }}">
                                                            {{ $booking->status == 'pending' ? 'Mobil Keluar' : ($booking->status == 'selesai' ? 'Mobil Masuk' : $booking->status) }}
                                                        </span>
                                                    </p>
                                                    <p>Jumlah Hari Pesanan Mobil Mencapai: {{ $duration }} Hari</p>
                                                    <div class="alert alert-warning" role="alert">
                                                        <h5>Peringatan!!</h5>
                                                        <p>Mobil Perlu Diservice atau Pengecekan Ulang. Sistem akan
                                                            mematikan
                                                            ketersediaan mobil ini agar tidak dapat dipesan setelah
                                                            pengembalian
                                                            pesanan terakhir.</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <a href="{{ url('/mobil') }}" class="btn btn-primary">List Mobil</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-3">
                    <nav>
                        <ul class="pagination pagination-sm">
                            {{ $report->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script>
            // Menunggu hingga DOM sepenuhnya dimuat
            document.addEventListener("DOMContentLoaded", function() {
                var ctx = document.getElementById('myLineChart').getContext('2d');
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($bulanLabels), // Label bulan hingga bulan saat ini
                        datasets: [{
                            label: 'Pendapatan Bulanan (Rp)',
                            data: @json($pendapatanBulanArray), // Data pendapatan per bulan
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3
                        }]
                    },
                    options: {
                        animation: {
                            duration: 1000, // Durasi animasi dalam milidetik
                            easing: 'easeOutBounce', // Jenis easing animasi
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString(
                                            'id-ID'); // Format Rupiah di Axis Y
                                    }
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return 'Rp ' + tooltipItem.raw.toLocaleString(
                                            'id-ID'); // Format Rupiah di Tooltip
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>

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
