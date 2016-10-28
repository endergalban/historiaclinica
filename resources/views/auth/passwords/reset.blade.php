@extends('layouts.app')

@section('body')

<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/"><b>Reset Password</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">
        @if ($errors->has('email'))
            {{ $errors->first('email') }}
        @endif

        @if ($errors->has('password'))
            {{ $errors->first('password') }}
        @endif

        @if ($errors->has('password_confirmation'))
            {{ $errors->first('password_confirmation') }}
        @endif
        </p>
        <form class="form" role="form" method="POST" action="{{ url('/password/reset') }}">
        {{ csrf_field() }}

         <input type="hidden" name="token" value="{{ $token }}">


          <div class="form-group has-feedback">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email"  value="{{ $email or old('email') }}" >
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>

           <div class="form-group has-feedback">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"  value="" >
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          </div>

           <div class="form-group has-feedback">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Password Confirmación"  value="" >
            <span class="glyphicon glyphicon-asterisk form-control-feedback"></span>
          </div>
         
          <div class="row">
            
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Actualizar</button>
            </div>
            <!-- /.col -->
          </div>
 
        </form>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
</body>
@endsection
