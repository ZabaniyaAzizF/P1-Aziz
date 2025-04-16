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
    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-body p-4">
            <h5 class="mb-4">Add/Edit member</h5>

            <form id="memberForm" action="{{ route('Member.store') }}" method="POST">
              @csrf
              <input type="hidden" id="member_id" name="member_id">
              <div class="row mb-3">
                <label for="nama_member" class="col-sm-3 col-form-label">Nama member</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_member" name="nama_member" required>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                  <div class="d-md-flex d-grid align-items-center gap-3">
                    <button type="submit" class="btn btn-grd-primary px-4">Simpan</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif
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
                <th>Kode member</th>
                <th>Nama member</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($member as $item)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $item->kode_member }}</td>
                <td>{{ $item->nama_member }}</td>
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
