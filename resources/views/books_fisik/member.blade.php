@extends('layout.template')

@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
    <div class="main-content">

        <!-- Breadcrumb -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Data Buku Fisik</div>
            <div class="ms-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Data Buku Fisik</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Filter Form -->
        <div class="row mb-4">
            <div class="col-md-3">
                <select id="categoryFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $category)
                        <option value="{{ $category->kode_kategori }}">{{ $category->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select id="publisherFilter" class="form-select">
                    <option value="">Semua Penerbit</option>
                    @foreach($publisherList as $publisher)
                        <option value="{{ $publisher->kode_publisher }}">{{ $publisher->nama_publisher }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr class="my-5">

        <h5 class="mb-3">Daftar Buku Fisik</h5>

        <div class="row">
            @forelse($books as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm border-0 book-card" style="transition: all 0.3s ease;">
                    <img 
                        src="{{ asset('storage/uploads/books/photo/' . $book->photo) }}" 
                        class="card-img-top rounded-top" 
                        alt="Foto Buku" 
                        style="cursor: pointer;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#bookModal{{ $book->kode_books_fisik }}"
                    >
                    <div class="card-body text-center">
                        <h6 class="card-title text-truncate mb-0" title="{{ $book->title }}">
                            {{ $book->title }}<br>
                            Rp{{ number_format($book->harga, 0, ',', '.') }}
                        </h6>
                    </div>
                </div>                
            </div>

            <!-- Modal -->
            <div class="modal fade" id="bookModal{{ $book->kode_books_fisik }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $book->kode_books_fisik }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel{{ $book->kode_books_fisik }}">{{ $book->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/uploads/books/photo/' . $book->photo) }}" class="img-fluid" alt="Foto Buku">
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Kategori:</strong> {{ $book->kategori->nama_kategori ?? '-' }}</li>
                                    <li class="list-group-item"><strong>Penerbit:</strong> {{ $book->publisher->nama_publisher ?? '-' }}</li>
                                    <li class="list-group-item"><strong>Pengarang:</strong> {{ $book->author->nama_author ?? '-' }}</li>
                                    <li class="list-group-item"><strong>Harga:</strong> Rp{{ number_format($book->harga, 0, ',', '.') }}</li>
                                    <li class="list-group-item"><strong>ISBN:</strong> {{ $book->isbn ?? '-' }}</li>
                                    <li class="list-group-item"><strong>Deskripsi:</strong> {{ $book->deskripsi ?? '-' }}</li>

                                    <li class="list-group-item">
                                        <strong>Pinjam Buku:</strong>
                                        @if(auth()->user()->role === 'Member')
                                            @php
                                                $latestPeminjaman = $book->peminjaman()->latest()->first();
                                            @endphp

                                            @if($latestPeminjaman && $latestPeminjaman->status == 'dipinjam' && in_array($book->kode_books_fisik, $userPembayaran))
                                                <form method="POST" action="{{ route('Peminjaman.kembalikan', $book->kode_books_fisik) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="kode_books" value="{{ $book->kode_books_fisik }}">
                                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">Kembalikan Buku</button>
                                                </form>                                            
                                            @elseif(!$latestPeminjaman || $latestPeminjaman->status != 'kembalikan')
                                                @if(auth()->user()->saldo >= $book->harga)
                                                    <form method="POST" action="{{ route('Peminjaman.store', $book->kode_books_fisik) }}">
                                                        @csrf
                                                        <input type="hidden" name="kode_books" value="{{ $book->kode_books_fisik }}">
                                                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                                        <label for="tanggal_pinjam">Tanggal Pinjam</label>
                                                        <input type="date" name="tanggal_pinjam" class="form-control mb-2" required>
                                                        <label for="tanggal_kembali">Tanggal Kembali</label>
                                                        <input type="date" name="tanggal_kembali" class="form-control mb-2" required>                                            

                                                        <button type="submit" class="btn btn-sm btn-success">Bayar Rp{{ number_format($book->harga, 0, ',', '.') }}</button>
                                                    </form>
                                                @else
                                                    <span class="text-danger">Saldo tidak cukup</span>
                                                @endif
                                            @endif
                                        @else
                                            <span class="text-muted">Hanya untuk member</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Belum ada data buku.</p>
            </div>
            @endforelse
        </div>

    </div>
</main>

<style>
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(255, 255, 255, 0.15);
    }

    .book-card img {
        object-fit: cover;
        height: 200px;
    }
</style>

@include('layout.footer')

<script>
    document.getElementById('categoryFilter').addEventListener('change', applyFilter);
    document.getElementById('publisherFilter').addEventListener('change', applyFilter);

    function applyFilter() {
        let category = document.getElementById('categoryFilter').value;
        let publisher = document.getElementById('publisherFilter').value;

        let url = new URL('{{ url("Books/member") }}');
        let params = new URLSearchParams(url.search);

        if (category) {
            params.set('category', category);
        } else {
            params.delete('category');
        }

        if (publisher) {
            params.set('publisher', publisher);
        } else {
            params.delete('publisher');
        }

        window.location.href = url.origin + url.pathname + '?' + params.toString();
    }
</script>

@endsection
