<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scroll-wrapper scrollbar-inner" style="position: relative;"><div class="scrollbar-inner scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 323px;">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="../assets/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active"  href="{{ route('admin.home') }}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link"  href="{{ route('admin.table') }}">
                <i class="ni ni-planet text-orange"></i>
                <span class="nav-link-text">Users</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.contestant') }}">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">Contestants</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('admin.show',$group='no')}}">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">Show</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="account">
                <i class="ni ni-bullet-list-67 text-default"></i>
                <span class="nav-link-text">Account</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage">
                <i class="ni ni-key-25 text-info"></i>
                <span class="nav-link-text">Management</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">Home</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <i class="ni ni-send text-dark"></i>
                <span class="nav-link-text">Advert</span>
              </a>
            </li>
          </ul>
          
        </div>
      </div>
    </div><div class="scroll-element scroll-x scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 0px;"></div></div></div><div class="scroll-element scroll-y scroll-scrolly_visible"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 219px; top: 0px;"></div></div></div></div>
  </nav>