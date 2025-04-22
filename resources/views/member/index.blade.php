@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Member</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Member</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->
    <!-- Notifikasi -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Oops!</strong> Ada kesalahan pada inputan kamu:
    <ul class="mb-0 mt-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    <!-- Form Tambah/Edit -->
    <div class="card mb-4">
      <div class="card-header bg-success text-white">
        <h5 class="mb-4">Add/Edit User Member</h5>
      </div>
      <div class="card-body">
        <form id="usersForm" action="{{ route('Member.store') }}" method="POST">
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
                <input type="text" name="role" id="role" class="form-control" value="Member" required readonly>
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
    <!-- member Table -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar member</h5>
        <a href="{{ route('Member.invoice') }}" class="btn btn-warning"><i class="bx bx-user-plus"></i> Invoice </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Member</th>
                <th>Email Member</th>
                <th>Telepon Member</th>
                <th>Alamat Member</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->telepon }}</td>
                <td>{{ $item->alamat }}</td>
                <td>
                @if (auth()->user()->role == 'Supervisor' || auth()->user()->role == 'Admin')
                  <button class="btn btn-warning btn-sm editMember" data-id="{{ $item->id }}" data-kode="{{ $item->id }}" data-nama="{{ $item->nama_member }}"><i class="bx bx-edit-alt"></i> Edit</button>
                @endif
                @if (auth()->user()->role == 'Admin')
                  <form action="{{ route('Member.delete', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus member ini?')">
                      <i class="bx bx-trash"></i> Hapus
                    </button>
                  </form>
                @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End member Table -->
  </div>
</main>
<!-- End Main Wrapper -->

@include('layout.footer')

<script>
  document.querySelectorAll('.editMember').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('member_id').value = this.dataset.kode;
        document.getElementById('kode_member').value = this.dataset.kode; // Tidak diubah
        document.getElementById('nama_member').value = this.dataset.nama;
    });
});
</script>

@endsection
