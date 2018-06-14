@extends('master')
@section('content')
<!-- Select2 -->
<link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
<script src="{{url('/')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
        <h3 class="box-title">Select Main Category</h3>
        </div>
        <form id="frmEditCategory" role="form" method="post" action="{{route('postCategoryTree')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="action" value="{{isset($_GET['action'])?$_GET['action']:null}}">
        <div class="box-body">
            <div class="col-md-12">
                <label for="case_title">Search Category</label>
                <div class="form-group">
                <select class="form-control select2" name="cat_search" id="cat_search" required></select>
                </div>
            </div>
        </div>
        
        <div class="box-footer">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success btn-flat margin">View Tree</button>
            </div>
        </div>
        </form>
    </div>
</section>
<script>
$( document ).ready(function() {
    setCategorylist();
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