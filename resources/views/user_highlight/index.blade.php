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
      <h3 class="box-title">User Highlights</h3>
    </div>
    <div class="box-body">
        <table id="userList" class="table table-bordered table-striped" style="table-layout: fixed;">
            <thead>
            <tr>
                <th style="width: 50%;">Highlighted Text</th>
                <th style="width: 10%;">G.R No.</th>
                <th style="width: 20%;">Title</th>
                <th style="width: 10%;">Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @if($highlights)
                @foreach($highlights as $grno => $array)
                <tr>
                    @if ($copy_id = str_random(4)) @endif
                    <td>
                        <p style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        @foreach($array as $highlight)
                            @if(isset($highlight->text))
                            {{$highlight->text}}<br>
                            @endif
                        @endforeach
                        <textarea id="highlight_text_{{$copy_id}}" style="opacity: 0; position: absolute;">{{isset($array['formatted_text'])?$array['formatted_text']:null}}</textarea>
                        </p>

                    </td>
                    <td>{{$grno}}</td>
                    <td>{{ isset($array[0]->title)?$array[0]->short_title:"&nbsp;" }}</td>
                    <td>{{ isset($array[0]->date)?date('F d, Y' ,strtotime($array[0]->date)):"&nbsp;" }}</td>
                    <td>
                        <button type="button" onclick="copyToClipboard('highlight_text_{{$copy_id}}')" class="btn btn-block btn-success btn-xs">Copy</button>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
</section>
<script type="text/javascript">
    function copyToClipboard(element) {
        var copyTextarea = document.getElementById(element);
        copyTextarea.select();
        try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
        } catch (err) {
        console.log('Oops, unable to copy');
        }
    }
</script>
@endsection