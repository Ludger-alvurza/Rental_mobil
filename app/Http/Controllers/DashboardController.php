<?php

namespace App\Http\Controllers;

use App\Models\bkuser;
use App\Models\MessageRating;
use App\Models\Mobil;
use App\Models\SyaratS;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $currentMonth = date('n'); // Bulan sekarang
    $currentYear = date('Y');  // Tahun sekarang
    
    // Cek apakah user pilih tahun atau enggak, default ke tahun sekarang
    $selectedYear = $request->input('year', $currentYear);

    // Query pendapatan bulanan berdasarkan tahun yang dipilih
    $pendapatanBulan = Transaction::selectRaw('SUM(total) as total, MONTH(created_at) as bulan')
        ->whereYear('created_at', $selectedYear)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->pluck('total', 'bulan')
        ->toArray();

    // Daftar bulan
    $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    // Inisialisasi array pendapatan bulanan (default 0 untuk setiap bulan)
    $pendapatanBulanArray = array_fill(0, 12, 0);

    // Masukkan total pendapatan ke bulan yang sesuai
    foreach ($pendapatanBulan as $bulanIndex => $total) {
        $pendapatanBulanArray[$bulanIndex - 1] = $total;
    }

    // Cek apakah tahun yang dipilih adalah tahun sekarang
    if ($selectedYear == $currentYear) {
        // Jika tahun sekarang, tampilkan data hingga bulan saat ini
        $bulanLabels = array_slice($bulan, 0, $currentMonth);
        $pendapatanBulanArray = array_slice($pendapatanBulanArray, 0, $currentMonth);
    } else {
        // Jika tahun sebelumnya, tampilkan data dari Januari sampai Desember
        $bulanLabels = $bulan;
    }

    // Total pendapatan untuk tahun yang dipilih
    $totalUang = Transaction::whereYear('created_at', $selectedYear)->sum('total');
    // Ambil data pesanan dengan kondisi pembatalan terverifikasi
    $services = bkuser::where('pembatalan', 'Terverifikasi')->paginate(5);

    // Array untuk menyimpan jumlah pemesanan per no_plat yang perlu di-service
    $mobilForService = [];
    $durations = []; // Array untuk menyimpan data durasi per no_plat

    // Loop untuk menghitung durasi berdasarkan no_plat dan booking date range
    foreach ($services as $booking) {
        // Cek apakah booking_start dan booking_end ada dan valid
        if ($booking->booking_start && $booking->booking_end) {
            // Pastikan booking_start dan booking_end menjadi objek Carbon
            $bookingStart = Carbon::parse($booking->booking_start);
            $bookingEnd = Carbon::parse($booking->booking_end);

            // Menghitung jumlah hari antara booking_end dan booking_start
            $duration = $bookingEnd->diffInDays($bookingStart);
        } else {
            // Jika booking_start atau booking_end kosong, set $duration ke null
            $duration = null;
        }

        // Simpan nilai duration untuk setiap booking dalam array durations berdasarkan no_plat
        if ($duration !== null) {
            // Jika no_plat sudah ada, jumlahkan durasi sebelumnya
            if (isset($durations[$booking->no_plat])) {
                $durations[$booking->no_plat] += $duration;
            } else {
                $durations[$booking->no_plat] = $duration;
            }
        }
    }
    // Loop melalui durasi dan cek apakah total durasinya lebih dari 30 hari
    foreach ($durations as $no_plat => $totalDuration) {
        if ($totalDuration >= 30) {
            // Jika total durasi lebih dari 30 hari, anggap mobil perlu di-service
            $mobilForService[$no_plat] = $totalDuration;
        }
    }
    // dd($duration);
    $user = User::count();
    $userT = Auth::user();
    $pesanan = bkuser::where('pembatalan', 'Dipesan')->count();
    $report = bkuser::where('pembatalan', 'Terverifikasi')->paginate(5);
    $syarat = SyaratS::first();
    $motor = Mobil::count();
    $kendaraan = Mobil::latest()->take(6)->get();
    $agent = new Agent();
    $isMobile = $agent->isMobile();

    // Kirim data ke view
    return view('content.dashboard', [
        'kendaraan' => $kendaraan,
        'user' => $user,
        'userT' => $userT,
        'motor' => $motor,
        'syarat' => $syarat,
        'pesanan' => $pesanan,
        'totalUang' => $totalUang,
        'pendapatanBulanArray' => $pendapatanBulanArray,
        'bulanLabels' => $bulanLabels,
        'selectedYear' => $selectedYear,
        'isMobile' => $isMobile,
        'report' => $report,
        'mobilForService' => $mobilForService,
        'duration' => $duration ?? null
    ]);
}

public function index2(){
    // Ambil semua kendaraan
    $kendaraan = Mobil::leftJoin('message_rating', 'mobils.id', '=', 'message_rating.id_mobil')
        ->select(
            'mobils.*', 
            DB::raw('AVG(message_rating.rating) as avg_rating'), // Rata-rata rating
            DB::raw('COUNT(message_rating.rating) as total_ratings') // Jumlah rating
        )
        ->groupBy('mobils.id')
        ->orderByDesc('avg_rating')
        ->take(6)
        ->get();

    $agent = new Agent();

    $isMobile = $agent->isMobile();
    $userT = Auth::user();
    $syarat = SyaratS::first();
    $messageRatings = MessageRating::with('user')->get()->take(20);

    // Ambil data booking untuk setiap mobil
    foreach ($kendaraan as $mobil) {
        // Ambil semua booking yang ada untuk mobil ini
        $bookings = bkuser::where('id_mobil', $mobil->id)
            ->get(['booking_start', 'booking_end']);

        $availableDates = [];
        $today = \Carbon\Carbon::today(); // Tanggal hari ini
        $endPeriod = \Carbon\Carbon::today()->addDays(30); // Bisa disesuaikan, ini misalnya 30 hari ke depan

        // Loop dari tanggal hari ini sampai tanggal yang diinginkan
        while ($today <= $endPeriod) {
            $isAvailable = true;

            // Periksa apakah tanggal tersebut bentrok dengan booking yang ada
            foreach ($bookings as $booking) {
                $bookingStart = \Carbon\Carbon::parse($booking->booking_start);
                $bookingEnd = \Carbon\Carbon::parse($booking->booking_end);

                // Cek jika tanggal hari ini ada dalam rentang booking
                if ($today->between($bookingStart, $bookingEnd)) {
                    $isAvailable = false;
                    break;
                }
            }

            // Jika tanggal tidak bentrok, tambahkan ke array tanggal yang tersedia
            if ($isAvailable) {
                $availableDates[] = $today->format('Y-m-d');
            }

            // Tambahkan satu hari ke tanggal sekarang
            $today->addDay();
        }

        // Menyimpan tanggal yang tersedia pada mobil ini
        $mobil->available_dates = $availableDates;
    }

    return view('layout-fe.dashboardfe', [
        'kendaraan' => $kendaraan,
        'userT' => $userT,
        'syarat' => $syarat,
        'messageRatings' => $messageRatings,
        'isMobile' => $isMobile
    ]);
}

    public function index3(){
        $agent = new Agent();

        $isMobile = $agent->isMobile();
        $kendaraan = Mobil::latest()->get()->take(6);
        $syarat = SyaratS::first();
        $messageRatings = MessageRating::with('user')->get()->take(20);
        return view('layout-fe.dashboardfe2' ,['kendaraan' => $kendaraan,'syarat' => $syarat, 'messageRatings' => $messageRatings,'isMobile' => $isMobile]);
    }
}
