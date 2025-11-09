<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\FavoriteSongs;

class UserController extends Controller
{

    public function index($id)
    {
        $user = User::select('name')->findOrFail($id);
        $isUserProfile = Auth::id() == $id;
        
        $songs = FavoriteSongs::select('song_id', 'name', 'artists', 'img')
            ->where('user_id', '=', $id)
            ->get();

        return view('user', compact('user', 'isUserProfile', 'songs'));
    }

    public function show($id)
    {
       //
    }

    public function store(Request $request)
    {
        //
    }
}
