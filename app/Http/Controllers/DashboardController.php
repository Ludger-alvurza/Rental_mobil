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

    // Ambil data lain yang dibutuhkan
    $user = User::count();
    $userT = Auth::user();
    $pesanan = bkuser::where('pembatalan', 'Dipesan')->count();
    $syarat = SyaratS::first();
    $motor = Mobil::count();
    $kendaraan = Mobil::latest()->take(6)->get();

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
        'selectedYear' => $selectedYear
    ]);
}

    public function index2(){
        $kendaraan = Mobil::latest()->get()->take(6);
        $userT = Auth::user();
        $syarat = SyaratS::first();
        $messageRatings = MessageRating::with('user')->get()->take(20);
        return view('layout-fe.dashboardfe' ,['kendaraan' => $kendaraan,'userT' => $userT,'syarat' => $syarat,'messageRatings' => $messageRatings]);
    }
    public function index3(){
        $kendaraan = Mobil::latest()->get()->take(6);
        $syarat = SyaratS::first();
        $messageRatings = MessageRating::with('user')->get()->take(20);
        return view('layout-fe.dashboardfe2' ,['kendaraan' => $kendaraan,'syarat' => $syarat, 'messageRatings' => $messageRatings]);
    }
}
