@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
  <div class="main-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Promo</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Promo</li>
          </ol>
        </nav>
      </div>
    </div>

    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-body p-4">
            <h5 class="mb-4">Add/Edit Promo</h5>

            <form id="promoForm" action="{{ route('Promo.store') }}" method="POST">
              @csrf
              <input type="hidden" id="promo_id" name="promo_id">

              <?php
                $kodepromo = autonumber('promo', 'kode_promo', 3, 'PRM');
              ?>
              <div class="row mb-3">
                <label for="kode_promo" class="col-sm-3 col-form-label">Kode Promo</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="kode_promo" name="kode_promo" readonly value="<?= $kodepromo ?>" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="type" class="col-sm-3 col-form-label">Tipe Promo</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="type" name="type" required>
                </div>
              </div>  

              <div class="row mb-3">
                <label for="discount" class="col-sm-3 col-form-label">Diskon (%)</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="discount" name="discount" step="0.01" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="start_date" class="col-sm-3 col-form-label">Tanggal Mulai</label>
                <div class="col-sm-9">
                  <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="end_date" class="col-sm-3 col-form-label">Tanggal Selesai</label>
                <div class="col-sm-9">
                  <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                </div>
              </div>

              <div class="row mb-3">
                <label for="kode_kategori" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                  <select class="form-control" name="kode_kategori" id="kode_kategori">
                    <option value="">-- Semua --</option>
                    @foreach ($kategoriList as $kategori)
                      <option value="{{ $kategori->kode_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row mb-3">
                <label for="kode_author" class="col-sm-3 col-form-label">Author</label>
                <div class="col-sm-9">
                  <select class="form-control" name="kode_author" id="kode_author">
                    <option value="">-- Semua --</option>
                    @foreach ($authorList as $author)
                      <option value="{{ $author->kode_author }}">{{ $author->nama_author }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row mb-3">
                <label for="kode_publisher" class="col-sm-3 col-form-label">Publisher</label>
                <div class="col-sm-9">
                  <select class="form-control" name="kode_publisher" id="kode_publisher">
                    <option value="">-- Semua --</option>
                    @foreach ($publisherList as $publisher)
                      <option value="{{ $publisher->kode_publisher }}">{{ $publisher->nama_publisher }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <div class="row mb-3">
                <label for="user_id" class="col-sm-3 col-form-label">Member</label>
                <div class="col-sm-9">
                  <select class="form-control" name="user_id" id="user_id">
                    <option value="">-- Semua --</option>
                    @foreach ($memberList as $member)
                      <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
                

              <div class="row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                  <button type="submit" class="btn btn-grd-primary px-4">Simpan</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    @endif

    <!-- Promo Table -->
    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Promo</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tipe</th>
                <th>Diskon (%)</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($promo as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->kode_promo }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->discount }}</td>
                <td>{{ $item->start_date }}</td>
                <td>{{ $item->end_date }}</td>
                <td>
                  @if (auth()->user()->role == 'Supervisor' || auth()->user()->role == 'Admin')
                  <button class="btn btn-warning btn-sm editPromo"
                    data-id="{{ $item->kode_promo }}"
                    data-type="{{ $item->type }}"
                    data-discount="{{ $item->discount }}"
                    data-start="{{ $item->start_date }}"
                    data-end="{{ $item->end_date }}">
                    <i class="bx bx-edit-alt"></i> Edit
                  </button>
                  @endif
                  @if (auth()->user()->role == 'Admin')
                  <form action="{{ route('Promo.delete', $item->kode_promo) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus promo ini?')">
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
    <!-- End Promo Table -->

  </div>
</main>

@include('layout.footer')

<script>
  document.querySelectorAll('.editPromo').forEach(button => {
    button.addEventListener('click', function () {
      document.getElementById('promo_id').value = this.dataset.id;
      document.getElementById('kode_promo').value = this.dataset.id;
      document.getElementById('type').value = this.dataset.type;
      document.getElementById('discount').value = this.dataset.discount;
      document.getElementById('start_date').value = this.dataset.start;
      document.getElementById('end_date').value = this.dataset.end;
    });
  });
</script>

@endsection
