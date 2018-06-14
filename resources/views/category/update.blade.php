@extends('master')
@section('content')
<!-- Select2 -->
<link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
<script src="{{url('/')}}/bower_components/select2/dist/js/select2.full.min.js"></script>

<section class="content">
    <div class="box box-default">
        <div class="box-header with-border">
        <h3 class="box-title">Update Category</h3>
        </div>
        <form id="frmNewCategory" role="form" method="post" action="{{route('postUpdateCategory', ['category_id'=> $selectedCategory->id])}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
        @if(\Session::has('message'))
            <div class="col-md-12">
            <p class="text-green">{{session()->get('message')}}</p>
            </div>
        @endif
        @if($errors->any())
            <div class="col-md-12">
            @foreach($errors->all() as $error)
                <p class="text-red">{{$error}}</p>
            @endforeach
            </div>
        @endif
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_title">Search Parent</label>
                <select class="form-control select2" name="cat_parent" id="cat_parent"></select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_title">Enter Child Text</label>
                <input type="text" class="form-control" name="cat_child" id="cat_child" required value="{{old('cat_child')}}">
              </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success btn-flat" id="btnSaveCase">Save</button>
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
    var selectedCategory = <?php echo json_encode($selectedCategory); ?>;
    document.getElementById("cat_parent").insertBefore(new Option('', ''), document.getElementById("cat_parent").firstChild);
    $('#cat_parent').select2({
    data: <?php echo json_encode($categories); ?>,
    placeholder: "Please choose a category"
    });
    console.log(selectedCategory);
    $('#cat_parent').val(selectedCategory.parent_id).trigger('change');
    $('#cat_child').val(selectedCategory.name);
}

</script>
@endsection