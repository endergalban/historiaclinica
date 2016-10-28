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
        @if (session('status'))
            {{ session('status') }}
        @endif

        @if ($errors->has('email'))
            {{ $errors->first('email') }}
        @else

            Ingresa tu email para restablecer tu password
        @endif
        </p>
        <form class="form" role="form" method="POST" action="{{ url('/password/email') }}">
        
        {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
         
          <div class="row">
            
            <!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
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
