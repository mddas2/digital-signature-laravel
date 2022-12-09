<?php //phpinfo(); dd("here");?>
@extends('layouts.login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" id="userLogin">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div><br>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                Don't have an account ?
                               <a href="{{route('register')}}" class="btn btn-link"> Sign Up  </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
    $(document).ready(function(){
        var uniqueId = '';
        $('#userLogin').click(function(e) {
            // alert('here');
            e.preventDefault();
            startConnection();
            var email = $('#email').val();
            var password = $('#password').val();
            $.ajax({
                url : "{{ URL::to('user/login')}}",
                type : 'post',
                data : {
                    email : email,
                    password : password
                },
                success : function (message) {
                    console.log(message);
                    if (message == "up_error") {
                        alert('ok');
                    } else if (message == "inactive"){
                        alert('inactive');
                        $('#loginForm').submit();
                    } else {
                        alert('force to login');
                        $('#loginForm').submit();
                        uniqueId = message['unique_id'];
                        checkUserExists(message['unique_id']);
                    }
                }
            });
        });

        function checkUserExists() {
            $.ajax({
                type : 'POST',
                url : "<?php echo URL::to("ds/checkUserExistsOrNot");?>",
                async : false,
                data : {
                    unique_id : uniqueId
                },
                success : function(response) {
                    console.log(response)
                    if (response == "pending") {
                        alert('Your account is not verified till now, wait until verify');
                    } else if(response == "success") {
                       generateRandomNo(uniqueId,channelId,gemRandomNoUrl,checkRandomNo);
                    }
                }
            });
        }

        function checkRandomNo(randomNo)
        {
            if (randomNo[0] == 'success') {
                getSignature(uniqueId,successCallBackForAuthentication,randomNo[1]);
            } else {
                alert('error');
            }
        }

        function successCallBackForAuthentication(respData)
        {
            var sigLast = respData.indexOf("CommonName");
            var sig = respData.substring(10,sigLast);
            var str = new String(sig);
            $.ajax({
                url : "<?php echo URL::to("ds/authentication");?>",
                type : 'POST',
                data : {
                    signature : sig,
                    unique_id : uniqueId
                },
                success : function (data) {
                    console.log(data);
                    if (data == "error") {
                        alert("Your account is not verified.")
                    } else if (data == "success") {
                        alert("Verified User");
                        $('#loginForm').submit();
                    }
                }
            });
        }
    });
</script>
@endsection
