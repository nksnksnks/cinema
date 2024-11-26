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
                <a href=""><i class="fa fa-file"></i> <span class="nav-label">Quản lý rạp chiếu</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li ><a href="{{route('cinema.store')}}">Thêm chi nhánh</a></li>
                    <li ><a href="{{route('cinema.index')}}">Quản lý chi nhánh</a></li>
                </ul>
            </li>
            
           
        </ul>

    </div>
</nav>