<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">

    <!-- Libs CSS -->
    <link rel="stylesheet" href="{{ asset('fonts/feather/feather.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">


    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme-rtl.css?t=2') }}" id="styleMode">



    <title>تسجيل الدخول</title>
</head>

<body class="d-flex align-items-center">


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
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                class="form-control form-control-appended" placeholder="كلمة المرور الخاصة بحسابك ..">
                            <div class="input-group-text">
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

    <!-- Libs JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- Theme JS -->
    <script src="{{ asset('js/theme.js?v=7') }}"></script>
</body>

</html>
