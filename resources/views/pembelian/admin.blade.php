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
          <table id="example2" class="table table-striped table-hover table-bordered table-sm">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Nama Buku</th>
                <th>Nama Member</th>
                <th>Tanggal Beli</th>
                <th>Status Pembayaran</th>
                <td>Di Buat</td>
                <td>Di Update</td>
              </tr>
            </thead>
            <tbody>
              @foreach ($pembelians as $pembelian)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembelian->buku_digital ? $pembelian->buku_digital->title : 'N/A' }}</td>
                <td>{{ $pembelian->user ? $pembelian->user->name : 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($pembelian->tanggal_beli)->format('d M Y') }}</td>
                <td>
                    @if($pembelian->status === 'lunas')
                      <span class="badge bg-success">Lunas</span>
                    @endif
                </td>
                <td>{{ $pembelian->created_at }}</td>
                <td>{{ $pembelian->updated_at }}</td> 
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Pembelian Table -->
  </div>
</main>
<!-- End Main Wrapper -->

@include('layout.footer')

@endsection
