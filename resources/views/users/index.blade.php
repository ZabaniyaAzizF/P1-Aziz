@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Users</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Users Table -->
    <h6 class="mb-3 text-uppercase">Users Table</h6>

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-3">Daftar Pengguna</h5>
        <a href="{{ route('users.invoice') }}" class="btn btn-warning"><i class="bx bx-user-plus"></i> Invoice </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Role</th>
                <td>Di Buat</td>
                <td>Di Update</td>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telepon }}</td>
                <td>{{ $user->alamat }}</td>
                  @php
                      $roleColors = [
                          'admin' => 'primary',
                          'supervisor' => 'secondary',
                          'petugas' => 'warning',
                          'member' => 'info'
                      ];
                  @endphp
                  <span class="badge bg-{{ $roleColors[strtolower($user->role)] ?? 'dark' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td> 
                <td>
                  <button 
                  class="btn btn-warning btn-sm editUsers"
                  data-id="{{ $user->id }}"
                  data-name="{{ $user->name }}"
                  data-email="{{ $user->email }}"
                  data-telepon="{{ $user->telepon }}"
                  data-alamat="{{ $user->alamat }}"
                  data-role="{{ $user->role }}"
                >
                  <i class="bx bx-edit-alt"></i> Edit
                </button>                
                  <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                      <i class="bx bx-trash"></i> Delete
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Users Table -->
  </div>
</main>
<!-- End Main Wrapper -->
<script>
  document.querySelectorAll('.editUsers').forEach(button => {
    button.addEventListener('click', function() {
      document.getElementById('id').value = this.dataset.id;
      document.getElementById('name').value = this.dataset.name;
      document.getElementById('email').value = this.dataset.email;
      document.getElementById('telepon').value = this.dataset.telepon;
      document.getElementById('alamat').value = this.dataset.alamat;
      document.getElementById('role').value = this.dataset.role;
      document.getElementById('password').value = '';
    });
  });
  
  document.getElementById('cancelEdit').addEventListener('click', function() {
    document.getElementById('usersForm').reset();
    document.getElementById('id').value = '';
  });
  </script>  

@include('layout.footer')

@endsection