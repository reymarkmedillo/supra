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
      <h3 class="box-title">List of All Approved Cases</h3>
    </div>
    <div class="box-body">
        @if(session()->has('msg-success'))
            <p class="text-green pull-right">{{session()->get('msg-success')}}</p>
        @endif
        <table id="caseList" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th class="col-md-4">Title</th>
                <th class="col-md-2">G.R. No.</th>
                <th class="col-md-1">Scra</th>
                <th class="col-md-1">Date</th>
                <th class="col-md-2">Topic</th>
                @if(caseApproversRoles())
                <th class="col-md-1"></th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($cases as $case)
            <tr>
                <td>{{$case->short_title}}</td>
                <td>{{$case->grno}}
                  @if(isset($case->child_grno) && count($case->child_grno))
                    >
                    @foreach($case->child_grno as $child)
                      @if(count($case->child_grno) == 1)
                      {{$child->refno}}
                      @else
                      {{$child->refno}} ,
                      @endif
                    @endforeach
                  @endif
                </td>
                <td>{{$case->scra}}</td>
                <td>{{$case->date}}</td>
                <td>{{implode(',', array_column($case->xgr, 'topic'))}}</td>
                @if(caseApproversRoles())
                  <td>
                    <button type="button" class="btn btn-success btn-xs" onclick='location.href="{{route('viewApprovedCase', $case->id)}}";' id="btnEdit{{$case->id}}">Edit</button>
                      <button type="button" class="btn btn-danger btn-xs" id="btnDelete{{$case->id}}" onclick="deleteCase({{$case->id}})">Delete</button>
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
    $('#caseList').DataTable()
  });


function deleteCase(case_id) {
  var check = confirm("Proceed to delete case id '"+case_id+"'?");
  if(check == true) {
    $.ajax({
      type: 'GET',
      url: '/case/remove/'+case_id,
      success: function(res) {
        var error = "<?php echo config('define.result.failure'); ?>";
        window.location.reload();
      }
    });
  }
}
</script>
@endsection
