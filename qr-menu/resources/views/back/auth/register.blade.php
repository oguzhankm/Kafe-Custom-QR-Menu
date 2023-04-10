<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Kafe Yönetim Paneli</title>
    @include('_layout.back.include.head')
</head>

<body class="bg-gradient-primary">
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Yeni hesap oluştur!</h1>
                        </div>
                        <form class="user">
                            <div class="form-group row">
                                <div class="col-sm-12 mb-6 mb-sm-0">
                                    <input type="text" class="form-control form-control-user" id="fullname"
                                           placeholder="Adınız ve soyadınız..">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="email"
                                       placeholder="E-Posta adresiniz..">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-6 mb-sm-0">
                                    <input type="password" class="form-control form-control-user"
                                           id="password" placeholder="Şifreniz..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12 mb-6 mb-sm-0">
                                    <button class="btn btn-success btn-block registerSubmitBtn">Kayıt Ol</button>
                                </div>

                            </div>
                        </form>
                        <div class="text-center">
                            <button class="btn btn-info btn-user loginSubmitBtn">
                                <a class="small text-white text-decoration-none" href="{{ route('panel.auth.login') }}">Giriş Yap!</a>
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

@include('_layout.back.include.foot')
<script>
    $(document).ready(function () {
        let email, password, fullname;
        $('.registerSubmitBtn').on('click', function (e) {
            e.preventDefault();

            email = $('#email').val();
            password = $('#password').val();
            fullname = $('#fullname').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('panel.auth.register.store') }}',
                data: {email, password, fullname},
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
                    Toastr.error('Kayıt olma işleminde bir sorun oluştu!')
                }
            })
        })
    })
</script>
</body>
</html>
