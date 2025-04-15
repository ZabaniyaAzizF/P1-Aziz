@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Author</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Author</li>
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
            <h5 class="mb-4">Add/Edit Author</h5>

            <form id="authorForm" action="{{ route('Author.store') }}" method="POST">
              @csrf
              <input type="hidden" id="author_id" name="author_id">
              <?php
                $kodeauthor = autonumber('author', 'kode_author', 3, 'AUT');
              ?>
              <div class="row mb-3">
                <label for="kode_author" class="col-sm-3 col-form-label">Kode Author</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="kode_author" name="kode_author" readonly value="<?= $kodeauthor ?>" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_author" class="col-sm-3 col-form-label">Nama Author</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_author" name="nama_author" required>
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
    <!-- Kategori Table -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Author</h5>
        <a href="{{ route('Author.invoice') }}" class="btn btn-warning"><i class="bx bx-user-plus"></i> Invoice </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Kode Author</th>
                <th>Nama Author</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($author as $item)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $item->kode_author }}</td>
                <td>{{ $item->nama_author }}</td>
                <td>
                @if (auth()->user()->role == 'Supervisor' || auth()->user()->role == 'Admin')
                  <button class="btn btn-warning btn-sm editAuthor" data-id="{{ $item->id }}" data-kode="{{ $item->kode_author }}" data-nama="{{ $item->nama_author }}"><i class="bx bx-edit-alt"></i> Edit</button>
                @endif
                @if (auth()->user()->role == 'Admin')
                  <form action="{{ route('Author.delete', $item->kode_author) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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
    <!-- End Kategori Table -->
  </div>
</main>
<!-- End Main Wrapper -->

@include('layout.footer')

<script>
  document.querySelectorAll('.editAuthor').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('author_id').value = this.dataset.kode;
        document.getElementById('kode_author').value = this.dataset.kode;
        document.getElementById('nama_author').value = this.dataset.nama;
    });
});
</script>

@endsection
