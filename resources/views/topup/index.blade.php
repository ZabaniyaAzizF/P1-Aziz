@extends('layout.template')

@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Top Up</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Top Up</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->
    <!-- Top Up Table -->
    <div class="card">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Top Up</h5>
        <a href="{{ route('Topup.invoice') }}" class="btn btn-warning"><i class="bx bx-printer"></i> Invoice </a>
      </div>
      <div class="card-body p-4">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode Top Up</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Bukti Transfer</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($topups as $index => $topup)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $topup->kode_topups }}</td>
                <td>{{ number_format($topup->amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($topup->method) }}</td>
                <td>{{ ucfirst($topup->status) }}</td>
                <td>
                  @if ($topup->bukti_transfer)
                    <img src="{{ asset('storage/' . $topup->bukti_transfer) }}" width="50">
                  @endif
                </td>
                <td>
                    <form action="{{ route('Topup.updateStatus', $topup->kode_topups) }}" method="POST" class="d-inline">
                      @csrf
                      @method('PUT')
                      <select class="form-select" name="status" onchange="this.form.submit()" {{ $topup->status != 'pending' ? 'disabled' : '' }}>
                        <option value="pending" {{ $topup->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="success" {{ $topup->status == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="failed" {{ $topup->status == 'failed' ? 'selected' : '' }}>Failed</option>
                      </select>
                    </form>
                  </td>                  
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Top Up Table -->

  </div>
</main>

@endsection
