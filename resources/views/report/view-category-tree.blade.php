@extends('master')
@section('content')
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
            <i class="fa fa-globe"></i> {{$main_category_name}}
            <small class="pull-right">Date: 2/10/2014</small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-12">
            <ol>
                @foreach($category_tree as $category)
                <li> {{$category->name}} &nbsp;&nbsp;&nbsp;
                    @if($rw)
                    <a href="#" class="text-muted" data-toggle="modal" data-target="#caseModal"><i class="fa fa-plus-square-o"></i></a>
                    @endif
                    <div id="{{$category->id}}"></div>
                    <!-- LEVEL 1 -->
                    @if(is_array($category->children) && count($category->children) > 1)
                    <ol>
                        @foreach($category->children as $subcategory1)
                        <li> {{$subcategory1->name}} &nbsp;&nbsp;&nbsp; 
                            @if($rw)
                            <a href="#" class="text-muted" data-toggle="modal" data-target="#caseModal"><i class="fa fa-plus-square-o"></i></a>
                            @endif
                            <div id="{{$subcategory1->id}}"></div>
                            <!-- LEVEL 2 -->
                            @if(is_array($subcategory1->children) && count($subcategory1->children) > 1)
                            <ol>
                                @foreach($subcategory1->children as $subcategory2)
                                <li> {{$subcategory2->name}} &nbsp;&nbsp;&nbsp; 
                                    @if($rw)
                                    <a href="#" class="text-muted" data-toggle="modal" data-target="#caseModal"><i class="fa fa-plus-square-o"></i></a>
                                    @endif
                                    <div id="{{$subcategory2->id}}"></div>
                                    <!-- LEVEL 3 -->
                                    @if(is_array($subcategory2->children) && count($subcategory2->children) > 1)
                                    <ol>
                                        @foreach($subcategory2->children as $subcategory3)
                                        <li> {{$subcategory3->name}} &nbsp;&nbsp;&nbsp; 
                                            @if($rw)
                                            <a href="#" class="text-muted" data-toggle="modal" data-target="#caseModal"><i class="fa fa-plus-square-o"></i></a>
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
<div class="modal fade" id="caseModal" tabindex="-1" role="dialog" aria-labelledby="caseModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="caseModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
// var theDiv = document.getElementById("CIVIL1A");
// var z = document.createElement('div');
// var text = z.innerHTML;
// z.innerHTML += '<p>adsfadsfadsfasdfasd</p>';

// theDiv.appendChild(z);
</script>
<!-- /.content -->
<div class="clearfix"></div>
@endsection