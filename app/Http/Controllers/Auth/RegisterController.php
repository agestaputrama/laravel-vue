<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\UserRegisteredEvent;

class RegisterController extends Controller
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
            'name' => ['string', 'required'],
            'email' => ['email', 'required', 'unique:users,email']
        ]);

        $user = User::create($request->all());

        //$user = User::where('email', request('email'))->first();

        //save otp_code
        // Otp_code::create([
        //     'user_id' => $user->id,
        //     'code' => rand(100000, 999999),
        //     'valid_until' => Carbon::now('Asia/Jakarta')->addMinute(5)
        // ]);

        event(new UserRegisteredEvent($user));

        return response()->json([
            'response_code' => '00',
            'response_message' => 'User berhasil di daftarkan, Silahkan Cek Email',
            'user' => $user 
        ]);
    }

}
