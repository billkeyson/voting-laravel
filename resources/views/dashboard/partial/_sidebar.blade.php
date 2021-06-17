<aside id="leftsidebar" class="sidebar"> 
    <!-- User Info -->
    <div class="user-info">
        <div class="image"> <img src="{{asset('assets/images/xs/avatar1.jpg')}}" width="48" height="48" alt="User" /> </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">{{Auth::user()->name}}</div>
            <div class="email">{{Auth::user()->email}}</div>
            <div class="btn-group user-helper-dropdown"> <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" role="button"> keyboard_arrow_down </i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="#"><i class="material-icons">person</i>Profile</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}" 
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="material-icons">input</i>
                        {{ __('Sign Out') }}
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info --> 
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            {{-- Memebers --}}
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Members</span></a>
                <ul class="ml-menu">
                    <li><a href="#">Create</a></li>
                    <li><a href="#">View</a></li>
                </ul>
            </li>
            {{-- Events --}}
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Events</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('event.create')}}">Create</a></li>
                    <li><a href="{{route('event.index')}}">View</a></li>
                </ul>
            </li>
            {{-- Ussd --}}
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Donation</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('donate.index')}}">Donation Template</a></li>
                </ul>
            </li>
            
            <li><a href="#"><i class="zmdi zmdi-delicious"></i><span>Widgets</span> </a></li>
            <li><a href="#"><i class="zmdi zmdi-email"></i><span>Inbox</span> </a></li>
            <li><a href="#"><i class="zmdi zmdi-blogger"></i><span>Blogger</span> </a></li>
 
          
        </ul>
    </div>
    <!-- #Menu --> 
</aside>