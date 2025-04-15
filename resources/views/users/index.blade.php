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
    <div class="mb-3">
      <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bx bx-user-plus"></i> Tambah Pengguna</a>
      <a href="{{ route('users.invoice') }}" class="btn btn-primary"><i class="bx bx-user-plus"></i> Invoice </a>
    </div>

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Pengguna</h5>
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
                          'guru' => 'secondary',
                          'supervisor' => 'warning',
                          'petugas' => 'info'
                      ];
                  @endphp
                  <span class="badge bg-{{ $roleColors[$user->role] ?? 'dark' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td>
                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                    <i class="bx bx-edit-alt"></i> Edit
                  </a>
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

@include('layout.footer')

@endsection
