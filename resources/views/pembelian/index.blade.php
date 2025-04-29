@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<!-- Start Main Wrapper -->
<main class="main-wrapper">
  <div class="main-content">

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Pembelian</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Pembelian</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Pembelian Table -->
    <h6 class="mb-3 text-uppercase">Pembelian Buku Digital</h6>

    <div class="card">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-3">Daftar Pembelian</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example2" class="table table-striped table-hover table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Buku</th>
                <th>Nama Member</th>
                <th>Tanggal Beli</th>
                <th>Status Pembayaran</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($peminjamans as $peminjam)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $peminjam->buku ? $peminjam->buku->title : 'N/A' }}</td>
                <td>{{ $peminjam->user ? $peminjam->user->name : 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($peminjam->tanggal_pinjam)->format('d M Y') }}</td>
                <td>
                    @if($peminjam->status === 'lunas')
                      <span class="badge bg-success">Lunas</span>
                    @else
                      <span class="badge bg-danger">Belum Lunas</span>
                    @endif
                  </td>                  
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Peminjaman Table -->
  </div>
</main>
<!-- End Main Wrapper -->

@include('layout.footer')

@endsection
