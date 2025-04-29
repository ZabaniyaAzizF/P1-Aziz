@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Buku</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku</li>
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

            <form id="bookForm" action="{{ route('Books_digital.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="book_id" name="book_id">
            <?php $kodeBook = autonumber('books_digital', 'kode_books_digital', 5, 'BKD'); ?>

            <!-- Kode Buku -->
            <div class="row mb-3">
                <label for="kode_books_digital" class="col-sm-3 col-form-label">Kode Buku</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="kode_books_digital" name="kode_books_digital" readonly value="<?= $kodeBook ?>" required>
                </div>
            </div>

            <!-- Judul Buku -->
            <div class="row mb-3">
                <label for="title" class="col-sm-3 col-form-label">Judul Buku</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
            </div>

            <!-- Kategori -->
            <div class="row mb-3">
                <label for="kode_kategori" class="col-sm-3 col-form-label">Kategori</label>
                <div class="col-sm-9">
                    <select class="form-select" id="kode_kategori" name="kode_kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $kat)
                        <option value="{{ $kat->kode_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Author -->
            <div class="row mb-3">
                <label for="kode_author" class="col-sm-3 col-form-label">Author</label>
                <div class="col-sm-9">
                    <select class="form-select" id="kode_author" name="kode_author" required>
                        <option value="">-- Pilih Author --</option>
                        @foreach ($authors as $auth)
                        <option value="{{ $auth->kode_author }}">{{ $auth->nama_author }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Publisher -->
            <div class="row mb-3">
                <label for="kode_publisher" class="col-sm-3 col-form-label">Publisher</label>
                <div class="col-sm-9">
                    <select class="form-select" id="kode_publisher" name="kode_publisher" required>
                        <option value="">-- Pilih Publisher --</option>
                        @foreach ($publishers as $pub)
                        <option value="{{ $pub->kode_publisher }}">{{ $pub->nama_publisher }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Harga -->
            <div class="row mb-3">
                <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="harga" name="harga" step="0.01" required>
                </div>
            </div>

            <!-- Upload File Buku -->
            <div class="row mb-3">
                <label for="file_book" class="col-sm-3 col-form-label">Upload File Buku</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="file_book" name="file_book">
                </div>
            </div>

            <!-- Cover Buku -->
            <div class="row mb-3">
                <label for="photo" class="col-sm-3 col-form-label">Cover Buku</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="photo" name="photo">
                </div>
            </div>

            <!-- Submit Button -->
            <div class="row">
                <div class="col-sm-9 offset-sm-3">
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
        <h5 class="mb-3">Daftar Buku</h5>
        <a href="{{ route('Books_digital.invoice') }}" class="btn btn-warning"><i class="bx bx-bookmark-plus"></i> Invoice </a>
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
                    data-id="{{ $book->kode_books_digital }}"
                    data-title="{{ $book->title }}"
                    data-kategori="{{ $book->kategori->kode_kategori }}"
                    data-author="{{ $book->author->kode_author }}"
                    data-publisher="{{ $book->publisher->kode_publisher }}"
                    data-harga="{{ $book->harga }}">
                    Edit
                    </button>
                    <button type="button" class="btn btn-info btn-sm btn-detail" 
                    data-id="{{ $book->kode_books_digital }}"
                    data-title="{{ $book->title }}"
                    data-kategori="{{ $book->kategori->nama_kategori }}"
                    data-author="{{ $book->author->nama_author }}"
                    data-publisher="{{ $book->publisher->nama_publisher }}"
                    data-harga="{{ $book->harga }}"
                    data-photo="{{ $book->photo ? asset('storage/' . $book->photo) : '' }}">
                    Detail
                    </button>   
                <form action="{{ route('Books_digital.delete', $book->kode_books_digital) }}" method="POST" style="display:inline;">
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
                    <strong>Judul Buku:</strong>
                    <p id="detailTitle"></p>
                </div>
                <div class="mb-3">
                    <strong>Kategori:</strong>
                    <p id="detailKategori"></p>
                </div>
                <div class="mb-3">
                    <strong>Author:</strong>
                    <p id="detailAuthor"></p>
                </div>
                <div class="mb-3">
                    <strong>Publisher:</strong>
                    <p id="detailPublisher"></p>
                </div>
                <div class="mb-3">
                    <strong>Harga:</strong>
                    <p id="detailHarga"></p>
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
            const kode_books_digital = event.target.dataset.id;
            const title = event.target.dataset.title;
            const kode_kategori = event.target.dataset.kategori;
            const kode_author = event.target.dataset.author;
            const kode_publisher = event.target.dataset.publisher;
            const harga = event.target.dataset.harga;
            const photo = event.target.dataset.photo;

            // Isi form edit
            document.getElementById('kode_books_digital').value = kode_books_digital;
            document.getElementById('title').value = title;
            document.getElementById('harga').value = harga;

            // Set selected option
            document.querySelector('#kode_kategori option[value="' + kode_kategori + '"]').selected = true;
            document.querySelector('#kode_author option[value="' + kode_author + '"]').selected = true;
            document.querySelector('#kode_publisher option[value="' + kode_publisher + '"]').selected = true;

            // Ubah action ke update
            const updateUrl = "/Books_digital/" + kode_books_digital;
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
            const file_url = event.target.dataset.file_url;
            const photo = event.target.dataset.photo;

            document.getElementById('detailTitle').innerText = title;
            document.getElementById('detailKategori').innerText = kategori;
            document.getElementById('detailAuthor').innerText = author;
            document.getElementById('detailPublisher').innerText = publisher;
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
        document.getElementById('bookForm').reset();  // Reset form
        document.getElementById('kode_books_digital').value = '';  // Kosongkan kode buku
    });
</script>  

@endsection
