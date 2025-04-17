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

    @if (auth()->user()->role == 'Admin' || auth()->user()->role == 'Petugas')
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card">
          <div class="card-body p-4">
            <h5 class="mb-4">{{ isset($topup) ? 'Edit' : 'Add' }} Top Up</h5>

            <form id="topupForm" action="{{ isset($topup) ? route('Topup.update', $topup->kode_topups) : route('Topup.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($topup))
                    @method('PUT')
                @endif
                <input type="hidden" name="kode_topups" value="{{ isset($topup) ? $topup->kode_topups : $kodetopup }}">
                <div class="row mb-3">
                    <label for="kode_topups" class="col-sm-3 col-form-label">Kode Top Up</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="kode_topups_display" readonly value="{{ isset($topup) ? $topup->kode_topups : $kodetopup }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="amount" class="col-sm-3 col-form-label">Jumlah</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ isset($topup) ? $topup->amount : '' }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="method" class="col-sm-3 col-form-label">Metode</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="method" name="method" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="manual" {{ isset($topup) && $topup->method == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="transfer" {{ isset($topup) && $topup->method == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="photo" class="col-sm-3 col-form-label">Bukti Transfer</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        @if (isset($topup) && $topup->bukti_transfer)
                            <br>
                            <img src="{{ asset('storage/' . $topup->bukti_transfer) }}" width="100">
                        @endif
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <label for="status" class="col-sm-3 col-form-label">Status</label>
                    <div class="col-sm-9">
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ isset($topup) && $topup->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="success" {{ isset($topup) && $topup->status == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ isset($topup) && $topup->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                </div> --}}
                <div class="row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="submit" class="btn btn-primary px-4">{{ isset($topup) ? 'Update' : 'Simpan' }}</button>
                    </div>
                </div>
            </form>            
          </div>
        </div>
      </div>
    </div>
    @endif

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
