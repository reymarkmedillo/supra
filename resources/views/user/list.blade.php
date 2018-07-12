@extends('master')
@section('content')
<!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<section class="content">
<div class="box">
    <div class="box-header">
      <h3 class="box-title">List of All Draft Cases</h3>
        <div class="box-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
                &nbsp;
                @if( userManagerRoles() )
                <div class="input-group-btn">
                    <button type="button" class="btn btn-success" onclick="location.href='/users/add'">Add User</button>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="box-body">
        <table id="userList" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Authentication</th>
                <th>Cases</th>
                @if( userManagerRoles() )
                <th>Action</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->role}}</td>
                <td>{{$user->auth_type}}</td>
                <td>
                    <span class="label label-success">{{$user->approve}} Approved</span>
                    <span class="label label-warning">{{$user->pending}} Pending</span>
                    <span class="label label-danger">{{$user->disapprove}} Disapproved</span>
                </td>
                @if( userManagerRoles() )
                <td>
                    <span style="cursor: pointer;" class="label label-info" onclick='window.location.href="{{route('getEditUser', ['user_id'=> $user->id])}}"'>Edit</span>
                    <span style="cursor: pointer;" class="label label-danger" onclick="deleteUser({{$user->id}});">Delete</span>
                </td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</section>
<script>
  $(function () {
    $('#userList').DataTable();
  });

  function deleteUser(userId) {
    var confirm_delete = confirm("Are you sure you want to delete?");
    if (confirm_delete == true) {
        $.ajax({
          type: 'GET',
          url: '/users/remove/'+userId,
          success: function(res) {
            if (res.result == 'success') {
                alert('Successfully deleted.');
                location.reload();
            } else {
                console.log('There is some problem with your request.');
            }
          },
          error: function(err) {
            alert('There is some problem with your request.');
            location.reload();
          }
        });
    }
  }
</script>
@endsection
