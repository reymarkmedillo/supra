@extends('master')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="../../dist/img/avatar04.png" alt="User profile picture">

                    <h3 class="profile-username text-center">{{session()->get('user')->first_name}} &nbsp; {{session()->get('user')->last_name}}</h3>

                    <p class="text-muted text-center">{{session()->get('user')->role}}</p>
                    <form method="post" action=" {{route('updateProfile')}} ">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>First Name</b> <input type="text" name="first_name" value="{{session()->get('user')->first_name}}" class="form-control" required>
                        </li>
                        <li class="list-group-item">
                            <b>Last Name</b> <input type="text" name="last_name" value="{{session()->get('user')->last_name}}" class="form-control" required>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <input type="email" name="email" value="{{session()->get('user')->email}}" class="form-control" required>
                        </li>
                        <li class="list-group-item">
                            <b>Address</b> <textarea style="resize: none;" rows="5" name="address" class="form-control" required>{{session()->get('user')->address}}</textarea>
                        </li>
                    </ul>

                    <button type="submit" class="btn btn-primary btn-block"><b>Update Profile</b></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</section>
@endsection
