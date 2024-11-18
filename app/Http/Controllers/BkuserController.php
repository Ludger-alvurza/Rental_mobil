<?php

namespace App\Http\Controllers;

use App\Jobs\PembatalanOtomatis;
use App\Models\bkuser;
use App\Models\ItemTransaction;
use App\Models\MessageRating;
use App\Models\Mobil;
use App\Models\SyaratS;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\PaymentSuccess;
use App\Notifications\PeminjamanSelesaiNotification;
use App\Notifications\PesananDibatalkanMail;
use App\Notifications\PesananTerverifikasiMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Jenssegers\Agent\Agent;

class BkuserController extends Controller
{
    public function list()
    {
        $bkuser = bkuser::query()
            ->paginate();
        return view('content.pesan.list', [
            'bkuser' => $bkuser
        ]);
    }
    public function pesanan()
    {
        $syarat = SyaratS::first();
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $bkuser = Bkuser::where('id_user', $user->id)
            ->paginate();

        return view('layout-fe.pesanan', [
            'bkuser' => $bkuser,
            'user' => $user,
            'syarat' =>  $syarat
        ]);
    }

    public function add(){
        return view('content.pesan.add');
    }
    public function insert(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_mobil' => 'required',
                'id_user' => 'required',
                'name' => 'required',
                'no_plat' => 'required',
                'booking_start' => 'required|date',
                'booking_end' => 'required|date|after_or_equal:booking_start',
                'name_mobil' => 'required',
                'lama_sewa' => 'required',
                'keterangan' => 'required'
            ]);

            $conflictingDates = [];

            $existingBooking = bkuser::where('id_mobil', $request->id_mobil)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('booking_start', [$request->booking_start, $request->booking_end])
                        ->orWhereBetween('booking_end', [$request->booking_start, $request->booking_end])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('booking_start', '<=', $request->booking_start)
                                ->where('booking_end', '>=', $request->booking_end);
                        });
                })
                ->get();

            if ($existingBooking->isNotEmpty()) {
                foreach ($existingBooking as $booking) {
                    $formattedStart = Carbon::parse($booking->booking_start)->format('d-m-Y');
                    $formattedEnd = Carbon::parse($booking->booking_end)->format('d-m-Y');
                    $conflictingDates[] = "Mulai: $formattedStart - Sampai: $formattedEnd";
                }

                $message = 'Pesanan tidak dapat dilakukan karena mobil sudah dipesan pada tanggal berikut: ' . implode(', ', $conflictingDates) . '. Silakan pilih tanggal lain.';
                return response()->json(['message' => $message], 400);
            }
                        

            // Insert data baru karena tidak ada bentrok
            $bkuser = new bkuser();
            $bkuser->id_mobil = $request->id_mobil;
            $bkuser->id_user = $request->id_user;
            $bkuser->name = $request->name;
            $bkuser->no_plat = $request->no_plat;
            $bkuser->booking_start = $request->booking_start;
            $bkuser->booking_end = $request->booking_end;
            $bkuser->name_mobil = $request->name_mobil;
            $bkuser->lama_sewa = $request->lama_sewa;
            $bkuser->keterangan = $request->keterangan;
            $bkuser->save();

            Session::flash('success', 'Pesanan Anda Berhasil. Silahkan Tunggu Verifikasi.');
            return redirect(url('/sewa-mobil'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memesan. Pesanan Gagal.');
            return redirect(url('/sewa-mobil'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal Menambah Pesanan.');
            return redirect(url('/sewa-mobil'));
        }
    }

    public function edit(Request $request, $id)
    {
        $bkuser = bkuser::find($id);
        if ($bkuser === null) {
            abort(404);
        }
        return view('content.pesan.edit', [
            'bkuser' => $bkuser
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required',
                'no_plat' => 'required',
                'name_mobil' => 'required',
                'lama_sewa' => 'required',
                'keterangan' => 'required'
            ]);

            $bkuser = bkuser::findOrFail($request->id);

            $bkuser->name = $request->name;
            $bkuser->no_plat = $request->no_plat;
            $bkuser->name_mobil = $request->name_mobil;
            $bkuser->lama_sewa = $request->lama_sewa;
            $bkuser->keterangan = $request->keterangan;
            $bkuser->save();

            // Tambahkan pesan keberhasilan ke sesi
            Session::flash('success', 'Data pesanan berhasil diperbarui.');

            return redirect(url('/pesanan'));

        } catch (ModelNotFoundException $e) {
            Session::flash('error', 'Gagal memperbarui data Mobil. Mobil tidak ditemukan.');
            return redirect(url('/pesanan'));
        } catch (\Exception $e) {
            Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data Mobil.');
            return redirect(url('/pesanan'));
        }
    }

    public function batalForm($id){
        $row = bkuser::find($id);
        return view('content.formbatal.bataladmin',compact('row'));
    }

    public function batal(Request $request)
{
    try {
        // Validasi input
        $validated = $request->validate([
            'pembatalan' => 'required|in:Dipesan,Dibatalkan,Terverifikasi',
        ]);

        $bkuser = Bkuser::findOrFail($request->id);
        $user = auth()->user();

        if ($bkuser->pembatalan === 'Dibatalkan' && $user->role === 'superadmin') {
            if ($request->pembatalan === 'Terverifikasi') {
                Session::flash('error', 'Pesanan sudah dibatalkan dan tidak dapat diverifikasi.');
                return $this->redirectBasedOnRole($user);
            }

            if ($request->pembatalan === 'Dipesan' && $user->role === 'superadmin') {
                Session::flash('error', 'Pesanan sudah dibatalkan dan tidak dapat diubah menjadi Dipesan.');
                return $this->redirectBasedOnRole($user);
            }
        }

        if ($user && $user->role !== 'superadmin') {
            if ($request->pembatalan === 'Dibatalkan') {
                $admins = User::where('role', 'superadmin')->get();
                foreach ($admins as $admin) {
                    $admin->notify(new PesananDibatalkanMail($bkuser));
                }

                dispatch(new PembatalanOtomatis($bkuser->id))->delay(now()->addMinutes(10));
                Session::flash('success', 'Permintaan pembatalan sudah dikirim ke admin. Silahkan Tunggu 10 menit pesanan akan otomatis dibatalkan.');
                return redirect(url('/pesanan/keranjang'));
            } elseif ($request->pembatalan === 'Dipesan') {
                $bkuser->pembatalan = 'Dipesan';
                $bkuser->save();
                Session::flash('success', 'Data pesanan berhasil diubah menjadi Dipesan.');
                return redirect(url('/pesanan/keranjang'));
            } else {
                Session::flash('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini. Silakan hubungi admin.');
                return redirect(url('/pesanan/keranjang'));
            }
        }

        $bkuser->pembatalan = $request->pembatalan;
        $bkuser->save();

        if ($bkuser->pembatalan === 'Terverifikasi') {
            $userPesanan = User::find($bkuser->id_user);
            if ($userPesanan) {
                $userPesanan->notify(new PesananTerverifikasiMail($bkuser));
                Session::flash('success', 'Data pesanan berhasil diverifikasi dan email notifikasi telah dikirim.');
            } else {
                Session::flash('error', 'Pengguna terkait pesanan ini tidak ditemukan, notifikasi tidak dapat dikirim.');
            }
        } elseif ($request->pembatalan == 'Dibatalkan') {
            Session::flash('success', 'Data pesanan berhasil dibatalkan.');
        } else {
            Session::flash('success', 'Data pesanan berhasil dilanjutkan.');
        }

        return $this->redirectBasedOnRole($user);

    } catch (ModelNotFoundException $e) {
        Session::flash('error', 'Gagal memperbarui data pesanan. Pesanan tidak ditemukan.');
        return redirect(url('/pesanan/keranjang'));
    } catch (\Exception $e) {
        Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data pesanan.');
        return redirect(url('/pesanan/keranjang'));
    }
}

// Fungsi untuk redirect berdasarkan role user
private function redirectBasedOnRole($user)
{
    if ($user && $user->role === 'superadmin') {
        return redirect(url('/pesanan'));
    } else {
        return redirect(url('/pesanan/keranjang'));
    }
}


    public function delete(Request $request)
    {
        $idPesan = $request->id;
        $bkuser = bkuser::find($idPesan);
        if ($bkuser === null) {
            return response()->json([], 404);
        }
        $bkuser->delete();
        return response()->json([], 200);
    }

    public function konfirmasiPengembalian($id)
{

    $peminjaman = bkuser::find($id);
    
    // Cek apakah peminjaman ditemukan
    if (!$peminjaman) {
        return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
    }

    // Jika status sudah selesai, tidak perlu kirim notifikasi lagi
    if ($peminjaman->status === 'selesai') {
        return response()->json(['message' => 'Pesanan ini sudah selesai'], 200);
    }

    // Update status peminjaman menjadi selesai
    $peminjaman->status = 'selesai';
    $peminjaman->save();

    // Kirim notifikasi ke user jika status sebelumnya belum selesai
    $user = User::find($peminjaman->id_user);
    
    if ($user) {
        $user->notify(new PeminjamanSelesaiNotification($peminjaman));
    } else {
        // Tangani jika pengguna tidak ditemukan
        return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
    }

    return response()->json(['message' => 'Status peminjaman diperbarui dan notifikasi telah dikirim'], 200);
}
    public function konfirmasiPembayaran($id)
    {
        $pembayaran = bkuser::find($id);
        
        // Cek apakah peminjaman ditemukan
        if (!$pembayaran) {
            return response()->json(['error' => 'Pembayaran tidak ditemukan'], 404);
        }

        // Jika status sudah selesai, tidak perlu kirim notifikasi lagi
        if ($pembayaran->payment_status === 'paid') {
            return response()->json(['message' => 'Pesanan ini sudah Di Bayar'], 200);
        }

        // Update status peminjaman menjadi selesai
        $pembayaran->payment_status = 'paid';
        $pembayaran->save();

        // Kirim notifikasi ke user jika status sebelumnya belum selesai
        $user = User::find($pembayaran->id_user);
        
        if ($user) {
            $user->notify(new PaymentSuccess($pembayaran));
        } else {
            // Tangani jika pengguna tidak ditemukan
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Status Pembayaran Lunas dan notifikasi telah dikirim'], 200);
    }
    public function detailPembayaran($id)
    {
        $bkuser = bkuser::find($id);
        $transaction = ItemTransaction::where('id_booking', $id)->first();

        if (!$bkuser) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('content.detailpembayaran.detail', compact('bkuser','transaction'));
    }


        
    public function store(Request $request)
    {
        $request->validate([
            'id_mobil' => 'required|exists:mobils,id',
            'message' => 'required|integer|min:1|max:5',
        ]);

        // Simpan rating ke dalam tabel message_rating
        MessageRating::create([
            'id_mobil' => $request->id_mobil,
            'message' => $request->rating,
            // Tambah kolom lain jika ada, misal user_id jika perlu
        ]);

        return redirect()->back()->with('success', 'Rating telah diberikan.');
    }
    public function show($id)
    {
        // \Log::info("Detail booking accessed for ID: " . $id); // Log untuk debugging
        $booking = bkuser::find($id);
        
        if (!$booking) {
            // \Log::warning("Booking not found for ID: " . $id); // Log jika booking tidak ditemukan
            abort(404);
        }

        // \Log::info("Booking found: " . json_encode($booking)); // Log booking yang ditemukan
        return view('content.pesan.show', compact('booking'));
    }
    public function search(Request $request)
    {
        // Validasi inputan id
        $noPlat = $request->input('id'); // Lo ganti jadi no_plat, karena ID di form itu adalah no plat
        $booking = bkuser::where('id', $noPlat)->first(); // cari booking berdasarkan ID

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
    $services = bkuser::where('pembatalan', 'Terverifikasi')->paginate(5);

    // Array untuk menyimpan jumlah pemesanan per no_plat yang perlu di-service
    $mobilForService = [];

    // Loop untuk menghitung durasi berdasarkan no_plat dan booking date range
    foreach ($services as $booking) {
        // Pastikan booking_start dan booking_end menjadi objek Carbon
        $bookingStart = Carbon::parse($booking->booking_start);
        $bookingEnd = Carbon::parse($booking->booking_end);

        // Menghitung jumlah hari antara booking_end dan booking_start
        $duration = $bookingEnd->diffInDays($bookingStart);

        // Jika durasi pemesanan lebih dari 30 hari, anggap mobil perlu di-service
        if ($duration > 30) {
            // Menghitung berapa kali mobil tersebut sudah dipakai untuk pemesanan lebih dari 30 hari
            $mobilForService[$booking->no_plat] = ($mobilForService[$booking->no_plat] ?? 0) + 1;
        }
    }
    $user = User::count();
    $userT = Auth::user();
    $pesanan = bkuser::where('pembatalan', 'Dipesan')->count();
    $report = bkuser::where('pembatalan', 'Terverifikasi')->paginate(5);
    $syarat = SyaratS::first();
    $motor = Mobil::count();
    $kendaraan = Mobil::latest()->take(6)->get();
    $agent = new Agent();
    $isMobile = $agent->isMobile();

        // Ambil data booking berdasarkan id
        $booking = bkuser::find($request->id);

        // Cek kalau data booking ditemukan
        if ($booking) {
            $report = bkuser::where('id', $noPlat)->paginate(10);
            // Kalau ada, return ke view dengan data booking
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
                'duration' => $duration,
                'booking' => $booking
            ]);
        } else {
            // Kalau gak ada, kasih notifikasi error atau redirect
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }
    }

}
