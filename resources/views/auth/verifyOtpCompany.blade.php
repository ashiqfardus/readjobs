@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
{{--    @include('includes.inner_page_title', ['page_title'=>__('Verify OTP')])--}}
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">


            <div class="useraccountwrap">
                <div class="userccount">
                    <div class="tab-content">
                        <div id="verifyOtp" class="formpanel">
                            <h4 class="text-center">Verify OTP</h4>
                            @include('flash::message')
                            <form class="form-horizontal" method="POST" action="{{route('verifyOtp.company')}}">
                                {{ csrf_field() }}
                                <div class="formpanel">
                                    <div class="formrow{{ $errors->has('otp') ? ' has-error' : '' }}">
                                        <input id="otp" type="number" class="form-control" name="otp" required autofocus placeholder="{{__('Enter your OTP here.')}}">
                                        @if ($errors->has('otp'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('otp') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="submit" class="btn" value="{{__('Submit')}}">
                                    <a href="{{route('resend.company')}}" class="btn btn-danger mt-3" style="background:red">Resend</a>
                                </div>
                                <!-- login form  end-->
                            </form>
                            <!-- sign up form -->
                        </div>
                    </div>
                    <!-- login form -->


                </div>
            </div>

        </div>
    </div>
    @include('includes.footer')
@endsection
