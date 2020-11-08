<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getProfil(Request $request)
    {
        return response()->json([
            'response_code' => '00',
            'response_message' => 'Profil berhasil ditampilkan',
            'user' => $request->user()
        ]);
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'photo' => ['required']
        ]);

        $id = Auth::user()->id;
        $fileName = $id.".jpg";
        $path = $request->file('photo')->move(public_path("\photos\users\photo-profile"), $fileName);
        $photoURL = url('/'.$fileName);

        //update data profil
        $user = User::find($id);
        $user->name = request('name');
        $user->photo = $path;
        $user->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Profil berhasil diupdate',
            'user' => $user,
            'url' => $photoURL
        ], 200);
    }
}
