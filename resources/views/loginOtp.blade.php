@component('mail::message')

    Welcome to Readjobs.

    Your Login OTP is : {{$otp}}

    Thanks for joining with us.
    {{ config('app.name') }}
@endcomponent