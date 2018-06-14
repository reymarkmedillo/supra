<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TierApp | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="../../dist/css/font.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="{{env('APP_URL')}}"><b>TIER</b>APP</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{route('postSignIn')}}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      @if(isset($api_errors))
        @foreach($api_errors as $key => $error)
          @if(is_array($error))
            @foreach($error as $msg)
            <div class="form-group has-error">
              <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $msg }}</label>
            </div>
            @endforeach
          @endif
        @endforeach
      @endif
      <div class="form-group has-feedback {!! ($errors->has('email'))?'has-error':'' !!}">
        <input type="email" name="email" class="form-control" value="{{ old('email')}}" placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if($errors->has('email'))
          @foreach($errors->get('email') as $message)
          <span class="help-block">{{$message}}</span>
          @endforeach
        @endif
      </div>
      <div class="form-group has-feedback {!! ($errors->has('password'))?'has-error':'' !!}">
        <input type="password" name="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
          <span class="help-block">{{$message}}</span>
          @endforeach
        @endif
      </div>
      <div class="row">
        <div class="col-xs-5">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <div class="col-xs-7">
          <a class="pull-right" href="{{route('getForgotPassword')}}">Forgot Password?</a>
        </div>
      </div>
    </form>

    

  </div>
  <!-- /.login-box-body -->
</div>
</body>
</html>
