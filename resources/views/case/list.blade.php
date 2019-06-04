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
    </div>
    <div class="box-body">
        <table id="caseList" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th class="col-md-4">Title</th>
                <th class="col-md-2">G.R. No.</th>
                <th class="col-md-1">Scra</th>
                <th class="col-md-1">Date</th>
                <th class="col-md-2">Topic</th>
                @if(caseApproversRoles())
                <th class="col-md-2"></th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($cases as $case)
            @if($case->approved == 0)
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
                <td></td> <!-- topic -->
                @if(caseApproversRoles())
                  <td>
                      <button type="button" class="btn btn-success btn-xs" onclick="approve({{$case->id}})" id="btnApprove{{$case->id}}">Approve</button>
                      <button type="button" class="btn btn-danger btn-xs {{is_null($case->deleted_at)?'':'disabled'}} " id="btndisApprove{{$case->id}}" {{is_null($case->deleted_at)?'onclick=disApprove('.$case->id.')':''}}>Disapprove</button>
                  </td>
                @endif
            </tr>
            @endif
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
function approve(case_id) {
    $('#btnApprove'+case_id).addClass('disabled');
    $.ajax({
      type: 'POST',
      data: {
        approval: 1,
        _token: '{{ csrf_token() }}'
      },
      url: '/case/approve/'+case_id,
      success: function(res) {
        window.location.reload();
      }
    });
}

function disApprove(case_id) {
    $('#btndisApprove'+case_id).addClass('disabled');
    $.ajax({
      type: 'POST',
      data: {
        approval: 0,
        _token: '{{ csrf_token() }}'
      },
      url: '/case/approve/'+case_id,
      success: function(res) {
        window.location.reload();
      }
    });
}
</script>
@endsection
