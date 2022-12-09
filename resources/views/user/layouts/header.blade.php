  <div class="header-content clearfix">
      <div class="nav-control">
          <div class="hamburger">
              <span class="toggle-icon"><i class="icon-menu"></i></span>
          </div>
      </div>
      <div class="header-right">
          <ul class="clearfix">

              <li class="icons dropdown">
                  <div class="user-img c-pointer position-relative" data-toggle="dropdown">
                      <span class="activity active"></span>
                      <img src="{{asset('user\assets\images/user/1.png')}}" height="40" width="40" alt="">
                  </div>
                  <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                      <div class="dropdown-content-body">
                          <ul>
                              <!-- <li>
                                <a href="app-profile.html"><i class="icon-user"></i> <span>Profile</span></a>
                            </li> -->
                              <li>
                                  <a href="javascript:void(0)" data-toggle="modal" data-target="#HeaderChangePasswordModal"><i class="icon-user"></i> <span>Change Password</span></a>
                              </li>
                              <li><a href="{{ url('logout') }}"><i class="icon-key"></i> <span>Logout</span></a></li>

                          </ul>
                      </div>
                  </div>
              </li>
          </ul>
      </div>
  </div>