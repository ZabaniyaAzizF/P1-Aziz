<!doctype html>
<html lang="en" data-bs-theme="{{ session('theme', 'blue-theme') }}"> <!-- Tema dinamis -->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('admin/assets/images/favicon.ico') }}" type="image/x-icon">
  
  <!-- Loader-->
  <link href="{{ asset('admin/css/pace.min.css') }}" rel="stylesheet">
  <script src="{{ asset('admin/js/pace.min.js') }}"></script>

  <!-- Plugins -->
  <link href="{{ asset('admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/metismenu/metisMenu.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/metismenu/mm-vertical.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/simplebar/css/simplebar.css') }}">

  <!-- Bootstrap CSS -->
  <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/css/extra-icons.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&amp;display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- Main CSS -->
  <link href="{{ asset('admin/css/bootstrap-extended.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/sass/main.css') }}" rel="stylesheet">
  
  <!-- Theme Styles -->
  <link href="{{ asset('admin/sass/dark-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/sass/blue-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/sass/semi-dark.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/sass/bordered-theme.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/sass/responsive.css') }}" rel="stylesheet">
</head>

<body style="background-image: url('{{ asset('admin/assets/images/bg-themes/body-background-1.webp') }}'); background-size: cover; background-repeat: no-repeat;">
  <div>
    @yield('content')
  </div>

  <!-- Plugins -->
  <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
  <!-- Bootstrap JS -->
  <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Plugins -->
  <script src="{{ asset('admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('admin/plugins/metismenu/metisMenu.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
  <script src="{{ asset('admin/js/main.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('admin/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
  
  <script>
    $(document).ready(function() {
      var table = $('#example2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
      });

      table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>
</html>
