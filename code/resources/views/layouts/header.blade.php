<div id="header">
<nav class="navbar navbar-expand-md navbar-light bg-faded">
  <a class="navbar-brand" href="/"><img src="{{asset('images/logos/logo.png')}}" height="50px" width="100px" alt=""></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline mr-auto" action="/search" method="get">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Search plan ...">
      <button class="btn btn-light my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
    </form>
    <ul class="navbar-nav">
      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Sigin</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Signup</a>
        </li>
      @else
        <li class="nav-item">
          <a class="nav-link" href="{{route('plans.create')}}" data-toggle="tooltip" title="Thêm kế hoạch"><i class="fas fa-plus-circle"></i>  Create</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{route('users.show',Auth::user()->id)}}">Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
      @endguest
    </ul>
  </div>
</nav>
</div>