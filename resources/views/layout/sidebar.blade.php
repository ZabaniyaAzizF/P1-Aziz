<!--start sidebar-->
<aside class="sidebar-wrapper" data-simplebar="true">
  <div class="sidebar-header">
    <?php $setting = App\Models\Settings::get()->first() ?>
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
    <ul class="metismenu" id="sidenav">
      <li>
        <a href="{{ route('Dashboard') }}">
          <div class="parent-icon"><i class="material-icons-outlined">dashboard</i></div>
          <div class="menu-title">Dashboard</div>
        </a>
      </li>

      <li class="menu-label">Menu</li>
      @if (in_array(auth()->user()->role, ['Admin', 'Petugas', 'Supervisor']))
      <li>
        <a class="has-arrow" href="javascript:void(0);">
          <div class="parent-icon"><i class="material-icons-outlined">manage_accounts</i></div>
          <div class="menu-title">Manajemen Data</div>
        </a>
        <ul>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">category</i> Kategori</a></li>
          <li><a href="{{ route('Author.index') }}"><i class="material-icons-outlined">person</i> Author</a></li>
          <li><a href="{{ route('Publisher.index') }}"><i class="material-icons-outlined">apartment</i> Publisher</a></li>
          <li><a href="{{ route('Member.index') }}"><i class="material-icons-outlined">groups</i> Member</a></li>
          <li><a href="{{ route('Promo.index') }}"><i class="material-icons-outlined">discount</i> Promo</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">book</i> Books</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">shopping_cart_checkout</i> Peminjaman</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">assignment_return</i> Pengembalian</a></li>
        </ul>
      </li>
      @endif

      @if (in_array(auth()->user()->role, ['Admin', 'Petugas', 'Supervisor', 'Member']))
      <li>
        <a class="has-arrow" href="javascript:void(0);">
          <div class="parent-icon"><i class="material-icons-outlined">point_of_sale</i></div>
          <div class="menu-title">Transaksi</div>
        </a>
        <ul>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">local_offer</i> Promo</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">book</i> Books</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">shopping_cart_checkout</i> Peminjaman</a></li>
          <li><a href="{{ route('Kategori.index') }}"><i class="material-icons-outlined">assignment_return</i> Pengembalian</a></li>
        </ul>
      </li>
      @endif

      @if (auth()->user()->role == 'Admin')
      <li class="menu-label">Pengaturan Admin</li>
      <li>
        <a class="has-arrow" href="javascript:void(0);">
          <div class="parent-icon"><i class="material-icons-outlined">settings</i></div>
          <div class="menu-title">Pengaturan</div>
        </a>
        <ul>
          <li><a href="{{ route('users.index') }}"><i class="material-icons-outlined">supervisor_account</i> Users</a></li>
          <li><a href="{{ route('Settings') }}"><i class="material-icons-outlined">tune</i> Settings</a></li>
        </ul>
      </li>
      @endif
    </ul>
  </div>
</aside>
<!--end sidebar-->
