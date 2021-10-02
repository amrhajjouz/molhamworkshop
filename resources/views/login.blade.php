<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    
    <!-- Libs CSS -->
    <link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{ asset('fonts/feather/feather.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/highlight-js/styles/vs2015.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/quill/dist/quill.core.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/flatpickr/dist/flatpickr.min.css') }}">
    
    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.rtl.min.css') }}" id="stylesheetLight">
    
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
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    
                    
                    <!-- Email address -->
                    <div class="form-group">
                        <!-- Label -->
                        <label>البريد الالكتروني</label>
                        <!-- Input -->
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="البريد الالكتروني الخاص بحسابك ..">
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label>كلمة المرور</label>
                        
                        <div class="input-group input-group-merge">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control form-control-appended" placeholder="كلمة المرور الخاصة بحسابك ..">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fe fe-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} id="remember">
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
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/chart-js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('libs/highlightjs/highlight.pack.min.js') }}"></script>
    <script src="{{ asset('libs/flatpickr/dist/flatpickr.min.js') }}"></script>
    <script src="{{ asset('libs/jquery-mask-plugin/dist/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('libs/list-js/dist/list.min.js') }}"></script>
    <script src="{{ asset('libs/quill/dist/quill.min.js') }}"></script>
    <script src="{{ asset('libs/dropzone/dist/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('libs/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('libs/chart-js/Chart.extension.min.js') }}"></script>
    <!-- Theme JS -->
    <script src="{{ asset('js/theme.min.js') }}"></script>
</body>

</html>