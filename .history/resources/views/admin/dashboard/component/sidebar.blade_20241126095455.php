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
            <li class="{{ request()->routeIs('account.*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Quản lý Account</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('account.index') ? 'active' : '' }}">
                        <a href="{{ route('account.index') }}">Quản lý tài khoản</a>
                    </li>
                </ul>
            </li>
            
            <li class="{{ request()->routeIs('cinema.*','room.*') ? 'active' : '' }}">
                <a href="#"><i class="fa-solid fa-house"></i> <span class="nav-label">Quản lý rạp chiếu</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('cinema.store') ? 'active' : '' }}">
                        <a href="{{ route('cinema.store') }}">Thêm chi nhánh</a>
                    </li>
                    <li class="{{ request()->routeIs('cinema.index') ? 'active' : '' }}">
                        <a href="{{ route('cinema.index') }}">Quản lý chi nhánh</a>
                    </li>
                </ul>

                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('room.create') ? 'active' : '' }}">
                        <a href="{{ route('room.create') }}">Thêm phòng mới</a>
                    </li>
                    <li class="{{ request()->routeIs('room.index') ? 'active' : '' }}">
                        <a href="{{ route('room.index') }}">Quản lý phòng</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('room.create') ? 'active' : '' }}">
                        <a href="{{ route('room.create') }}">Thêm phòng mới</a>
                    </li>
                    <li class="{{ request()->routeIs('room.index') ? 'active' : '' }}">
                        <a href="{{ route('room.index') }}">Quản lý phòng</a>
                    </li>
                </ul>
            </li>
            
            <li class="{{ request()->routeIs('genre.*', 'country.*', 'rated.*') ? 'active' : '' }}">
                <a href="#"><i class="fa-solid fa-bars"></i> <span class="nav-label">Quản lý thành phần</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('genre.create') ? 'active' : '' }}">
                        <a href="{{ route('genre.create') }}">Thêm thể loại</a>
                    </li>
                    <li class="{{ request()->routeIs('genre.index') ? 'active' : '' }}">
                        <a href="{{ route('genre.index') }}">Quản lý thể loại</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('country.create') ? 'active' : '' }}">
                        <a href="{{ route('country.create') }}">Thêm quốc gia</a>
                    </li>
                    <li class="{{ request()->routeIs('country.index') ? 'active' : '' }}">
                        <a href="{{ route('country.index') }}">Quản lý quốc gia</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('rated.create') ? 'active' : '' }}">
                        <a href="{{ route('rated.create') }}">Thêm nhãn tuổi</a>
                    </li>
                    <li class="{{ request()->routeIs('rated.index') ? 'active' : '' }}">
                        <a href="{{ route('rated.index') }}">Quản lý nhãn</a>
                    </li>
                </ul>
            </li>
            
            <li class="{{ request()->routeIs('movie.*') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-film"></i> <span class="nav-label">Quản lý phim</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('movie.create') ? 'active' : '' }}">
                        <a href="{{ route('movie.create') }}">Thêm phim</a>
                    </li>
                    <li class="{{ request()->routeIs('movie.index') ? 'active' : '' }}">
                        <a href="{{ route('movie.index') }}">Quản lý phim</a>
                    </li>
                </ul>
            </li>
            
            <li class="{{ request()->routeIs('specialday.*', 'timeslot.*', 'weeklyticketprice.*') ? 'active' : '' }}">
                <a href="#"><i class="fa-solid fa-dollar-sign"></i> <span class="nav-label">QL phí phụ thu</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('specialday.create') ? 'active' : '' }}">
                        <a href="{{ route('specialday.create') }}">Thêm SpecialDay</a>
                    </li>
                    <li class="{{ request()->routeIs('specialday.index') ? 'active' : '' }}">
                        <a href="{{ route('specialday.index') }}">Quản lý SpecialDay</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('timeslot.create') ? 'active' : '' }}">
                        <a href="{{ route('timeslot.create') }}">Thêm TimeSlot</a>
                    </li>
                    <li class="{{ request()->routeIs('timeslot.index') ? 'active' : '' }}">
                        <a href="{{ route('timeslot.index') }}">Quản lý TimeSlot</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li class="{{ request()->routeIs('weeklyticketprice.create') ? 'active' : '' }}">
                        <a href="{{ route('weeklyticketprice.create') }}">Thêm weekly_ticket</a>
                    </li>
                    <li class="{{ request()->routeIs('weeklyticketprice.index') ? 'active' : '' }}">
                        <a href="{{ route('weeklyticketprice.index') }}">Quản lý weekly_ticket</a>
                    </li>
                </ul>
                
            </li>
        
            
           
        </ul>

    </div>
</nav>