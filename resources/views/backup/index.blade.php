@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

<main class="main-wrapper">
  <div class="main-content">
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Database</div>
      <div class="ms-auto">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0 p-0">
            <li class="breadcrumb-item"><a href="#"><i class="bx bx-home-alt"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Backup & Restore</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Backup & Restore Database Section -->
    <div class="card mb-4">
      <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-database"></i> Backup & Restore Database</h5>
      </div>
      <div class="card-body">
        <p class="mb-3">Gunakan tombol berikut untuk melakukan backup atau mengembalikan database dari file SQL.</p>
        
        <div class="d-flex flex-wrap gap-3">
          <!-- Backup Button -->
          <a href="{{ route('Database.backup') }}" class="btn btn-success">
            <i class="bx bx-cloud-download"></i> Backup Database
          </a>

          <!-- Restore Form -->
          <form action="{{ route('Database.restore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="btn btn-warning mb-0">
              <i class="bx bx-cloud-upload"></i> Restore Database
              <input type="file" name="backup_file" accept=".sql" onchange="this.form.submit()" hidden>
            </label>
          </form>
        </div>

        @if(session('success'))
          <div class="alert alert-success mt-3">
            {{ session('success') }}
          </div>
        @elseif(session('error'))
          <div class="alert alert-danger mt-3">
            {{ session('error') }}
          </div>
        @endif
      </div>
    </div>
    <!-- End Backup & Restore Section -->

  </div>
</main>

@include('layout.footer')

@endsection
