@extends('master')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <form id="frmAddUser">
            <input type="hidden" value="{{csrf_token()}}" name="_token">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add New User</h3>
                @if($errors->any())
                    @foreach($errors->all() as $error)
                    <p class="text-red">{{$error}}</p>
                    @endforeach
                @endif
                <div id="errors"></div>
                <div id="message"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control" onchange="getUserFunction()" required>
                            <option value=""></option>
                            @foreach(config('define.user_roles') as $key => $value)
                            <option value=" {{$key}} "> {{$value}} </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="col-md-4" >
                        <label>&nbsp;</label>
                        <div class="form-group">
                            <div class="checkbox" id="role_function">
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="address">Address</label>
                        <textarea style="resize: none;" rows="5" name="address" id="address" class="form-control" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control" required>
                            <option value=""></option>
                            @foreach(config('define.payment_methods') as $key => $value)
                            <option value=" {{$key}} "> {{$value}} </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                        <label for="auth_type">Auth Type</label>
                        <select name="auth_type" id="auth_type" class="form-control" required>
                            <option value=""></option>
                            @foreach(config('define.auth_types') as $key => $value)
                            <option value=" {{$key}} "> {{$value}} </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                <button type="button" class="btn btn-primary" onclick="addUser();" id="btnAddUser">Add User &nbsp; <i style="display:none;" id="loader" class="fa fa-refresh fa-spin"></i></button>
                </div>
            </div>
            <!-- /.box-footer -->
            </div>
            </form>
        </div>

      <div class="col-md-3"></div>
    </div>
</section>
<script>
    function getUserFunction() {
        var user_functions= <?php echo json_encode(config('define.user_functions')); ?>;
        var role = $.trim($("#role").val()).replace(' ', '+');
        var html = "";
        if(user_functions[role]) {
            var user_func = user_functions[role];
            for (let index = 0; index < user_func.length; index++) {
                const func = user_func[index];
                html += "<label><input type='checkbox' name='user_function' id='user_function' value='"+func+"'>"+func+"</label>";
            }
            $('#role_function').empty();
            $('#role_function').append(html);
        } else {
            $('#role_function').empty();
        }

        $("#user_function").on('change', function() {
          if ($(this).is(':checked')) {
            html = "<input type='hidden' name='user_role_function' id='user_role_function' value='"+$(this).val()+"'>"
            $('#role_function').append(html);
          } else {
            $('#user_role_function').remove();
          }
          
        });
    }

    function addUser() {
        $( document ).ready(function() {
            $('#errors,#message').empty();
            $('#btnAddUser').prop('disabled',true);
            $('#loader').show();
            var frm_data = {
                _token: $("input[name='_token']").val(),
                email: $("input[name='email']").val(),
                role: ($("select#role option").filter(":selected").val()).trim(),
                first_name: $("input[name='first_name']").val(),
                last_name: $("input[name='last_name']").val(),
                address: $("#address").val(),
                payment_method: ($("select#payment_method option").filter(":selected").val()).trim(),
                auth_type: ($("select#auth_type option").filter(":selected").val()).trim(),
                user_role_function: $("#user_role_function").val()
            };
            $.ajax({
              type: 'POST',
              data: frm_data,
              url: "{{route('postAddUser')}}",
              success: function(res) {
                html="";
                if(res.error) {
                    var errors = res.error;
                    for (const key in errors) {
                        if (errors.hasOwnProperty(key)) {
                          const e = errors[key];
                          for (const field in e) {
                            if (e.hasOwnProperty(field)) {
                              const field_errors = e[field];
                                html+='<p class="text-red">'+field_errors+'</p>';
                            }
                          }
                        }
                    }
                    $('#errors').append(html);
                } else {
                    html+='<p class="text-green"> Successfully added user. </p>';
                    $('#message').append(html);
                    $("#frmAddUser").trigger('reset');
                    $('#role_function').empty();
                }
                $('#btnAddUser').prop('disabled',false);
                $('#loader').hide();
                $(window).scrollTop(0);
              }, 
              error: function(err,msg) {
                $('#btnAddUser').prop('disabled',false);
                $('#loader').hide();
                $(window).scrollTop(0);
                html="";
                var errors = JSON.parse(err.responseText);
                for (const key in errors) {
                    if (errors.hasOwnProperty(key)) {
                      const e = errors[key];
                      for (const field in e) {
                        if (e.hasOwnProperty(field)) {
                          const field_errors = e[field];
                          for(var i=0;i<field_errors.length;i++) {
                            html+='<p class="text-red">'+field_errors[i]+'</p>';
                          }
                        }
                      }
                    }
                }
                $('#errors').append(html);
              }
            });
        });
    }
</script>

@endsection
