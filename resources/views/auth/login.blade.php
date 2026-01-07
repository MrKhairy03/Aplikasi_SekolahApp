<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sekolah App | Sistem Informasi Sekolah</title>

    <link rel="icon" href="{{ asset('assets/img/Logo_SekolahApp.png') }}" type="image/png">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-success">

    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card o-hidden border-0 shadow-lg my-5 w-75">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block p-0">
                        <img src="{{ asset('assets/img/BG_Login.png') }}" alt="Login Background"
                            class="img-fluid h-100 w-100" style="object-fit: cover;">
                    </div>

                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang</h1>
                                <p class="text-gray-600 mb-4">
                                    Sistem Informasi Sekolah App : mengelola siswa, guru, dan kelas. Silakan login untuk
                                    melanjutkan.
                                </p>
                            </div>

                            <form action="{{ route('login') }}" method="POST" class="user">
                                @csrf
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="form-group">
                                    <input name="email" type="email" class="form-control form-control-user"
                                        id="email" value="{{ old('email') }}" aria-describedby="emailHelp"
                                        placeholder="Masukkan Email Anda..." required autofocus>
                                </div>

                                <div class="form-group">
                                    <input name="password" type="password" class="form-control form-control-user"
                                        id="password" placeholder="Masukkan Password" required>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input name="remember" type="checkbox" class="custom-control-input"
                                            id="customCheck" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck">
                                            Ingat Saya
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    Masuk
                                </button>

                                <hr>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
