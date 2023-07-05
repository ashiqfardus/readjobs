@extends('layouts.app')

@section('content')

    <!-- Header start -->

    @include('includes.header')

    <!-- Header end -->

    <!-- Inner Page Title start -->

    @include('includes.inner_page_title', ['page_title'=>__('Register')])

    <!-- Inner Page Title end -->

    <div class="listpgWraper">

        <div class="container">

            <div class="useraccountwrap">

                <div class="userccount">

                    <div class="userbtns">

                        <ul class="nav nav-tabs">
                            <?php
                                $c_or_e = old('candidate_or_employer', 'candidate');
                            ?>

                            <li class="nav-item">
                                <a class="nav-link {{($c_or_e == 'candidate')? 'active':''}}" data-toggle="tab" href="#candidate" aria-expanded="true">{{__('Candidate')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{($c_or_e == 'employer')? 'active':''}}" data-toggle="tab" href="#employer" aria-expanded="false">{{__('Employer')}}</a>
                            </li>

                        </ul>

                    </div>

                    <div class="tab-content">

                        <div id="candidate" class="formpanel tab-pane {{($c_or_e == 'candidate')? 'active':''}}">

                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">

                                {{ csrf_field() }}

                                <input type="hidden" name="candidate_or_employer" value="candidate"/>

                                <div class="formrow{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <input type="text" name="first_name" class="form-control" required="required"
                                           placeholder="{{__('First Name')}}" value="{{old('first_name')}}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block"> <strong>{{ $errors->first('first_name') }}</strong> </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('middle_name') ? ' has-error' : '' }}">
                                    <input type="text" name="middle_name" class="form-control"
                                           placeholder="{{__('Middle Name')}}" value="{{old('middle_name')}}">
                                    @if ($errors->has('middle_name'))
                                        <span class="help-block"> <strong>{{ $errors->first('middle_name') }}</strong> </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('last_name') ? ' has-error' : '' }}">

                                    <input type="text" name="last_name" class="form-control" required="required"
                                           placeholder="{{__('Last Name')}}" value="{{old('last_name')}}">

                                    @if ($errors->has('last_name'))
                                        <span class="help-block"> <strong>{{ $errors->first('last_name') }}</strong> </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <input type="email" name="email" class="form-control" required="required"
                                           placeholder="{{__('Email')}}" value="{{old('email')}}">

                                    @if ($errors->has('email'))
                                        <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <select class="form-control" name="country" id="country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $key=>$country)
                                            <option value="{{$key}}">{{$country}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('country'))
                                        <span class="help-block"> <strong>{{ $errors->first('country') }}</strong> </span>
                                    @endif
                                </div>
                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
                                    <label for="">{{__('Phone')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="country_code"></span>
                                        </div>
                                        <input type="hidden" name="country_code" id="country_code_for_phone">
                                        {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Phone'))) !!}
                                    </div>
                                    {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                                </div>

                                <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required="required" placeholder="{{__('Password')}}" value="">
                                    <p style="font-size: 11px; text-align: left;">At-least one upper case, one lower case, one numeric and special character.</p>

                                    @if ($errors->has('password'))
                                        <span class="help-block"> <strong>{{ $errors->first('password') }}</strong> </span>
                                    @endif
                                </div>

                                <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <input type="password" name="password_confirmation" class="form-control"
                                           required="required" placeholder="{{__('Password Confirmation')}}" value="">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block"> <strong>{{ $errors->first('password_confirmation') }}</strong> </span>
                                    @endif </div>


                                <div class="formrow{{ $errors->has('is_subscribed') ? ' has-error' : '' }}">

                                        <?php

                                        $is_checked = '';

                                        if (old('is_subscribed', 1)) {

                                            $is_checked = 'checked="checked"';

                                        }

                                        ?>


                                    <input type="checkbox" value="1" name="is_subscribed" {{$is_checked}} />
                                    {{__('Subscribe to Newsletter')}}

                                    @if ($errors->has('is_subscribed'))
                                        <span class="help-block"> <strong>{{ $errors->first('is_subscribed') }}</strong> </span>
                                    @endif </div>


                                <div class="formrow{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">

                                    <input type="checkbox" value="1" name="terms_of_use"/>

                                    <a href="{{url('cms/terms-of-use')}}">{{__('I accept Terms of Use')}}</a>


                                    @if ($errors->has('terms_of_use'))
                                        <span class="help-block"> <strong>{{ $errors->first('terms_of_use') }}</strong> </span>
                                    @endif </div>

                                <div class="form-group col-12 col-sm-12 col-md-10 text-center mx-auto mobile-padding-no {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! app('captcha')->display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong> </span>
                                    @endif
                                </div>

                                <input type="submit" class="btn" value="{{__('Register')}}">

                            </form>

                        </div>

                        <div id="employer" class="formpanel tab-pane fade {{($c_or_e == 'employer')? 'active':''}}">

                            <form class="form-horizontal" method="POST" action="{{ route('company.register') }}">

                                {{ csrf_field() }}

                                <input type="hidden" name="candidate_or_employer" value="employer"/>

                                <div class="formrow{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <input type="text" name="name" class="form-control" required="required"
                                           placeholder="{{__('Name')}}" value="{{old('name')}}">

                                    @if ($errors->has('name'))
                                        <span class="help-block"> <strong>{{ $errors->first('name') }}</strong> </span>
                                    @endif </div>

                                <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <input type="email" name="email" class="form-control" required="required"
                                           placeholder="{{__('Email')}}" value="{{old('email')}}">

                                    @if ($errors->has('email'))
                                        <span class="help-block"> <strong>{{ $errors->first('email') }}</strong> </span>
                                    @endif </div>

                                <div class="formrow{{ $errors->has('company_country') ? ' has-error' : '' }}">
                                    <select class="form-control" name="company_country" id="company_country">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $key=>$country)
                                            <option value="{{$key}}">{{$country}}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('company_country'))
                                        <span class="help-block"> <strong>{{ $errors->first('company_country') }}</strong> </span>
                                    @endif
                                </div>
                                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
                                    <label for="">{{__('Phone')}}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="company_country_code"></span>
                                        </div>
                                        <input type="hidden" name="company_country_code" id="company_country_code_for_phone">
                                        {!! Form::text('company_phone', null, array('class'=>'form-control', 'id'=>'company_phone', 'placeholder'=>__('Phone'))) !!}
                                    </div>
                                    {!! APFrmErrHelp::showErrors($errors, 'company_phone') !!}
                                </div>

                                <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <input type="password" name="password" class="form-control" required="required"
                                           placeholder="{{__('Password')}}" value="">
                                    <p style="font-size: 11px; text-align: left;">At-least one upper case, one lower case, one numeric and special character.</p>
                                    @if ($errors->has('password'))
                                        <span class="help-block"> <strong>{{ $errors->first('password') }}</strong> </span>
                                    @endif </div>

                                <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <input type="password" name="password_confirmation" class="form-control"
                                           required="required" placeholder="{{__('Password Confirmation')}}" value="">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block"> <strong>{{ $errors->first('password_confirmation') }}</strong> </span>
                                    @endif </div>

                                <div class="formrow{{ $errors->has('is_subscribed') ? ' has-error' : '' }}">

                                        <?php

                                        $is_checked = '';

                                        if (old('is_subscribed', 1)) {

                                            $is_checked = 'checked="checked"';

                                        }

                                        ?>


                                    <input type="checkbox" value="1" name="is_subscribed" {{$is_checked}} />
                                    {{__('Subscribe to Newsletter')}}

                                    @if ($errors->has('is_subscribed'))
                                        <span class="help-block"> <strong>{{ $errors->first('is_subscribed') }}</strong> </span>
                                    @endif </div>


                                <div class="formrow{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">

                                    <input type="checkbox" value="1" name="terms_of_use"/>

                                    <a href="{{url('terms-of-use')}}">{{__('I accept Terms of Use')}}</a>


                                    @if ($errors->has('terms_of_use'))
                                        <span class="help-block"> <strong>{{ $errors->first('terms_of_use') }}</strong> </span>
                                    @endif </div>

                                <div
                                        class="form-group col-12 col-sm-12 col-md-10 text-center mx-auto mobile-padding-no {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    {!! app('captcha')->display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong> </span>
                                    @endif
                                </div>

                                <input type="submit" class="btn" value="{{__('Register')}}">

                            </form>

                        </div>

                    </div>

                    <!-- sign up form -->

                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('Have Account')}}? <a
                                href="{{route('login')}}">{{__('Sign in')}}</a></div>

                    <!-- sign up form end-->


                </div>

            </div>


        </div>

    </div>

    @include('includes.footer')

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function () {
                $('#country').on('change', function (e) {
                    e.preventDefault();
                    getCountryCode();
                });

                $('#company_country').on('change', function (e) {
                    e.preventDefault();
                    getCountryCodeCompany();
                });
            });

            function getCountryCode(){
                var country_id = $('#country').val();

                if (country_id != '') {
                    $.post("{{ route('filter.country.code') }}", {country_id: country_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                        .done(function (response) {
                            $('#country_code').text(response);
                            $('#country_code_for_phone').val(response);
                        });
                }
            }
            function getCountryCodeCompany(){
                var country_id = $('#company_country').val();

                if (country_id != '') {
                    $.post("{{ route('filter.country.code') }}", {country_id: country_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                        .done(function (response) {
                            $('#company_country_code').text(response);
                            $('#company_country_code_for_phone').val(response);
                        });
                }
            }
        </script>
    @endpush

@endsection
