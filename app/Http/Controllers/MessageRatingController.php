<?php

namespace App\Http\Controllers;

use App\Models\MessageRating;
use App\Models\Mobil;
use App\Models\SyaratS;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MessageRatingController extends Controller
{
    /**
     * Display a listing of the message ratings.
     */
    public function index()
{
    $messageRatings = MessageRating::with('user')->get();
    $users = User::all(); // Ambil semua user
    return view('content.message.list', compact('messageRatings', 'users'));
}
public function message($id)
{
    $syarat = SyaratS::first();
    $mobil = Mobil::find($id);
 return view('layout-fe.review', compact('mobil','syarat'));
}


    /**
     * Show the form for creating a new message rating.
     */
    public function create()
{
    // Mengambil data users yang tersedia
    $users = User::all(); // Ambil data user dari database
    $mobil = Mobil::first();

    // Kirim data users ke view 'content.message.add'
    return view('content.message.add', compact('users','mobil'));
}


    /**
     * Store a newly created message rating in storage.
     */
    public function insert(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'message' => 'required|max:30',
        'rating' => 'required|integer|min:1|max:5', // Validasi rating
    ]);
    
    // Buat message rating baru
    $messageRating = new MessageRating();
    $messageRating->message = $request->message;
    $messageRating->id_mobil = $request->id_mobil;
    $messageRating->rating = $request->rating; // Simpan rating
    $messageRating->id = Auth::id(); // Ambil ID user yang sedang login
    $messageRating->save();
    

    // Tambahkan pesan keberhasilan ke sesi
    Session::flash('success', 'Message Rating berhasil ditambahkan.');

    return redirect()->route('dashboard.user');
}

    /**
     * Show the specified message rating.
     */
    public function tampil(MessageRating $messageRating, $id)
{
    $mobil = Mobil::find($id);
    if (!$mobil) {
        return redirect()->back()->with('error', 'Mobil tidak ditemukan.');
    }
    return view('content.message.add', compact('messageRating', 'mobil'));
}


    /**
     * Show the form for editing the specified message rating.
     */
    public function edit($id)
{
    $messageRating = MessageRating::findOrFail($id);
    $users = User::all(); // Ambil semua user
    return view('content.pesan.edit', compact('messageRating', 'users'));
}


    /**
     * Update the specified message rating in storage.
     */
    public function update(Request $request, MessageRating $messageRating)
{
    try {
        // Validasi input
        $validated = $request->validate([
            'message' => 'required|max:30',
            'user_id' => 'required|exists:users,id', // validasi user_id, bukan id
        ]);

        // Update message rating
        $messageRating->message = $request->message;
        $messageRating->user_id = $request->user_id; // gunakan user_id, bukan id
        $messageRating->save();

        // Tambahkan pesan keberhasilan ke sesi
        Session::flash('success', 'Data Message Rating berhasil diperbarui.');

        return redirect()->route('message_ratings.index');

    } catch (ModelNotFoundException $e) {
        Session::flash('error', 'Gagal Memperbarui data Message Rating. Data tidak ditemukan.');
        return redirect()->route('message_ratings.index');
    } catch (\Exception $e) {
        Session::flash('error', 'Terjadi kesalahan. Gagal memperbarui data Message Rating.');
        return redirect()->route('message_ratings.index');
    }
}



    /**
     * Remove the specified message rating from storage.
     */
    public function delete(Request $request)
    {
        $idMessage = $request->id;
        $message = MessageRating::find($idMessage);
        if ($message === null) {
            return response()->json([], 404);
        }
        $message->delete();
        return response()->json([], 200);
    }
}
