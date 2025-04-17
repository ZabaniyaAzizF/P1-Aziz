<!--start header-->
<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-4">
      <div class="btn-toggle">
        <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
      </div>
      <div class="search-bar flex-grow-1">
        <div class="position-relative">
          <input class="form-control rounded-5 px-5 search-control d-lg-block d-none" type="text" placeholder="Search">
          <span class="material-icons-outlined position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50">search</span>
          <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
          <div class="search-popup p-3">
            <div class="card rounded-4 overflow-hidden">
              <div class="card-header d-lg-none">
                <div class="position-relative">
                  <input class="form-control rounded-5 px-5 mobile-search-control" type="text" placeholder="Search">
                  <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                  <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
                 </div>
              </div>
              <div class="card-body search-content">
                <p class="search-title">Recent Searches</p>
                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                  <a href="javascript:;" class="kewords"><span>Angular Template</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                  <a href="javascript:;" class="kewords"><span>Dashboard</span><i
                      class="material-icons-outlined fs-6">search</i></a>
                </div>
                <hr>
                <p class="search-title">Tutorials</p>
                <div class="search-list d-flex flex-column gap-2">
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">play_circle</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Wordpress Tutorials</h5>
                    </div>
                  </div>
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">shopping_basket</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">eCommerce Website Tutorials</h5>
                    </div>
                  </div>
  
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="list-icon">
                      <i class="material-icons-outlined fs-5">laptop</i>
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">Responsive Design</h5>
                    </div>
                  </div>
                </div>
  
                <hr>
                <p class="search-title">Members</p>
  
                <div class="search-list d-flex flex-column gap-2">
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="admin/images/avatars/01.png" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Andrew Stark</h5>
                    </div>
                  </div>
  
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="admin/images/avatars/02.png" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title ">Snetro Jhonia</h5>
                    </div>
                  </div>
  
                  <div class="search-list-item d-flex align-items-center gap-3">
                    <div class="memmber-img">
                      <img src="admin/images/avatars/03.png" width="32" height="32" class="rounded-circle" alt="">
                    </div>
                    <div class="">
                      <h5 class="mb-0 search-list-title">Michle Clark</h5>
                    </div>
                  </div>
  
                </div>
              </div>
              <div class="card-footer text-center bg-transparent">
                <a href="javascript:;" class="btn w-100">See All Search Results</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ul class="navbar-nav gap-1 nav-right-links align-items-center">
        <li class="nav-item dropdown">
          <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
            <div class="notify-list">
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"    
          style="display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; 
          border-radius: 50%; background: #0c0e33; border: 2px solid #ccc;">
          <i class="material-icons-outlined" style="font-size: 24px; color: #0703f0;">person</i>
          </a>
          <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
            <a class="dropdown-item  gap-2 py-2" href="javascript:;">
              <div class="text-center">
                <i class="material-icons-outlined fs-2">person</i>
                @auth
                <h5 class="user-name mb-0 fw-bold">Hello, {{ Auth::user()->name }}</h5>
                @php
                    $user = Auth::user();
                    $roleColors = [
                        'Admin' => 'primary',
                        'Supervisor' => 'secondary',
                        'Petugas' => 'warning',
                        'Member' => 'info'
                    ];
                    $roleColor = $roleColors[$user->role] ?? 'dark';
                @endphp
                <span class="badge bg-{{ $roleColor }}">{{ ucfirst($user->role) }}</span>
            @else
                <h5 class="user-name mb-0 fw-bold">Hello, Guest</h5>
                <span class="badge bg-dark">Guest</span>
            @endauth            
            </a>
            <hr class="dropdown-divider">
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i
              class="material-icons-outlined">person_outline</i>Profile</a>
              
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="material-icons-outlined">power_settings_new</i>Logout
            </a>
          </div>
        </li>
      </ul>
  
    </nav>
  </header>
  <!--end top header-->