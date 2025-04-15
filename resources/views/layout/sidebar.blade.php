<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <?php  $setting = App\Models\Settings::get()->first() ?>
      <div class="logo-icon">
        <img src="{{ asset('storage/' . $setting->path_logo) }}" class="logo-img" alt="">
      </div>
      <div class="logo-name flex-grow-1">
        <h5 class="mb-0">{{ $setting->nama }}</h5>
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
          <li>
            <a href="{{ route('Dashboard') }}">
              <div class="parent-icon"><i class="material-icons-outlined">home</i>
              </div>
              <div class="menu-title">Dashboard</div>
            </a>
          </li>
          <li class="menu-label">Menu</li>
          @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas'
          || auth()->user()->role == 'Supervisor' || auth()->user()->role == 'Member')
          <li>
            <a href="{{ route('Kategori.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Kategori</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Merk.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Author</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Ruangan.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Publisher</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Barang.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Member</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Meja.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Promo</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Pengajuan.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Books</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Pengaduan.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Peminjaman</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Pengaduan.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Pengembalian</div>
            </a>
          </li>
          @endif
          @if (auth()->user()->role == 'Admin')
          <li class="menu-label">Pengaturan Admin</li>
          <li>
            <a href="{{ route('users.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Users</div>
            </a>
          </li>
          <li>
            <a href="{{ route('Settings') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Settings</div>
            </a>
          </li>
          @endif
         </ul>
        <!--end navigation-->
    </div>
  </aside>
  <!--end sidebar-->