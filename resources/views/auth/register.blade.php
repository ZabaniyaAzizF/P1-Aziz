@extends('layout.template')
@section('content')
<?php  $setting = App\Models\Settings::get()->first() ?>
<!doctype html>
<html lang="en" data-bs-theme="blue-theme">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
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
            <h4 class="fw-bold">REGISTER</h4>
            <p class="mb-0">Fill the form below to create your account</p>

            <div class="form-body my-5">
              @if(session('failed'))
                <div class="alert alert-danger">
                  {{ session('failed') }}
                </div>
              @endif
              <form class="row g-3" method="POST" action="{{ route('register.store') }}">
                @csrf <!-- Token CSRF -->
              
                <div class="col-12">
                  <label for="inputName" class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" id="inputName" placeholder="Your Name" required>
                </div>
              
                <div class="col-12">
                  <label for="inputEmail" class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email@example.com" required>
                </div>
              
                <div class="col-12">
                  <label for="inputPhone" class="form-label">Phone Number</label>
                  <input type="text" name="telepon" class="form-control" id="inputPhone" placeholder="081234567890" required>
                </div>
              
                <div class="col-12">
                  <label for="inputPassword" class="form-label">Password</label>
                  <div class="input-group" id="show_hide_password">
                    <input type="password" name="password" class="form-control border-end-0" id="inputPassword" placeholder="Enter Password" required>
                    <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                  </div>
                </div>
              
                <div class="col-12">
                  <label for="inputPasswordConfirm" class="form-label">Confirm Password</label>
                  <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirm" placeholder="Confirm Password" required>
                </div>
              
                <div class="col-12 col-mb-3">
                  <div class="d-grid">
                    <button type="submit" class="btn btn-grd-primary">Register</button>
                  </div>
                </div>
              </form>              
            </div>
            <h5>Already have an account? <a href="{{ route('login') }}">Log In!</a></h5>
          </div>
        </div>
      </div>
    </div><!--end row-->
  </div>
</div>
<!--authentication-->

<!--plugins-->
<script src="{{ asset('admin/js/jquery.min.js') }}"></script>

<script>
  $(document).ready(function () {
    $("#show_hide_password a").on('click', function (event) {
      event.preventDefault();
      const input = $('#show_hide_password input');
      const icon = $('#show_hide_password i');
      if (input.attr("type") == "text") {
        input.attr('type', 'password');
        icon.addClass("bi-eye-slash-fill").removeClass("bi-eye-fill");
      } else {
        input.attr('type', 'text');
        icon.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
      }
    });
  });
</script>

</body>
</html>
@endsection
