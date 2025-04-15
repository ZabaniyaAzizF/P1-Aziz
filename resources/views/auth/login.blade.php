@extends('layout.template')
@section('content')
<?php  $setting = App\Models\Settings::get()->first() ?>
<!doctype html>
<html lang="en" data-bs-theme="blue-theme">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log In</title>
</head>

<body>

    <!--authentication-->
    <div class="auth-basic-wrapper d-flex align-items-center justify-content-center">
      <div class="container-fluid my-5 my-lg-0">
        <div class="row">
           <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                  <img src="{{ asset('storage/' . $setting->path_logo) }}" class="mb-4" width="145" alt="">
                  <h4 class="fw-bold">LOGIN</h4>
                  <p class="mb-0">Enter your credentials to login your account</p>

                  <div class="form-body my-5">
                    @if(session('failed'))
                      <div class="alert alert-danger">
                          {{ session('failed') }}
                      </div>
                    @endif
                    <form class="row g-3" method="POST" action="{{ route('login-proses') }}">
                      @csrf <!-- Token CSRF untuk keamanan -->
                      <div class="col-12">
                        <label for="inputEmailAddress" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="jhon@example.com" required>
                      </div>
                      <div class="col-12">
                        <label for="inputChoosePassword" class="form-label">Password</label>
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password" required>
                          <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                        </div>
                      </div>
                      <div class="col-12 col-mb-3">
                        <div class="d-grid">
                          <button type="submit" class="btn btn-grd-primary">Login</button>
                        </div>
                      </div>
                    </form>
                  </div>
              </div>
            </div>
           </div>
        </div><!--end row-->
     </div>
    </div>
    <!--authentication-->

    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>

    <script>
      $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
      });
    </script>
  
</body>
</html>