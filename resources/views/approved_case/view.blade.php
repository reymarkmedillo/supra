@extends('master')
@section('content')
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- CK Editor -->
  <script src="{{url('/')}}/bower_components/ckeditor/ckeditor.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{url('/')}}/bower_components/select2/dist/css/select2.min.css">
  <!-- Select2 -->
  <script src="{{url('/')}}/bower_components/select2/dist/js/select2.full.min.js"></script>
  <!-- InputMask -->
  <script src="{{url('/')}}/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="{{url('/')}}/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="{{url('/')}}/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- <section class="content-header">
  <h1>
    Top Navigation
  </h1>
  @include('breadcrumb')
</section> -->

<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Case</h3>
    </div>
    <div class="box-body">
        @if($errors->any())
          <div class="col-md-12">
            @foreach($errors->all() as $error)
              <p class="text-red">{{$error}}</p>
            @endforeach
          </div>
        @endif
        <form role="form" method="post" action="{{route('postUpdateApprovedCase', $case->id)}}" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="box-body">

            <!-- CASE TITLE -->
            <div class="col-md-12">
              <div class="form-group">
                <label for="case_title">Title</label>
                <input type="text" class="form-control" name="title" id="case_title" value="{{$case->title}}" required>
              </div>
            </div>
            <!-- CASE SHORT TITLE -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_short_title">Short Title</label>
                <input type="text" class="form-control" name="short_title" id="case_short_title" value="{{$case->short_title}}" required>
              </div>
            </div>
            <!-- CASE DATE -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_grno">Date</label>
                <input type="text" name="date" id="case_date" class="form-control" required value="{{$case->date}}">
              </div>
            </div>
            <!-- CASE GRNO -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_grno">G.R. Number</label>
                <input type="text" class="form-control" name="gr" id="case_grno" value="{{$case->grno}}" required>
              </div>
            </div>
            <!-- CASE SCRA -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="case_grno">Scra</label>
                <input type="text" class="form-control" name="scra" id="case_scra" value="{{$case->scra}}">
              </div>
            </div>
            <!-- CASE STATUS -->
            <div class="col-md-4">
              <div class="form-group">
                <label for="full_txt">Status</label>
                <select id="case_status" name="status" class="form-control">
                  @foreach(config('define.statuses') as $key => $value)
                  <option value="{{$key}}" {{ (strtolower($key)==strtolower($case->status))?'selected':'' }} > {{$value}} </option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- REFERENCE CASES -->
            <div class="col-md-12" id="case_reference_container"></div>
            <!-- RELATED CASES -->
            <div class="col-md-12" id="case_related_container"></div>
            <div id="not_related_case_area">
              <!-- CASE TOPICS -->
              <div class="form-group">

                  <div class="col-md-6">
                    <label for="case_grno">Topic</label>
                    <select class="form-control select2" name="topic_select" id="topic_select"></select><br>
                    <div class="input-group input-group-sm" style="margin-top: 4px;">
                      <span class="input-group-addon">
                        <input type="checkbox" id="enableCustomCategory">
                      </span>
                      <input type="text" class="form-control" id="customCategory" readonly="readonly" placeholder="add category manually ...">
                          <span class="input-group-btn">
                            <button type="button" class="btn btn-info btn-flat" id="btnAddCustomCategory" onclick="addCustomCategory();"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                          </span>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <select multiple class="form-control" name="topics" id="topics">
                        @if(isset($case_category))
                          @if(is_array($case_category))
                            @foreach($case_category as $category)
                              <option value="{{str_replace('"','',$category)}}"> {{str_replace('"','',$category)}} </option>
                            @endforeach
                          @else
                          <option value="{{str_replace('"','',$case_category)}}"> {{str_replace('"','',$case_category)}} </option>
                          @endif
                        @endif
                      </select> 
                  </div>
                  <input type="hidden" name="topic" id="topic">
              </div>
              <!-- CASE SYLLABUS -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="case_syllabus">Syllabus</label>
                  <textarea id="syllabus" name="syllabus" rows="10" cols="80" style="resize: none;">
                    {{$case->syllabus}}
                  </textarea>
                </div>
              </div>
              <!-- CASE BODY -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="case_syllabus">Case Digest</label>
                  <textarea id="body" name="body" rows="10" cols="80" style="resize: none;">
                    {{$case->body}}
                  </textarea>
                </div>
              </div>
              <!-- CASE FULLTEXT FILE -->
              <div class="col-md-12">
                <div class="form-group">
                  <label for="full_txt">Full Text</label>
                  <input type="file" id="full_txt" name="full_txt">
                  <p class="help-block">Current file uploaded: &nbsp;&nbsp;&nbsp;{{isset($fulltxt_filename)?$fulltxt_filename:'none'}}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="box-footer">
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success btn-flat" id="btnUpdateCase" onclick="setTopics();">Update</button>
            </div>
          </div>
        </form>
    </div>
  </div>
</section>
<script>
  var syllabus_editor = CKEDITOR.replace('syllabus');
  var body_editor = CKEDITOR.replace('body');
  var case_list = [];
  var topic_container = [];
  var case_child = <?php echo json_encode($case_child); ?>;
  var case_parent = <?php echo json_encode($case_parent); ?>;
  $( document ).ready(function() {
    // "START > REFERENCE CASE"
    var html_case_reference = 
      '<div class="form-group"><div class="row"><div class="col-md-6">'
      +'<label for="case_parent">References</label>'
      +'<p>Parent</p>'
      +'<select class="form-control select2" name="case_parent" id="case_parent"></select>'
      +'</div>';
    html_case_reference += '<div class="col-md-6">'
      +'<label for="case_child">&nbsp;</label>'
      +'<p>Child</p>'
      +'<select class="form-control select2" name="case_child" id="case_child"></select>'
      +'</div></div></div>';

      $('#case_reference_container').append(html_case_reference);
      // "add blank option"
      document.getElementById("case_parent").insertBefore(new Option('', ''), document.getElementById("case_parent").firstChild);
      document.getElementById("case_child").insertBefore(new Option('', ''), document.getElementById("case_child").firstChild);
      document.getElementById("topic_select").insertBefore(new Option('', ''), document.getElementById("topic_select").firstChild);

      $('#case_child').select2({
        data: <?php echo json_encode($case_list); ?>
      });
      $('#case_parent').select2({
        data: <?php echo json_encode($case_list); ?>
      });
      $('#topic_select').select2({
        data: <?php echo json_encode($top_categories); ?>,
        placeholder: "Please choose a category"
      });
      $('#case_child').select2().val(case_child).trigger('change');
      $('#case_parent').select2().val(case_parent).trigger('change');
      // "END < REFERENCE CASE"

    // "START > RELATED CASE IS CHECKED EVENT"
    $('#q_case_related').on('change', function() { // workaround to add/check for property "checked"
      if($(this).attr('checked')) {
        $('#not_related_case_area').show();
        $('#case_related_container').empty();
        $(this).attr("checked", false);
      } else {
        $('#not_related_case_area').hide();
        var html_case_related = '<div class="form-group">'
          +'<label for="case_related_to">Related to</label>'
          +'<select class="form-control select2" name="case_related_to" id="case_related_to" required></select>'
          +'</div>';

        $('#case_related_container').append(html_case_related);
        // "add blank option"
        document.getElementById("case_related_to").insertBefore(new Option('', ''), document.getElementById("case_related_to").firstChild);

        $('#case_related_to').select2({
          data: <?php echo json_encode($case_list); ?>
        });
        $(this).attr("checked", true);
      }
    });
    // "END < RELATED CASE IS CHECKED EVENT"

    $('#case_date').inputmask('Aaa 99, 9999', {placeholder: 'Mmm dd, yyyy'});
    $("#case_date" ).datepicker({
      dateFormat: "M dd, yy"
    });

     $('#topic_select').on('select2:select', function (e) {
      var data = e.params.data;
      if(data.id) {
        $('#topic_select').empty().trigger("change");
        document.getElementById("topic_select").insertBefore(new Option('', ''), document.getElementById("topic_select").firstChild);
        $("#topics").append($('<option>', {value:data.id, text: data.text}));
        $.ajax({
          type: 'GET',
          url: '/case/category/'+data.id,
          success: function(res) {
            $('#topic_select').select2({
              data: res,
              placeholder: "Please choose a category"
            });
          }
        });
      }
    });
    // "DOUBLE CLICK EVENT FOR CATEGORY LISTVIEW"
    var selectedIndex = null;
    $('#topics').dblclick(function() {
      if($(this).find('option:selected')[0]) {
        selectedIndex = $(this).find('option:selected')[0].index;
        $(this).find('option').each(function () {
            if(selectedIndex > $(this).index()) {
            } else {
              $('#topics option').filter('[value="'+$(this).val()+'"]').remove();
            }
        });
        


        if($(this).find('option:last').length > 0) {
          $('#topic_select').empty().trigger("change");
          document.getElementById("topic_select").insertBefore(new Option('', ''), document.getElementById("topic_select").firstChild);
          $.ajax({
            type: 'GET',
            url: '/case/category/'+$(this).find('option:last')[0].value,
            success: function(res) {
              $('#topic_select').select2({
                data: res,
                placeholder: "Please choose a category"
              });
            },
            error: function(e) {
              console.log(e);
            }
          });
        } else {
          $('#topic_select').empty().trigger("change");
          document.getElementById("topic_select").insertBefore(new Option('', ''), document.getElementById("topic_select").firstChild);
          $('#topic_select').select2({
            data: <?php echo json_encode($top_categories); ?>,
            placeholder: "Please choose a category"
          });
        }
      }
    });
    // "CHECKBOX EVENTS FOR CUSTOM CATEGORY"
    $('#enableCustomCategory').on('change', function() { // workaround to add/check for property "checked"
      if($(this).attr('checked')) {
        $(this).attr("checked", false);
        document.getElementById('customCategory').value = "";
        $('#customCategory').prop('readonly',true);
      } else {
        $(this).attr("checked", true);
        document.getElementById('customCategory').value = "";
        $('#customCategory').prop('readonly',false);
      }
    });

  });

  function addCustomCategory() {
    var custom_category = $('#customCategory').val();
    if(custom_category.trim()) {
      $("#topics").append($('<option>', {value: custom_category, text: custom_category}));
      document.getElementById('customCategory').value = "";
    }
  }

  function setTopics() {
    topic_container = [];
    $('#topics').find('option').each(function () {
      topic_container.push($(this).val());
    });
    console.log(topic_container);
    $('#topic').val(topic_container.join());
  }

 
</script>
@endsection
