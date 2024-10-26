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

      .col-8, .col-4 {
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

  select, button {
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

@section('judul','Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
      <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total User</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$user}}
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
      <div class="col-xl-2 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
          <div class="card-body p-3">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Mobil</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$motor}}
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

      <div class="col-xl-2 col-sm-6">
        <div class="card">
          <div class="card-body p-2">
            <div class="row">
              <div class="col-8">
                <div class="numbers">
                  <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Pesanan saat Ini</p>
                  <h5 class="font-weight-bolder mb-0">
                    {{$pesanan}}
                    <span class="text-success text-sm font-weight-bolder">Pesanan Saat ini</span>
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
      <div class="col-xl-3 col-sm-6">
        <div class="card mt-2 mb-4">
          <div class="card-body p-4">
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
    </div>
    <form method="GET" action="{{ route('dashboard.index') }}">
      <label for="year">Pilih Tahun:</label>
      <select name="year" id="year">
          @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
              <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
          @endfor
      </select>
      <button type="submit">Tampilkan</button>
  </form>

  <div class="chart-container">
      <canvas id="myLineChart" style="width: 100%; height: 300px;"></canvas>
  </div>
    @endcan
    
    <div class="row">
      @foreach ($kendaraan as $row)
      <div class="col-lg-2 mb-5 mt-3">
          <div class="card h-100 shadow border-0">
              <img class="card-img-top" src="{{route('storage',$row->gambar)}}" alt="{{$row->name}} width="50px" height="150px" />
              <div class="card-body p-4">
                  <div class="badge bg-primary bg-gradient rounded-pill mb-2">{{$row->availability}}</div>
                  <a>
                      <div class="h5 card-title mb-3">
                          {{$row->name}} <br>
                          {{$row->price_per_day}} perhari
                      </div>
                  </a>
              </div>
              <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                  <div class="d-flex align-items-end justify-content-between">
                      <div class="d-flex align-items-center">
                          <div class="small">
                              <div class="fw-bold">{{$row->type}}</div>
                              <div class="text-muted">{{$row->created_at}}</div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal fade" id="notAvailableModal{{$row->id}}" tabindex="-1" aria-labelledby="notAvailableModalLabel{{$row->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notAvailableModalLabel{{$row->id}}">Mobil Tidak Tersedia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Konten untuk modal motor tidak tersedia -->
                    <p>Mobil {{$row->name}} sedang tidak tersedia saat ini. Silakan coba lagi nanti.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
</div>
<br>
<footer>
  Ludger Rental
</footer>
@endsection

@push('js')
<script>
  // Menunggu hingga DOM sepenuhnya dimuat
  document.addEventListener("DOMContentLoaded", function () {
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
                              return 'Rp ' + value.toLocaleString('id-ID'); // Format Rupiah di Axis Y
                          }
                      }
                  }
              },
              plugins: {
                  tooltip: {
                      callbacks: {
                          label: function(tooltipItem) {
                              return 'Rp ' + tooltipItem.raw.toLocaleString('id-ID'); // Format Rupiah di Tooltip
                          }
                      }
                  }
              }
          }
      });
  });
</script>

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
