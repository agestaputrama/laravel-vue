<?php

namespace App\Http\Controllers\Auth;

use App\Otp_code;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
         $otp = Otp_code::where('user_id', $user->id)->first();
         $otp->code = rand(100000, 999999);
         $otp->valid_until = Carbon::now('Asia/Jakarta')->addMinute(5);
         $otp->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silahkan Cek Email',
            'user' => $user 
        ]);
      }
    }
}
