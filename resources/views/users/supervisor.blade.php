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

    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-4">Add/Edit User Supervisor</h5>
      </div>
      <div class="card-body">
        <form id="usersForm" action="{{ route('users.supervisor.store') }}" method="POST">
          @csrf
          <input type="hidden" id="id" name="id">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Nama</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="telepon" class="form-label">Telepon</label>
              <input type="text" name="telepon" id="telepon" class="form-control">
            </div>
            <div class="col-md-6">
              <label for="alamat" class="form-label">Alamat</label>
              <input type="text" name="alamat" id="alamat" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label">Role</label>
                <input type="text" name="role" id="role" class="form-control" value="Supervisor" required readonly>
            </div> 
            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" id="password" class="form-control">
              <small class="text-danger fw-semibold">Kosongkan jika tidak ingin mengubah password</small>
            </div>      
          </div>

          <div class="mt-3 d-flex gap-2">
            <button type="submit" class="btn btn-grd-primary px-4">Simpan</button>
            <button type="button" id="cancelEdit" class="btn btn-danger px-4">Batal</button>
          </div>          
        </form>
      </div>
    </div>
    <!-- End Form -->

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
                <td>
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