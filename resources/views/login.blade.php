<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme-rtl.css') }}" id="stylesheetLight">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" id="stylesheetLight">



    <title>تسجيل الدخول</title>
</head>

<body dir="rtl" class="d-flex align-items-center bg-auth border-top border-top-2 border-primary">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5 col-xl-4 my-5">
                <!-- Heading -->
                <h1 class="display-4 text-center mb-3">
                    تسجيل الدخول
                </h1>

                <!-- Subheading -->
                <p class="text-muted text-center mb-5">
                    تسجيل الدخول الى لوحة التحكم
                </p>

                <!-- Form -->
                <form method="post" action="{{ route('login') }}">

                    {{ csrf_field() }}

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            البريد الالكتروني أو كلمة المرور غير صحيحين !!
                            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    @endif


                    <!-- Email address -->
                    <div class="form-group">
                        <!-- Label -->
                        <label class="form-label">البريد الالكتروني</label>
                        <!-- Input -->
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                            placeholder="البريد الالكتروني الخاص بحسابك ..">
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">كلمة المرور</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" value="{{ old('password') }}"
                                class="form-control" placeholder="كلمة المرور الخاصة بحسابك ..">
                            <div class="input-group-text" id="inputGroup">
                                <i class="fe fe-eye"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                {{ old('remember') ? 'checked' : '' }} id="remember">
                            <label class="form-check-label" for="remember">
                                تذكرني
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-lg btn-block btn-primary mb-3">
                        تسجيل الدخول
                    </button>

                </form>
            </div>
        </div>
    </div>

    <!-- Theme JS -->
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
