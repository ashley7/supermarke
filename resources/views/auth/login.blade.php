@extends('layouts.login_master')
@section('content')
<div class="account-bg">   
    <div class="card-box m-b-0">
        <div class="text-xs-center m-t-20">
            <a href="/" class="logo">                
                <span class="text-danger">Point of Sale system</span>
            </a>

            <img src="{{asset('images/logo.png')}}" width="100px">
        </div>
        
       
        <div class="m-t-30 m-b-20">
            <div class="col-xs-12 text-xs-center">
                <h6 class="text-muted text-uppercase m-b-0 m-t-0">Sign In</h6>
            </div>

            <form class="form-horizontal m-t-20"  method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group ">
                    <div class="col-xs-12">
                       <label>Username</label>
                       <input id="email" type="text" class="form-control" name="phone_number" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

       

                <div class="form-group text-center m-t-30">
                    <div class="col-xs-12">
                        <button class="btn btn-danger btn-block waves-effect waves-light" id="login_btn" type="submit">Log In</button>
                    </div>

                    <a id="refresh" style="text-align: center;"  href="">Refresh</a>
                </div>

                      

            </form>

        </div>
    </div>
</div>
@endsection

