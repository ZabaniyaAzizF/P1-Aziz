@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Buku Fisik</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku Fisik</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->
    
    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="mb-4 text-primary">Add/Edit Buku</h5>
    
                    <form action="{{ isset($book) ? route('Books_fisik.update', $book->kode_books_fisik) : route('Books_fisik.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($book))
                            @method('PUT')
                        @endif
                        <?php $kodeBook = autonumber('books_fisik', 'kode_books_fisik', 5, 'BKF'); ?>
                        
                        <div class="row g-3">
                            <!-- Kode Buku -->
                            <div class="col-md-6">
                                <label for="kode_books_fisik" class="form-label">Kode Buku</label>
                                <input type="text" class="form-control" id="kode_books_fisik" name="kode_books_fisik"
                                    value="{{ old('kode_books_fisik', $book->kode_books_fisik ?? $kodeBook) }}" readonly required>
                            </div>
                    
                            <!-- Judul Buku -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $book->title ?? '') }}" required>
                            </div>
                    
                            <!-- ISBN -->
                            <div class="col-md-6">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn"
                                    value="{{ old('isbn', $book->isbn ?? '') }}">
                            </div>
                    
                            <!-- Harga -->
                            <div class="col-md-6">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="harga" name="harga" step="0.01"
                                    value="{{ old('harga', $book->harga ?? '') }}" required>
                            </div>
                    
                            <!-- Kategori -->
                            <div class="col-md-6">
                                <label for="kode_kategori" class="form-label">Kategori</label>
                                <select class="form-select" id="kode_kategori" name="kode_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $kat)
                                        <option value="{{ $kat->kode_kategori }}" {{ old('kode_kategori', $book->kode_kategori ?? '') == $kat->kode_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Author -->
                            <div class="col-md-6">
                                <label for="kode_author" class="form-label">Author</label>
                                <select class="form-select" id="kode_author" name="kode_author" required>
                                    <option value="">-- Pilih Author --</option>
                                    @foreach ($authors as $auth)
                                        <option value="{{ $auth->kode_author }}" {{ old('kode_author', $book->kode_author ?? '') == $auth->kode_author ? 'selected' : '' }}>
                                            {{ $auth->nama_author }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Publisher -->
                            <div class="col-md-6">
                                <label for="kode_publisher" class="form-label">Publisher</label>
                                <select class="form-select" id="kode_publisher" name="kode_publisher" required>
                                    <option value="">-- Pilih Publisher --</option>
                                    @foreach ($publishers as $pub)
                                        <option value="{{ $pub->kode_publisher }}" {{ old('kode_publisher', $book->kode_publisher ?? '') == $pub->kode_publisher ? 'selected' : '' }}>
                                            {{ $pub->nama_publisher }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Cover Buku -->
                            <div class="col-md-6">
                                <label for="photo" class="form-label">Cover Buku</label>
                                <input type="file" class="form-control" id="photo" name="photo">
                                @if(isset($book) && $book->photo)
                                    <img src="{{ asset('storage/'.$book->photo) }}" width="100" class="mt-2" alt="Cover Buku">
                                @endif
                            </div>
                    
                            <!-- Deskripsi -->
                            <div class="col-12">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $book->deskripsi ?? '') }}</textarea>
                            </div>
                    
                            <!-- Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    @endif    

    <!-- Books Table -->
    <h6 class="mb-3 text-uppercase">Books Table</h6>

    <div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-3">Daftar Buku Fisik</h5>
        <a href="{{ route('Books_fisik.invoice') }}" class="btn btn-warning"><i class="bx bx-bookmark-plus"></i> Invoice </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
        <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Kategori</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Harga</th>
                <td>Photo</td>
                <td>Di Buat</td>
                <td>Di Update</td>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($books as $book)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->kategori->nama_kategori }}</td>
                <td>{{ $book->author->nama_author }}</td>
                <td>{{ $book->publisher->nama_publisher }}</td>
                <td>Rp {{ number_format($book->harga, 0, ',', '.') }}</td>
                <td>
                    <img src="{{ asset('storage/uploads/books/photo/' . $book->photo) }}" width="50" class="img-thumbnail" data-bs-toggle="modal" data-bs-target="#photoModal" data-bs-src="{{ asset('storage/uploads/books/photo/' . $book->photo) }}">
                </td>
                <td>{{ $book->created_at }}</td>
                <td>{{ $book->updated_at }}</td> 
                <td>
                    <button type="button" class="btn btn-warning btn-sm btn-edit" 
                    data-id="{{ $book->kode_books_fisik }}"
                    data-title="{{ $book->title }}"
                    data-kategori="{{ $book->kategori->kode_kategori }}"
                    data-author="{{ $book->author->kode_author }}"
                    data-publisher="{{ $book->publisher->kode_publisher }}"
                    data-harga="{{ $book->harga }}"
                    data-deskripsi="{{ $book->deskripsi }}">
                    Edit
                    </button>
                    <button type="button" class="btn btn-info btn-sm btn-detail" 
                    data-id="{{ $book->kode_books_fisik }}"
                    data-title="{{ $book->title }}"
                    data-kategori="{{ $book->kategori->nama_kategori }}"
                    data-author="{{ $book->author->nama_author }}"
                    data-publisher="{{ $book->publisher->nama_publisher }}"
                    data-harga="{{ $book->harga }}"
                    data-deskripsi="{{ $book->deskripsi }}"
                    data-photo="{{ $book->photo ? asset('storage/' . $book->photo) : '' }}">
                    Detail
                    </button>   
                <form action="{{ route('Books_fisik.delete', $book->kode_books_fisik) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">
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
  </div>
</main>
<!-- End Main Wrapper -->
<!-- Modal untuk menampilkan gambar besar -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoModalLabel">Cover Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalPhoto" src="" alt="Cover Buku" class="img-fluid w-100">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Detail Buku -->
<div class="modal fade" id="bookDetailModal" tabindex="-1" aria-labelledby="bookDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookDetailModalLabel">Detail Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Judul Buku :</strong>
                    <p id="detailTitle"></p>
                </div>
                <div class="mb-3">
                    <strong>Kategori :</strong>
                    <p id="detailKategori"></p>
                </div>
                <div class="mb-3">
                    <strong>Author :</strong>
                    <p id="detailAuthor"></p>
                </div>
                <div class="mb-3">
                    <strong>Publisher :</strong>
                    <p id="detailPublisher"></p>
                </div>
                <div class="mb-3">
                    <strong>Harga :</strong>
                    <p id="detailHarga"></p>
                </div>
                <div class="mb-3">
                    <strong>Deskripsi :</strong>
                    <p id="detailDeskripsi"></p>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@include('layout.footer')
<script>
    document.querySelector('table').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn-edit')) {
            const kode_books_fisik = event.target.dataset.id;
            const title = event.target.dataset.title;
            const kode_kategori = event.target.dataset.kategori;
            const kode_author = event.target.dataset.author;
            const kode_publisher = event.target.dataset.publisher;
            const harga = event.target.dataset.harga;
            const deskripsi = event.target.dataset.deskripsi;
            const photo = event.target.dataset.photo;

            // Isi form edit
            document.getElementById('kode_books_fisik').value = kode_books_fisik;
            document.getElementById('title').value = title;
            document.getElementById('harga').value = harga;
            document.getElementById('deskripsi').value = deskripsi;

            // Set selected option
            document.querySelector('#kode_kategori option[value="' + kode_kategori + '"]').selected = true;
            document.querySelector('#kode_author option[value="' + kode_author + '"]').selected = true;
            document.querySelector('#kode_publisher option[value="' + kode_publisher + '"]').selected = true;

            // Ubah action ke update
            const updateUrl = "/Books_fisik/" + kode_books_fisik;
            document.getElementById('bookForm').setAttribute('action', updateUrl);

            // Tambahkan method PUT jika belum ada
            if (!document.querySelector('#bookForm input[name="_method"]')) {
                const methodInput = document.createElement('input');
                methodInput.setAttribute('type', 'hidden');
                methodInput.setAttribute('name', '_method');
                methodInput.setAttribute('value', 'PUT');
                document.getElementById('bookForm').appendChild(methodInput);
            }
        }

        if (event.target && event.target.classList.contains('btn-detail')) {
            const title = event.target.dataset.title;
            const kategori = event.target.dataset.kategori;
            const author = event.target.dataset.author;
            const publisher = event.target.dataset.publisher;
            const harga = event.target.dataset.harga;
            const deskripsi = event.target.dataset.deskripsi;
            const photo = event.target.dataset.photo;

            document.getElementById('detailTitle').innerText = title;
            document.getElementById('detailKategori').innerText = kategori;
            document.getElementById('detailAuthor').innerText = author;
            document.getElementById('detailPublisher').innerText = publisher;
            document.getElementById('detailDeskripsi').innerText = deskripsi;
            document.getElementById('detailHarga').innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');


            const modal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
            modal.show();
        }
    });

    document.querySelector('table').addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('img-thumbnail')) {
            const imageUrl = event.target.getAttribute('data-bs-src');
            document.getElementById('modalPhoto').setAttribute('src', imageUrl);
        }
    });

    // Menangani klik tombol batal
    document.getElementById('cancelEdit').addEventListener('click', function() {
        document.getElementById('bookForm').reset();
        document.getElementById('kode_books_fisik').value = '';
    });
</script>  

@endsection
