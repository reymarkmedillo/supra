<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TierApp | Change Password</title>
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
    <p class="login-box-msg">Change your password to proceed.</p>

    <form action="{{route('postForgotPasswordToken', ['token' => $forgot_token])}}" method="post">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group has-feedback {!! ($errors->has('password'))?'has-error':'' !!}">
        <input type="password" name="password" class="form-control" placeholder="Enter New Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if($errors->has('password'))
          @foreach($errors->get('password') as $message)
          <span class="help-block">{{$message}}</span>
          @endforeach
        @endif
      </div>
      <div class="form-group has-feedback {!! ($errors->has('password_confirmation'))?'has-error':'' !!}">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Retype New Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        @if($errors->has('password_confirmation'))
          @foreach($errors->get('password_confirmation') as $message)
          <span class="help-block">{{$message}}</span>
          @endforeach
        @endif
      </div>
      <div class="row">
        <div class="col-xs-7">
          <button type="submit" class="btn btn-danger btn-block btn-flat">Change Password</button>
        </div>
      </div>
    </form>

    

  </div>
  <!-- /.login-box-body -->
</div>
</body>
</html>
