<?php

namespace App\Http\Controllers\Auth;

use App\Otp_code;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdatepasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        request()->validate([
            'email' => ['email', 'required'],
            'password' => ['string', 'required'],
            'password_confirmation' => ['string', 'same:password']
        ]);
        

        $user = User::where('email', request('email'))->first();

        //update password
        $user->password = bcrypt(request('password'));
        $user->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Password Berhasil Diubah',
            'user' => $user 
        ]);
    }
}
