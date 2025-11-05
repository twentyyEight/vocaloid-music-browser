<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->input('data');
        $type = array_pop($data);

        switch ($type) {
            case 'song':
                $favs = json_decode($user->favorite_songs, true) ?? [];
                $favs[] = $data;
                $user->favorite_songs = json_encode($favs);
                break;

            case 'artist':
                $favs = json_decode($user->favorite_artists, true) ?? [];
                $favs[] = $data;
                $user->favorite_artists = json_encode($favs);
                break;

            case 'album':
                $favs = json_decode($user->favorite_albums, true) ?? [];
                $favs[] = $data;
                $user->favorite_albums = json_encode($favs);
                break;
            
            default:
            return;
        }

        $user->save();

        return response()->json(['ok' => true]);
    }
}
