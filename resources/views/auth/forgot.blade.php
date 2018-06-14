<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TierApp | Forgot Password</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
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
  <div class="login-box-body">
    <p class="login-box-msg">Forgot Password</p>

    @foreach($errors->all() as $error)
      <p class="text-red"> <i class="fa fa-times-circle-o"></i> {{$error}}</p>
    @endforeach
    @if(isset($message))
    <p class="text-green"> <i class="fa fa-check-circle-o"></i> {{$message}}</p>
    @endif

    <form class="form-horizontal" method="post" action=" {{route('postForgotPassword')}} ">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-group {!! ($errors->has('email')) ? 'has-error' : '' !!} margin-bottom-none">
        <div class="col-sm-9">
          <input class="form-control input-sm" name="email" placeholder="Please enter your email" value="{{ old('email')}}">
        </div>
        <div class="col-sm-3">
          <button type="submit" class="btn btn-danger pull-right btn-block btn-sm">Send</button>
        </div>
      </div>
    </form>
  </div>
</div>
</body>
</html>
