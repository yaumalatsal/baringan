  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('admin') }}" class="brand-link">
          <img src="{{ asset('logo/logo-only.png') }}" alt="Baringan Logo" class="brand-image img-circle elevation-3"
              style="opacity: .8">
          <span class="brand-text font-weight-light">Baringan</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          {{-- <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> --}}

          {{-- <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a href="{{ route('admin') }}" class="nav-link {{ request()->is('admin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
        
                <!-- Lantai Menu -->
                <li class="nav-item {{ Request::is('admin') ? '' : 'menu-open' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Lantai
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach ($floors as $floor)
                            <li class="nav-item">
                                <a href="{{ route('admin.floors', $floor->id) }}" class="nav-link {{ Request::is('admin/floors/' . $floor->id) ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ $floor->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        
            <!-- Logout Link -->
            <ul class="navbar-nav text-center mt-40">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="nav-link">
                            
                            <p><i class="fas fa-sign-out-alt nav-icon"></i>  Logout</p>
                        </a>
                    </form>
                </li>
            </ul>
        </nav>
        
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
