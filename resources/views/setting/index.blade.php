@extends('layout.template')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
</head>
<body>
    @include('layout.navbar')
    @include('layout.sidebar')

    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Settings</div>
            </div>
            <!--end breadcrumb-->

            {{-- Settings content --}}
            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update Settings</h5>
                            @if($setting)
                                <form action="{{ route('Settings.update', $setting->id_setting) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label for="path_logo" class="col-sm-3 col-form-label">Upload Logo</label>
                                        <div class="col-sm-9">
                                            <input type="file" class="form-control" id="path_logo" name="path_logo">
                                            @if($setting->path_logo)
                                                <img src="{{ asset('storage/' . $setting->path_logo) }}" alt="Logo" class="mt-2" width="150">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="nama" class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ $setting->nama }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $setting->email }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="telepon" class="col-sm-3 col-form-label">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ $setting->telepon }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="rekening" class="col-sm-3 col-form-label">No Rekening</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="rekening" name="rekening" value="{{ $setting->rekening }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="denda" class="col-sm-3 col-form-label">Denda Keterlambatan</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="denda" name="denda" value="{{ number_format($setting->denda, 0, ',', '.') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="alamat" class="col-sm-3 col-form-label">Address</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $setting->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" class="btn btn-grd-primary px-4">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-warning">
                                    No settings data found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Settings content --}}
        </div>
    </main>
    <!--end main wrapper-->

    @include('layout.footer')
</body>
</html>
@endsection