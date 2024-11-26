<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        {{-- <img alt="image" class="img-circle" src="backend/a7.png" /> --}}
                         </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                         </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{route('auth.logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li class="active">
                <a href=""><i class="fa fa-user"></i> <span class="nav-label">Quản lý Account</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('account.index')}}">Quản lý tài khoản</a></li>
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa-solid fa-house"></i> <span class="nav-label">Quản lý rạp chiếu</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('cinema.store')}}">Thêm chi nhánh</a></li>
                    <li ><a href="{{route('cinema.index')}}">Quản lý chi nhánh</a></li>
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa-solid fa-globe"></i> <span class="nav-label">Quản lý thành p</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('cinema.store')}}">Thêm quốc gia</a></li>
                    <li ><a href="{{route('cinema.index')}}">Quản lý quốc gia</a></li>
                    <li ><a href="{{route('cinema.store')}}">Thêm thể loại</a></li>
                    <li ><a href="{{route('cinema.index')}}">Quản lý thể loại</a></li>
                    <li ><a href="{{route('cinema.store')}}">Thêm độ tuổi</a></li>
                    <li ><a href="{{route('cinema.index')}}">Quản lý độ tuổi</a></li>                 
                </ul>
            </li>
            {{-- <li class="active">
                <a href=""><i class="fa fa-user"></i> <span class="nav-label">Quản lý thể loại</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{route('genre.create')}}">Thêm thể loại</a></li>
                    <li><a href="{{route('genre.index')}}">Quản lý thể loại</a></li>
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa fa-newspaper"></i> <span class="nav-label">Quản lý quốc gia</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('country.create')}}">Thêm quốc gia</a></li>
                    <li ><a href="{{route('country.index')}}">Quản lý quốc gia</a></li>
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa fa-newspaper"></i> <span class="nav-label">Quản lý năm</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('year.create')}}">Thêm năm mới</a></li>
                    <li ><a href="{{route('year.index')}}">Quản lý năm</a></li>
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa fa-newspaper"></i> <span class="nav-label">Quản lý phim</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('movie.create')}}">Thêm phim mới</a></li>
                    <li ><a href="{{route('movie.index')}}">Quản lý phim</a></li>
                    <li ><a href="{{route('movies.api_import.index')}}">Thêm 1 page API</a></li>
                    <li ><a href="{{route('movies.api_import.index1')}}">Thêm nhiều page API</a></li>
                    <li ><a href="{{route('movies.import.show')}}">Thêm 1 phim API</a></li>
                    
                </ul>
            </li>
            <li class="active"> 
                <a href=""><i class="fa fa-newspaper"></i> <span class="nav-label">Quản lý tập phim</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('movie.index')}}">Thêm tập mới</a></li>
                    <li ><a href="{{route('episode.index')}}">Quản lý tập phim</a></li>
                    <li ><a href="{{route('getpage.apiophim')}}">Update tập phim</a></li>
                </ul>
            </li> --}}
           
        </ul>

    </div>
</nav>