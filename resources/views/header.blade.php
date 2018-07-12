<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="{{env('APP_URL')}}" class="navbar-brand"><b>Tier</b>App</a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Case <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if( (nonPaymentRoles() && caseSubmittersRoles()) || (checkIfPaid() && caseSubmittersRoles()) )
                <li><a href="{{route('createCase')}}">Add Case</a></li>
                @endif
                <li class="divider"></li>
                <li><a href="{{route('listCase')}}">Drafts</a></li>
                <li><a href="{{route('listApprovedCase')}}">Approved</a></li>
              </ul>
            </li>
          @if( (nonPaymentRoles() && caseHighlightsRoles()) || (checkIfPaid() && caseHighlightsRoles()) )
          <li><a href="{{route('getUserHighlights')}}">My Highlights</a></li>
          @endif
          @if( userManagerRoles() )
            <li><a href="{{route('getUsers')}}">Manage Users</a></li>
          @endif
          @if( (nonPaymentRoles() && caseCategoriesRoles()) || (checkIfPaid() && caseCategoriesRoles()) )
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Category <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('createCategory')}}">Add Category</a></li>
                <li><a href="{{route('editCategory')}}">Edit Category</a></li>
                <li><a href="{{route('getCategoryTree', ['action'=>'r'])}}">View Category Tree</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{route('getCategoryTree', ['action'=>'rw'])}}">Category(Case) Tree Builder</a></li>
              </ul>
            </li>
          @endif
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{url('/')}}/dist/img/avatar04.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              @if( isset(session()->get('user')->first_name) || isset(session()->get('user')->last_name)) 
              <span class="hidden-xs"> {{session()->get('user')->first_name}} {{session()->get('user')->last_name}} </span>
              @else
              <span class="hidden-xs">&nbsp;</span>
              @endif
            </a>
            <ul class="dropdown-menu" role="menu" style="width: 120px;">
              <li><a href="{{route('editProfile')}}">Edit Profile</a></li>
              <li class="divider"></li>
              <li><a href="{{route('getChangePassword')}}">Change Password</a></li>
              <li><a href="{{route('signOut')}}">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>