<div class="nk-nav-scroll">
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{url('dashboard')}}" aria-expanded="false">
                <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
            </a>
        </li>
        <li class="mega-menu mega-menu-sm">
            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fa fa-list-alt" aria-hidden="true"></i><span class="nav-text">Application</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{url('add-application/0')}}">Add Application</a></li>
                <li><a href="{{url('application')}}">Application List</a></li>
            </ul>
        </li>
        <!-- <li class="mega-menu mega-menu-sm active">
            <a href="javascript:void(0)" aria-expanded="false">
                <i class="icon-badge menu-icon"></i><span class="nav-text">Application</span>
            </a>
            <ul aria-expanded="false" class="collapse in" style="">
                <li><a href="{{url('application')}}">Application List</a></li>
                <li><a href="{{url('add-application')}}">Add Application</a></li>
            </ul>
        </li> -->
        <li class="mega-menu mega-menu-sm">
            <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fa fa-list-alt" aria-hidden="true"></i><span class="nav-text">Application New</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{url('application-new')}}">Application List</a></li>
            </ul>
        </li>
        @if(Auth::user()->role != 4)
        <li>
            <a href="{{url('new-user')}}" aria-expanded="false">
                <i class="fa fa-users" aria-hidden="true"></i><span class="nav-text">User</span>
            </a>
        </li>

        <li>
            <a href="{{url('settings')}}" aria-expanded="false">
                <i class="fa fa-cog" aria-hidden="true"></i><span class="nav-text">Settings</span>
            </a>
        </li>
        @endif
    </ul>
</div>