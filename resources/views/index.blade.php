@extends('master')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Top Navigation
    <small>Example 2.0</small>
  </h1>
  @include('breadcrumb')
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Blank Box</h3>
    </div>
    <div class="box-body">
      <pre>
      {{print_r(session()->get('token'))}}
      </pre>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>
@endsection