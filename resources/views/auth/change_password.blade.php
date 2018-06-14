@extends('master')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form method="post" action=" {{route('postChangePassword')}} ">
            <input type="hidden" value="{{csrf_token()}}" name="_token">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add New User</h3>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                    <p class="text-red">{{$error}}</p>
                    @endforeach
                @endif
                @if(isset($message) && $message != '')
                    <p class="text-green">{{$message}}</p>
                @endif

            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{session()->get('user')->email}}" readonly required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="password">Current Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="new_password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    </div>
                </div>



            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </div>
            <!-- /.box-footer -->
            </div>
            </form>
        </div>

      <div class="col-md-3"></div>
    </div>
</section>
@endsection
