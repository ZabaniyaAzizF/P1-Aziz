@extends('layout.template')
@section('title', Auth::user()->name . ' - Dashboard')
@section('content')
@include('layout.navbar')
@include('layout.sidebar')

<!--start main wrapper-->
<main class="main-wrapper">
  <div class="main-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
      <div class="breadcrumb-title pe-3">Dashboard</div>
    </div>
    <!--end breadcrumb-->

    {{-- content --}}
    <div class="row g-4" id="dashboard-cards">
      <div class="col-12">
        <div class="text-center" id="loading-message">
          <p class="text-muted">Memuat data dashboard...</p>
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
    {{-- end content --}}
  </div>
</main>
<!--end main wrapper-->

<!--start overlay-->
<div class="overlay btn-toggle"></div>
<!--end overlay-->

<!--start footer-->
@include('layout.footer')
<!--end footer-->

{{-- script --}}
<script>
  document.addEventListener('DOMContentLoaded', function () {
    fetch('/dashboard/data')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('dashboard-cards');
        const loadingMessage = document.getElementById('loading-message');
        loadingMessage.style.display = 'none';
  
        container.innerHTML = '';
  
        const createCard = (icon, value, label, color) => {
          return `
            <div class="col-12 col-sm-6 col-xl-3 d-flex">
              <div class="card rounded-4 shadow-sm w-100">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="icon-box bg-${color} bg-opacity-10 text-${color} rounded-circle d-flex align-items-center justify-content-center" style="width: 64px; height: 64px; font-size: 32px;">
                      <i class="bi bi-${icon}"></i> <!-- Menggunakan tag <i> untuk icon -->
                    </div>
                    <span class="badge bg-light text-light">${label}</span>
                  </div>
                  <div class="text-end">
                    <h4 class="mb-0 fw-bold text-light">${value}</h4>
                  </div>
                </div>
              </div>
            </div>`;
        };
  
        if (data.totalUsers !== undefined) {
          container.innerHTML += createCard("person-circle", data.totalUsers, "Total Akun Pengguna", "primary");
          container.innerHTML += createCard("book", data.totalBuku, "Total Buku", "success");
          container.innerHTML += createCard("tags", data.totalKategori, "Total Kategori", "info");
          container.innerHTML += createCard("tag", data.totalPromo, "Promo Aktif", "warning");
        } else {
          container.innerHTML += createCard("book", data.totalPeminjaman, "Jumlah Peminjaman", "primary");
          container.innerHTML += createCard("wallet", `Rp ${Number(data.totalSaldo).toLocaleString("id-ID")}`, "Saldo Anda", "success");
          container.innerHTML += createCard("credit-card", data.totalTopUp, "Histori Top Up", "info");
          container.innerHTML += createCard("gift", data.totalPromo, "Promo Tersedia", "warning");
        }
      })
      .catch(error => {
        console.error('Gagal memuat data:', error);
        const container = document.getElementById('dashboard-cards');
        const loadingMessage = document.getElementById('loading-message');
        loadingMessage.style.display = 'none';
  
        container.innerHTML = `
          <div class="col-12">
            <div class="alert alert-danger text-center">Gagal memuat data dashboard. Coba lagi nanti.</div>
          </div>`;
      });
  });
  </script>  
@endsection
