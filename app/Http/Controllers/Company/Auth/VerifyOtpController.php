<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class VerifyOtpController extends Controller
{
    public function __construct()
    {
        $this->middleware(['company']);
    }
    public function showOtpPage(){
        return view('auth.verifyOtpCompany');
    }

    public function verifyOtp(Request $request){
        $request->validate([
            'otp' => 'required | max:6'
        ]);
        $opt_var = 'company_otp_'.Auth::guard('company')->user()->id;
        if ($request->otp == Cache::get("'.$opt_var.'")){
            $data =[
                'verified' => 1,
                'email_verified_at'=>date('Y-m-d H:i:s')
            ];
            $result = DB::table('companies')->where('id', Auth::guard('company')->user()->id)->update($data);
            if ($result){
                return redirect('/company-home');
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
        Auth::guard('company')->user()->sendOtp();
        flash(__('New OTP has been sent.'))->success();
        return redirect()->back();
    }
}
