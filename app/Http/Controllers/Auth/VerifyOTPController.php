<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VerifyOTPController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function showOtpPage(){
        return view('auth.verifyOtp');
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required | max:6'
        ]);
        $opt_var = 'candidate_otp_'.auth()->user()->id;
        if ($request->otp == Cache::get("'.$opt_var.'")){
            $data =[
                'verified' => 1,
                'email_verified_at'=>date('Y-m-d H:i:s')
            ];
            $result = DB::table('users')->where('id', auth()->user()->id)->update($data);
            if ($result){
                return redirect('/home');
            }
            else{
                flash(__('OTP Verification failed.'))->error();
                return redirect()->back();
            }

        }
        else{
            flash(__('Invalid or expired OTP.'))->error();
            return redirect()->back();
        }
    }

    public function resendOtp(){
        auth()->user()->sendOtp();
        flash(__('New OTP has been sent.'))->success();
        return redirect()->back();
    }
}
