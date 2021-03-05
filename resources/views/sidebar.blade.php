@verbatim

<!-- Navigation -->
<ul class="navbar-nav">

    <li class="nav-item">
        <a id="home-nav" class="nav-link" href="{{ $r('home') }}">
            <i class="fe fe-home"></i> البداية
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="javascript:;" data-toggle="collapse" data-target="#volunteers-navs" role="button" aria-expanded="false">
            <i class="fe fe-users"></i> المتطوعين
        </a>
        <div class="collapse" id="volunteers-navs">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ $r('volunteers.add') }}" class="nav-link add-volunteer">
                        متطوع جديد
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('volunteers') }}" class="nav-link volunteers-list">
                        قائمة المتطوعين
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="javascript:;" data-toggle="collapse" data-target="#users-navs" role="button" aria-expanded="false">
            <i class="fe fe-users"></i> المستخدمون
        </a>
        <div class="collapse" id="users-navs">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ $r('users.add') }}" class="nav-link">
                        مستخدم جديد
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('users.list') }}" class="nav-link">
                        قائمة المستخدمين
                    </a>
                </li>
            </ul>
        </div>
    </li>

</ul>

<hr class="navbar-divider my-3">

<ul class="navbar-nav">

    <li class="nav-item">
        <a class="nav-link nav-link" href="{{ $r('profile.info') }}">
            <i class="fe fe-user"></i> معلومات حسابك
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link " href="javascript:;" onclick="var c = confirm('هل أنت متأكد أنك تريد الخروج من حسابك ؟'); if (c) window.location.href = '<?php print route('logout'); ?>';">
            <i class="fe fe-power"></i> تسجيل الخروج
        </a>
    </li>

</ul>

<!-- Push content down -->
<div class="mt-auto"></div>

<!-- User (md) -->
<div class="navbar-user d-none d-md-flex" id="sidebarUser">

    <!-- Dropup -->
    <div class="dropup text-center">

        <!-- Toggle -->
        <a href="#" class="">
            <div class="avatar avatar-sm avatar-online mb-2">
                <img src="<?php print asset('img/avatar.png'); ?>" class="auth-avatar avatar-img rounded-circle" alt="...">
            </div>
        </a>

        <h4 class="auth-name card-title mt-1 mb-1"><?php print Auth::user()->name; ?></h4>
        <p class="auth-role card-text small text-muted"><?php print Auth::user()->name ; ?></p>
    </div>

</div>

@endverbatim
