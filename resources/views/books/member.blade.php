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
                        <li class="breadcrumb-item active" aria-current="page">Data Buku</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Form Filter -->
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
            {{-- <div class="col-md-3">
                <select id="publisherFilter" class="form-select">
                    <option value="">Semua Author</option>
                    @foreach(authorList as $author)
                        <option value="{{ $author->kode_author }}">{{ $author->nama_author }}</option>
                    @endforeach
                </select>
            </div> --}}
        </div>

        <hr class="my-5">

        <h5 class="mb-3">Daftar Buku</h5>

        <div class="row">
            @forelse($books as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/uploads/books/photo/' . $book->photo) }}" class="card-img-top" alt="Foto Buku" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->kode_books }}">
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="bookModal{{ $book->kode_books }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $book->kode_books }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel{{ $book->kode_books }}">{{ $book->title }}</h5>
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
                                    <li class="list-group-item"><strong>File Buku:</strong> <a href="{{ asset('storage/uploads/books/pdf/' . $book->file_book) }}" target="_blank">Lihat File</a></li>
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
                </tbody>
            </table>
        </div>

    </div>
</main>

@include('layout.footer')

<script>
    document.getElementById('categoryFilter').addEventListener('change', applyFilter);
    document.getElementById('publisherFilter').addEventListener('change', applyFilter);

    function applyFilter() {
        let category = document.getElementById('categoryFilter').value;
        let publisher = document.getElementById('publisherFilter').value;

        // Construct the URL with query parameters
        let url = new URL('{{ url("Books/member") }}'); // Using Blade to get the base URL
        let params = new URLSearchParams(url.search); // Get current query parameters if any

        // Set or update the query parameters
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

        // Reload the page with the updated query parameters
        window.location.href = url.origin + url.pathname + '?' + params.toString();
    }
</script>

@endsection
