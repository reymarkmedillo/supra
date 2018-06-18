@extends('master')
@section('content')
<!-- Select2 -->
<link rel="stylesheet" href="{{url('/')}}/bower_components/select2/dist/css/select2.min.css">
<!-- Select2 -->
<script src="{{url('/')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
            <i class="fa fa-globe"></i> {{$main_category_name}}
            <small class="pull-right">{{date('m/d/Y')}}</small>
            </h2>
        </div>
        <!-- /.col -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12">
            <ol>
                @foreach($category_tree as $category)
                <li> {{$category->name}} &nbsp;&nbsp;&nbsp;
                    @if($rw)
                    <a href="#" class="text-muted no-print" data-toggle="modal" data-target="#caseModal" onclick="setButtonFunc('{{$category->id}}','{{$category->name}}');"><i class="fa fa-plus-square-o"></i></a>
                    @endif
                    <div id="{{$category->id}}"></div>
                    <!-- LEVEL 1 -->
                    @if(is_array($category->children) && count($category->children) > 1)
                    <ol>
                        @foreach($category->children as $subcategory1)
                        <li> {{$subcategory1->name}} &nbsp;&nbsp;&nbsp; 
                            @if($rw)
                            <a href="#" class="text-muted no-print" data-toggle="modal" data-target="#caseModal" onclick="setButtonFunc('{{$subcategory1->id}}','{{$subcategory1->name}}');"><i class="fa fa-plus-square-o"></i></a>
                            @endif
                            <div id="{{$subcategory1->id}}"></div>
                            <!-- LEVEL 2 -->
                            @if(is_array($subcategory1->children) && count($subcategory1->children) > 1)
                            <ol>
                                @foreach($subcategory1->children as $subcategory2)
                                <li> {{$subcategory2->name}} &nbsp;&nbsp;&nbsp; 
                                    @if($rw)
                                    <a href="#" class="text-muted no-print" data-toggle="modal" data-target="#caseModal" onclick="setButtonFunc('{{$subcategory2->id}}','{{$subcategory2->name}}');"><i class="fa fa-plus-square-o"></i></a>
                                    @endif
                                    <div id="{{$subcategory2->id}}"></div>
                                    <!-- LEVEL 3 -->
                                    @if(is_array($subcategory2->children) && count($subcategory2->children) > 1)
                                    <ol>
                                        @foreach($subcategory2->children as $subcategory3)
                                        <li> {{$subcategory3->name}} &nbsp;&nbsp;&nbsp; 
                                            @if($rw)
                                            <a href="#" class="text-muted no-print" data-toggle="modal" data-target="#caseModal" onclick="setButtonFunc('{{$subcategory3->id}}','{{$subcategory3->name}}');"><i class="fa fa-plus-square-o"></i></a>
                                            @endif
                                            <div id="{{$subcategory3->id}}"></div>
                                        </li>
                                        @endforeach
                                    </ol>
                                    @endif
                                </li>
                                @endforeach
                            </ol>
                            @endif
                        </li>
                        @endforeach
                    </ol>
                    @endif
                </li>
                @endforeach
                <!-- <li>Lorem ipsum dolor sit amet</li>
                <li>Consectetur adipiscing elit</li>
                <li>Integer molestie lorem at massa</li>
                <li>Facilisis in pretium nisl aliquet</li> -->
                <!-- <li>Nulla volutpat aliquam velit
                  <ol>
                    <li>Phasellus iaculis neque</li>
                    <li>Purus sodales ultricies</li>
                    <li>Vestibulum laoreet porttitor sem</li>
                    <li>Ac tristique libero volutpat at</li>
                  </ol>
                </li>
                <li>Faucibus porta lacus fringilla vel</li>
                <li>Aenean sit amet erat nunc</li>
                <li>Eget porttitor lorem</li> -->
            </ol>
        </div>
    </div>

</section>
<!-- MODAL -->
<div class="modal fade" id="caseModal" role="dialog" aria-labelledby="caseModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="caseModalLabel">Approved Case List</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="selected_category" value="">
        <div class="form-group">
            <select class="form-control select2" id="case_list" required></select>
        </div>
        <div class="form-group">
            <div class="checkbox" id="role_function">
            <label><input type='checkbox' name='case_list_all' id='case_list_all' onclick="getAllCase()">Select from other case</label>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btncaseModal">Add</button>
      </div>
    </div>
  </div>
</div>

<script>
    function getAllCase() {
        var case_list = <?php echo json_encode($cases); ?>;
        if(document.getElementById("case_list_all").checked == true) {
            $('#case_list').empty().trigger("change");
            $('#case_list').select2({
                data: case_list
            });
        } else {
            var frm_data = {
                _token: $("input[name='_token']").val(),
                category_name: document.getElementById('selected_category').value
            };
            $.ajax({
              type: 'POST',
              data: frm_data,
              url: "{{route('getCasesByCategory')}}",
              success: function(res) {
                if((res.cases).length) {
                    $('#case_list').empty().trigger("change");
                    $('#case_list').select2({
                        data: res.cases,
                        width: '100%'
                    });
                } else {
                    console.log('none');
                    $('#case_list').empty().trigger("change");
                }
              }, 
              error: function(err,msg) {

              }
            });
        }
    }
    function setButtonFunc(categoryID, categoryName) {
        //clear fields
        document.getElementById("case_list_all").checked = false;
        $('#case_list').empty().trigger("change");

        document.getElementById('selected_category').value = categoryName;
        $('#case_list').select2({
            width: '100%'
        });
        var btn = document.getElementById('btncaseModal');
        var frm_data = {
            _token: $("input[name='_token']").val(),
            category_name: categoryName
        };
        $.ajax({
          type: 'POST',
          data: frm_data,
          url: "{{route('getCasesByCategory')}}",
          success: function(res) {
            if((res.cases).length) {
                $('#case_list').select2({
                    data: res.cases,
                    width: '100%'
                });
            } else {
                $('#case_list').empty().trigger("change");
            }
          }, 
          error: function(err,msg) {

          }
        });
        
        btn.setAttribute('onclick', 'addCase("'+categoryID+'");');
    }

    function addCase(categoryID) {
        var theDiv = document.getElementById(categoryID);
        var data = $('#case_list').select2('data');
        var z = document.createElement('div');
        var text = z.innerHTML;
        try {
            if( data[0] && data[0].text) {
                z.innerHTML += '<p>&#8226;&nbsp;&nbsp;&nbsp;'+data[0].text+ '&nbsp;&nbsp;&nbsp;'
                +'<a href="#" class="text-muted no-print" onclick="removeCase(this);">'
                +'<i class="fa fa-minus-square-o"></i></a>'
                +'</p>';
                theDiv.appendChild(z);
            }
            $('#caseModal').modal('toggle'); 
        } catch(e) {
            $('#caseModal').modal('toggle'); 
        }
    }

    function removeCase(element) {
        // $(this).closest('p').remove();
        var parent = element.parentNode;
        parent.parentNode.removeChild(parent);
    }
</script>
<!-- /.content -->
<div class="clearfix"></div>
@endsection