<?php

namespace App\Http\Controllers\Auth;

use App\Otp_code;
use App\User;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
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
            'otp' => ['string', 'required'],
        ]);


        $now = Carbon::now('Asia/Jakarta');
        $otp_code = Otp_code::where('code', $request->otp)->first();

        if(!$otp_code){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Kode OTP salah/tidak ditemukan'
            ], 200);
        }else if($now > $otp_code->valid_until){
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Kode otp sudah tdak berlaku, silahkan generate ulang'
            ], 200);
        }else {
            //update user
            $user = User::find($otp_code->user_id);
            $user->email_verified_at = $now;
            $user->save();

            //delete otp
            $otp_code->delete();

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Berhasil diverifikasi',
                'user' => $user 
            ], 200);
        
        }


        //delete otp
        // $otp_code->delete();

    }
}
