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
        <a class="nav-link text-danger" href="javascript:;" onclick="var c = confirm('هل أنت متأكد أنك تريد الخروج من حسابك ؟'); if (c) window.location.href = '<?php print route('logout'); ?>';">
            <i class="fe fe-power"></i> تسجيل الخروج
        </a>
    </li>

</ul>


@endverbatim
