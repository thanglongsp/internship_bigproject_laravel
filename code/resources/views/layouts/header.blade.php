<div id="header">
<nav class="navbar navbar-expand-md navbar-light bg-faded">
  <a class="navbar-brand" href="/"><img src="{{asset('images/logos/logo.png')}}" height="50px" width="100px" alt=""></a>
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline mr-auto" action="/search" method="get">
      <input class="form-control mr-sm-2" name="search" type="search" placeholder="Tìm kế hoạch...">
      <button class="btn btn-light my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
    </form>
    <ul class="navbar-nav">
      @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a> 
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">Đăng ký</a>
        </li>
      @else
        <li class="nav-item">
          <a class="nav-link" href="{{route('plans.create')}}" data-toggle="tooltip" title="Thêm kế hoạch"><i class="fas fa-plus-circle"></i></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link notifications" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-bell"></i>
            <span class="button__badge">5</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="javascript:void(0)">Quân đẹp trai vừa đá bạn ra khỏi kế hoạch</a>
            <a class="dropdown-item" href="javascript:void(0)">NamNP đã chấp nhận cho bạn tham gia kế hoạch</a>
            <a class="dropdown-item" href="javascript:void(0)">Long SP đang theo dõi bạn</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="{{route('users.show',Auth::user()->id)}}">Trang cá nhân</a>
            <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Đăng xuất</a>
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