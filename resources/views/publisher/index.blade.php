@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">publisher</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Publisher</li>
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
            <h5 class="mb-4">Add/Edit Publisher</h5>

            <form id="publisherForm" action="{{ route('Publisher.store') }}" method="POST">
              @csrf
              <input type="hidden" id="publisher_id" name="publisher_id">
              <?php
                $kodepublisher = autonumber('publisher', 'kode_publisher', 3, 'PUB');
              ?>
              <div class="row mb-3">
                <label for="kode_publisher" class="col-sm-3 col-form-label">Kode Publisher</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="kode_publisher" name="kode_publisher" readonly value="<?= $kodepublisher ?>" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="nama_publisher" class="col-sm-3 col-form-label">Nama Publisher</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="nama_publisher" name="nama_publisher" required>
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
    <!-- publisher Table -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-3">Daftar publisher</h5>
        <a href="{{ route('Publisher.invoice') }}" class="btn btn-warning"><i class="bx bx-user-plus"></i> Invoice </a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Kode publisher</th>
                <th>Nama publisher</th>
                <td>Di Buat</td>
                <td>Di Update</td>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($publisher as $item)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $item->kode_publisher }}</td>
                <td>{{ $item->nama_publisher }}</td>
                <td>{{ $item->created_at }}</td>
                <td>{{ $item->updated_at }}</td> 
                <td>
                @if (auth()->user()->role == 'Supervisor' || auth()->user()->role == 'Admin')
                  <button class="btn btn-warning btn-sm editPublisher" data-id="{{ $item->id }}" data-kode="{{ $item->kode_publisher }}" data-nama="{{ $item->nama_publisher }}"><i class="bx bx-edit-alt"></i> Edit</button>
                @endif
                @if (auth()->user()->role == 'Admin')
                  <form action="{{ route('Publisher.delete', $item->kode_publisher) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus publisher ini?')">
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
    <!-- End publisher Table -->
  </div>
</main>
<!-- End Main Wrapper -->

@include('layout.footer')

<script>
  document.querySelectorAll('.editPublisher').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('publisher_id').value = this.dataset.kode;
        document.getElementById('kode_publisher').value = this.dataset.kode;
        document.getElementById('nama_publisher').value = this.dataset.nama;
    });
});
</script>

@endsection
