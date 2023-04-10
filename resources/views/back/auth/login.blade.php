<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kafe Yönetim Paneli | Giriş</title>
    @include('_layout.back.include.head')
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Hoşgeldiniz!</h1>
                                </div>
                                <form class="user">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user"
                                               id="email" aria-describedby="emailHelp"
                                               placeholder="E-Posta adresiniz..">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user"
                                               id="password" placeholder="Şifreniz..">
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block loginSubmitBtn">
                                        Giriş Yap
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <button class="btn btn-info btn-user btn-block registerSubmitBtn">
                                        <a class="small text-white" href="{{ route('panel.auth.register') }}">Hesap Oluştur!</a>
                                    </button>

                                </div>
                                <div class="text-center pt-5">

                                        <a class="text-md-center text-decoration-none" href="{{ route('index') }}">Anasayfa'ya Dön</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
@include('_layout.back.include.foot')
<script>
    $(document).ready(function () {
        let email, password;
        $('.loginSubmitBtn').on('click', function (e) {
            e.preventDefault();

            email = $('#email').val();
            password = $('#password').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('panel.auth.login.store') }}',
                data: {email, password},
                success: function (response) {
                    if (response.status) {
                        Toastr.success(response.msg)

                        localStorage.setItem('token', response.token)
                        setTimeout(() => {
                            location.reload()
                        }, 1500)
                    } else {
                        Toastr.error(response.msg)
                    }
                },
                error: function (err) {
                    Toastr.error('Giriş işleminde bir sorun oluştu!')
                }
            })
        })
    })
</script>
</body>
</html>
