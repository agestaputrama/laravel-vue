<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\UserRegisteredEvent;

class RegenerateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required']
        ]);

        $user = User::where('email', request('email'))->first();

        if(!$user){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Email salah/tidak ditemukan'
            ]);
        }else{
         //update otp_code
         $user->generate_otp_code();
         event(new UserRegisteredEvent($user));

        //  $otp = Otp_code::where('user_id', $user->id)->first();
        //  $otp->code = rand(100000, 999999);
        //  $otp->valid_until = Carbon::now('Asia/Jakarta')->addMinute(5);
        //  $otp->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Otp berhasil digenerate. Silahkan Cek Email',
            'user' => $user 
        ]);
      }
    }
}
