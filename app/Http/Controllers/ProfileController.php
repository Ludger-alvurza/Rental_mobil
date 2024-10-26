<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id){
        $user = User::findOrFail($id);
        return view('content.profile.index', compact('user'));
    }
}
