@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
  <div class="main-content">

    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Promo Buku</div>
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
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-4 text-primary">Tambah/Edit Promo</h5>
        <form id="promoForm" action="{{ route('Promo.store') }}" method="POST">
          @csrf
          <input type="hidden" id="kode_promo" name="kode_promo" value="{{ old('kode_promo', $kodePromo ?? '') }}">
          <?php $kodePromo = autonumber('promos', 'kode_promo', 3, 'PRM'); ?>

          <!-- Kode Promo -->
          <div class="mb-3">
            <label for="kode_promo">Kode Promo</label>
            <input type="text" class="form-control" name="kode_promo" readonly value="{{ $kodePromo }}">
          </div>

          <div class="mb-3">
            <label for="nama">Nama Promo</label>
            <input type="text" class="form-control" name="nama" required>
          </div>

          <!-- Type Promo -->
          <div class="mb-3">
            <label for="type">Type Promo</label>
            <select class="form-select" name="type" id="type" required onchange="updateRefOptions()">
              <option value="">-- Pilih Type --</option>
              <option value="kategori">Kategori</option>
              <option value="author">Author</option>
              <option value="publisher">Publisher</option>
              <option value="member">Member</option>
            </select>
          </div>

          <!-- Ref ID -->
          <div class="mb-3" id="refSelectContainer">
            <label for="ref_id">Referensi</label>
            <select class="form-select" name="ref_id" id="ref_id" required>
              <option value="">-- Pilih Referensi --</option>
            </select>
          </div>

          <!-- Discount -->
          <div class="mb-3">
            <label for="discount">Diskon (%)</label>
            <input type="number" class="form-control" name="discount" required>
          </div>

          <!-- Tanggal -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="start_date">Mulai</label>
              <input type="date" class="form-control" name="start_date" required>
            </div>
            <div class="col-md-6">
              <label for="end_date">Selesai</label>
              <input type="date" class="form-control" name="end_date" required>
            </div>
          </div>

          <!-- Button -->
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
    @endif

    <!-- Tabel Promo -->
    <div class="card mt-4">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-3">Daftar Promo</h5>
        @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
          <a href="{{ route('Promo.invoice') }}" class="btn btn-warning"><i class="bx bx-bookmark-plus"></i> Invoice </a>
        @endif
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table  id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Kode Promo</th>
                <th>Type</th>
                <th>Referensi</th>
                <th>Diskon</th>
                <th>Periode</th>
                @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
                <th>Aksi</th>              
                @endif
              </tr>
            </thead>
            <tbody>
              @foreach ($promos as $promo)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $promo->kode_promo }}</td>
                <td>{{ ucfirst($promo->type) }}</td>
                <td>
                  @if ($promo->type == 'kategori')
                    {{ $promo->kategori->nama_kategori }}
                  @elseif ($promo->type == 'author')
                    {{ $promo->author->nama_author }}
                  @elseif ($promo->type == 'publisher')
                    {{ $promo->publisher->nama_publisher }}
                  @elseif ($promo->type == 'member')
                    {{ $promo->member->name }}
                  @endif
                </td>
                <td>{{ $promo->discount }}%</td>
                <td>{{ $promo->start_date }} - {{ $promo->end_date }}</td>
                @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
                <td>
                  <!-- Edit & Delete -->
                  <form action="{{ route('Promo.delete', $promo->kode_promo) }}" method="POST" onsubmit="return confirm('Yakin hapus promo ini?')" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                  </form>
                </td>
                @endif
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</main>

@include('layout.footer')

<script>
  const kategori = @json($kategori);
  const authors = @json($authors);
  const publishers = @json($publishers);
  const members = @json($members);

  function updateRefOptions() {
    const type = document.getElementById('type').value;
    const refSelect = document.getElementById('ref_id');

    let options = '<option value="">-- Pilih Referensi --</option>';
    let data = [];

    switch (type) {
      case 'kategori':
        data = kategori;
        data.forEach(item => {
          options += `<option value="${item.kode_kategori}">${item.nama_kategori}</option>`;
        });
        break;
      case 'author':
        data = authors;
        data.forEach(item => {
          options += `<option value="${item.kode_author}">${item.nama_author}</option>`;
        });
        break;
      case 'publisher':
        data = publishers;
        data.forEach(item => {
          options += `<option value="${item.kode_publisher}">${item.nama_publisher}</option>`;
        });
        break;
      case 'member':
        data = members;
        data.forEach(item => {
          options += `<option value="${item.id}">${item.name}</option>`;
        });
        break;
      default:
        // Kosongin kalau type tidak valid
        break;
    }

    refSelect.innerHTML = options;
  }

  // Optional: isi otomatis jika value lama ada (untuk form edit)
  document.addEventListener('DOMContentLoaded', function () {
    updateRefOptions();
  });
</script>
@endsection
