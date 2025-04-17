@extends('layout.template')
@section('content')

@include('layout.navbar')
@include('layout.sidebar')

  <!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
      <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
              <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Invoice</li>
            </ol>
          </nav>
        </div>
      </div>
      <!--end breadcrumb-->
      <div class="card radius-10 shadow-sm" id="printArea">
        <div class="card-header py-4 d-flex justify-content-between align-items-center border-bottom">
          <?php  $setting = App\Models\Settings::get()->first() ?>
          <div class="d-flex align-items-center">
            <img src="{{ asset('storage/' . $setting->path_logo) }}" alt="Logo" class="mt-2" width="120">
            <div class="ms-4">
              <h5 class="mb-0">{{ $setting->nama }}</h5>
              <p class="mb-0">{{ $setting->email }} | {{ $setting->telepon }}</p>
              <p class="mb-0">{{ $setting->alamat }}</p>
            </div>
          </div>
          <button onclick="printInvoice()" class="btn btn-primary" id="printButton"><i class="bi bi-printer"></i> Print</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Kategori</th>
                  <th>Nama Kategori</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kategori as $item)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{ $item->kode_kategori }}</td>
                  <td>{{ $item->nama_kategori }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <hr>
        </div>

        <div class="card-footer py-4 bg-light text-center" id="printFooter">
          <p class="mb-1">THANK YOU FOR YOUR BUSINESS</p>
          <p class="mb-0">
            <span><i class="bi bi-globe"></i> {{ $setting->email }}</span> | 
            <span><i class="bi bi-envelope-fill"></i> {{ $setting->alamat }}</span>
          </p>
        </div>
      </div>
    </div>
  </main>
  <!--end main wrapper-->

@include('layout.footer')

<script>
  function printInvoice() {
    document.getElementById('printButton').style.display = 'none'; // Sembunyikan tombol print
    var printContents = document.getElementById('printArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = '<div style="width: 210mm; min-height: 297mm; padding: 20px; font-family: Arial, sans-serif;">' + printContents + '</div>';

    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}
</script>

@endsection
