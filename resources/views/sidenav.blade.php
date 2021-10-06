@verbatim

<include-sidenav></include-sidenav>

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
    <div class="text-center">

        <!-- Toggle -->
        <a href="{{ $r('profile.info') }}">
            <div class="avatar avatar-sm avatar-online mb-2">
                <img src="<?php print asset('img/avatar.png'); ?>" class="auth-avatar avatar-img rounded-circle" alt="...">
            </div>
        </a>

        <h4 class="auth-name card-title mt-1 mb-1"><?php print Auth::user()->name; ?></h4>
        <p class="auth-role card-text small text-muted" dir="ltr">@<?php print substr(Auth::user()->email, 0, strpos(Auth::user()->email, '@')) ; ?></p>
    </div>

</div>

@endverbatim
