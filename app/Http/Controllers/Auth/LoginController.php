<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Otp_code;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required']
        ]);

        $user = User::where('email', request('email'))->first();

        if (!$token = auth()->attempt($request->only('email', 'password'))){
            return response(null, 401);
        
        }else if ($user->email_verified_at == null){
            return response()->json([
                'response_code' => '00',
                'response_message' => 'Silahkan verifikasi email'
            ]);
        }

        return response()->json([
            'response_code' => '00',
            'response_message' => 'User Berhasil Login',
            'token' => $token,
            'user' => $user
        ]);
    }
}
