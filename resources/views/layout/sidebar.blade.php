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
      @auth
        @php
          $user = auth()->user();

          $menu = [];

          // Dashboard selalu muncul
          $menu[] = [
            'label' => null,
            'items' => [
              [
                'title' => 'Dashboard',
                'icon' => 'dashboard',
                'route' => 'Dashboard',
              ],
            ]
          ];

          // Menu Manajemen Data
          if (in_array($user->role, ['Admin', 'Petugas', 'Supervisor'])) {
            $menu[] = [
              'label' => 'Menu',
              'items' => [
                [
                  'title' => 'Manajemen Data',
                  'icon' => 'manage_accounts',
                  'children' => [
                    ['title' => 'Kategori', 'icon' => 'category', 'route' => 'Kategori.index'],
                    ['title' => 'Author', 'icon' => 'person', 'route' => 'Author.index'],
                    ['title' => 'Publisher', 'icon' => 'apartment', 'route' => 'Publisher.index'],
                    ['title' => 'Books', 'icon' => 'book', 'route' => 'Books.index'],
                    ['title' => 'Promo', 'icon' => 'local_offer', 'route' => 'Promo.index'],
                  ]
                ]
              ]
            ];
          }

          // Transaksi berdasarkan role
          if (in_array($user->role, ['Admin', 'Petugas', 'Supervisor'])) {
            $menu[] = [
              'label' => null,
              'items' => [
                [
                  'title' => 'Transaksi',
                  'icon' => 'point_of_sale',
                  'children' => [
                    ['title' => 'Top Up', 'icon' => 'local_offer', 'route' => 'Topup.index'],
                    ['title' => 'Peminjaman', 'icon' => 'shopping_cart_checkout', 'route' => 'Peminjaman.index'],
                    ['title' => 'Pengembalian', 'icon' => 'assignment_return', 'route' => 'Pengembalian.index'],
                  ]
                ]
              ]
            ];
          }

          if ($user->role === 'Member') {
            $menu[] = [
              'label' => null,
              'items' => [
                [
                  'title' => 'Transaksi',
                  'icon' => 'point_of_sale',
                  'children' => [
                    ['title' => 'Buku', 'icon' => 'book', 'route' => 'Member.books.index'],
                    ['title' => 'Promo ', 'icon' => 'local_offer', 'route' => 'Promo.member.index'],
                    ['title' => 'Top Up', 'icon' => 'local_offer', 'route' => 'Topup.member.index'],
                    ['title' => 'Riwayat Peminjaman', 'icon' => 'shopping_cart_checkout', 'route' => 'Member.Peminjaman.index'],
                    ['title' => 'Riwayat Pengembalian', 'icon' => 'assignment_return', 'route' => 'Member.Pengembalian.index'],
                  ]
                ]
              ]
            ];
          }

          // Pengaturan Admin
          if ($user->role === 'Admin') {
            $menu[] = [
              'label' => 'Pengaturan Admin',
              'items' => [
                [
                  'title' => 'Pengaturan',
                  'icon' => 'admin_panel_settings',
                  'children' => [
                    ['title' => 'Semua Users', 'icon' => 'people', 'route' => 'users.index'],
                    ['title' => 'Users Admin', 'icon' => 'security', 'route' => 'users.admin.index'],
                    ['title' => 'Users Supervisor', 'icon' => 'supervised_user_circle', 'route' => 'users.supervisor.index'],
                    ['title' => 'Users Petugas', 'icon' => 'badge', 'route' => 'users.petugas.index'],
                    ['title' => 'Users Member', 'icon' => 'groups', 'route' => 'Member.index'],
                    ['title' => 'Settings', 'icon' => 'settings_applications', 'route' => 'Settings'],
                  ]
                ]
              ]
            ];
          }
        @endphp

        {{-- Looping Sidebar --}}
        @foreach ($menu as $section)
          @if ($section['label'])
            <li class="menu-label">{{ $section['label'] }}</li>
          @endif
          @foreach ($section['items'] as $item)
            @if (isset($item['children']))
              <li>
                <a class="has-arrow" href="javascript:void(0);">
                  <div class="parent-icon"><i class="material-icons-outlined">{{ $item['icon'] }}</i></div>
                  <div class="menu-title">{{ $item['title'] }}</div>
                </a>
                <ul>
                  @foreach ($item['children'] as $child)
                    <li>
                      <a href="{{ route($child['route']) }}">
                        <i class="material-icons-outlined">{{ $child['icon'] }}</i> {{ $child['title'] }}
                      </a>
                    </li>
                  @endforeach
                </ul>
              </li>
            @else
              <li>
                <a href="{{ route($item['route']) }}">
                  <div class="parent-icon"><i class="material-icons-outlined">{{ $item['icon'] }}</i></div>
                  <div class="menu-title">{{ $item['title'] }}</div>
                </a>
              </li>
            @endif
          @endforeach
        @endforeach
      @endauth    

      @guest
        {{-- Menu untuk Guest --}}
        <li>
          <a href="{{ route('Books.index') }}">
            <div class="parent-icon"><i class="material-icons-outlined">book</i></div>
            <div class="menu-title">Books</div>
          </a>
        </li>
      @endguest
    </ul>
  </div>
</aside>
<!--end sidebar-->
