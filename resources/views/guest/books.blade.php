@extends('layout.template')

@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
    <div class="main-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Data Buku</div>
            <div class="ms-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Form Buku</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="mb-4">{{ isset($book) ? 'Edit Buku' : 'Tambah Buku' }}</h5>

                <form action="{{ isset($book) ? route('Books.update', $book->id) : route('Books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($book)) @method('PUT') @endif
                    <input type="hidden" id="author_id" name="author_id">
                    
                    <?php $kodebooks = autonumber('books', 'kode_books', 5, 'BOK'); ?>

                    <!-- Kode Buku dan Judul Buku -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_books" class="form-label">Kode Buku</label>
                                <input type="text" class="form-control" id="kode_books" name="kode_books" readonly value="<?= $kodebooks ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Kategori dan Penerbit -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kode_kategori" id="kode_kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoriList as $kategori)
                                        <option value="{{ $kategori->kode_kategori }}" {{ (isset($book) && $book->kode_kategori == $kategori->kode_kategori) ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_publisher" class="form-label">Penerbit</label>
                                <select class="form-select" name="kode_publisher" id="kode_publisher" required>
                                    <option value="">Pilih Penerbit</option>
                                    @foreach($publisherList as $publisher)
                                        <option value="{{ $publisher->kode_publisher }}" {{ (isset($book) && $book->kode_publisher == $publisher->kode_publisher) ? 'selected' : '' }}>
                                            {{ $publisher->nama_publisher }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pengarang dan Tipe Buku -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_author" class="form-label">Pengarang</label>
                                <select class="form-select" name="kode_author" id="kode_author" required>
                                    <option value="">Pilih Pengarang</option>
                                    @foreach($authorList as $author)
                                        <option value="{{ $author->kode_author }}" {{ (isset($book) && $book->kode_author == $author->kode_author) ? 'selected' : '' }}>
                                            {{ $author->nama_author }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe Buku</label>
                                <select class="form-select" name="type" id="type" required onchange="toggleFields()">
                                    <option value="fisik" {{ old('type', $book->type ?? '') == 'fisik' ? 'selected' : '' }}>Fisik</option>
                                    <option value="digital" {{ old('type', $book->type ?? '') == 'digital' ? 'selected' : '' }}>Digital</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- File Buku (Digital) dan Lokasi Rak (Fisik) -->
                    <div class="row">
                        <div class="col-md-6" id="fileField" style="display: none;">
                            <div class="mb-3">
                                <label for="file_url" class="form-label">File Buku (PDF)</label>
                                <input type="file" class="form-control" id="file_url" name="file_url">
                                @if(isset($book) && $book->file_url)
                                    <small>File saat ini: <a href="{{ asset('storage/' . $book->file_url) }}" target="_blank">Lihat File</a></small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6" id="rakField" style="display: none;">
                            <div class="mb-3">
                                <label for="lokasi_rak" class="form-label">Lokasi Rak</label>
                                <input type="text" class="form-control" id="lokasi_rak" name="lokasi_rak" value="{{ old('lokasi_rak', $book->lokasi_rak ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Harga dan Stok -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $book->harga ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $book->stock ?? '') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Buku -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Foto Buku</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        @if(isset($book) && $book->photo)
                            <small>Foto saat ini: <img src="{{ asset('storage/' . $book->photo) }}" alt="foto" width="80"></small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>

        <hr class="my-5">

        <h5 class="mb-3">Daftar Buku</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Author</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $index => $book)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $book->publisher->nama_publisher ?? '-' }}</td>
                        <td>{{ $book->author->nama_author ?? '-' }}</td>
                        <td>{{ ucfirst($book->type) }}</td>
                        <td>Rp{{ number_format($book->harga, 0, ',', '.') }}</td>
                        <td>{{ $book->stock }}</td>
                        <td>
                            @if($book->photo)
                                <img src="{{ asset('storage/' . $book->photo) }}" width="50" alt="Foto Buku">
                            @else
                                - 
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('Books.edit', $book->kode_books) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('Books.delete', $book->kode_books) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</main>

@include('layout.footer')

<script>
    function toggleFields() {
        let type = document.getElementById('type').value;
        document.getElementById('fileField').style.display = type === 'digital' ? 'block' : 'none';
        document.getElementById('rakField').style.display = type === 'fisik' ? 'block' : 'none';
    }

    window.addEventListener('load', toggleFields);
</script>

@endsection
