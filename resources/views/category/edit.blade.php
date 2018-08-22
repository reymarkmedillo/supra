@extends('master')
@section('content')
<!-- Select2 -->
<link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
<script src="{{url('/')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
        <h3 class="box-title">Edit Category</h3>
        </div>

        <form id="frmEditCategory" role="form" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
        @if(\Session::has('message'))
            <div class="col-md-12">
            <p class="text-green">{{session()->get('message')}}</p>
            </div>
        @endif
            <div class="col-md-12">
                <label for="case_title">Search Category</label>
                <div class="form-group">
                <select class="form-control select2" name="cat_search" id="cat_search" required></select>
                </div>
            </div>
        </div>
        
        <div class="box-footer">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-info btn-flat margin" value="1" name="btnUpdateCase" id="btnUpdateCase">Update</button> 
                <button type="submit" class="btn btn-danger btn-flat margin" value="1" name="btnDeleteCase" id="btnDeleteCase">Delete</button>
            </div>
        </div>
        </form>
    </div>
</section>
<script>
$( document ).ready(function() {
    setCategorylist();
    $( "#btnDeleteCase" ).click(function( event ) {
        event.preventDefault();
        var confirmDelete = confirm("Proceed to delete?");
        if (confirmDelete == true && $('#cat_search').val()) {
            $.ajax({
              type: 'POST',
              data: {
                btnDeleteCase: 1,
                _token: $("input[name='_token']").val(),
                cat_search: $('#cat_search').val()
              },
              url: '/category/edit',
              success: function(res) {
                window.location.reload();
              },
              error: function(err,msg) {
                window.location.reload();
              }
            });
        }
    });
});

function setCategorylist() {
    document.getElementById("cat_search").insertBefore(new Option('', ''), document.getElementById("cat_search").firstChild);
    $('#cat_search').select2({
        data: <?php echo json_encode($categories); ?>,
        placeholder: "Please choose a category"
    });
}


</script>
@endsection