@verbatim

<include-sidenav></include-sidenav>

<hr class="navbar-divider my-3">

<ul class="navbar-nav">

    <li class="nav-item">
        <a class="nav-link" href="javascript:;" data-toggle="collapse" data-target="#profile-navs" role="button" aria-expanded="false">
            <i class="fe fe-user"></i>  معلومات حسابك
        </a>
        <div class="collapse" id="profile-navs">
            <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                    <a href="{{ $r('profile.info') }}" class="nav-link">
                        الملف الشخصي
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('user_family_members') }}" class="nav-link">
                        أفراد العائلة
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('user_work_experiences') }}" class="nav-link">
                        خبرات العمل
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('user_skills') }}" class="nav-link">
                        المهارات
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('user_languages') }}" class="nav-link">
                        اللغات
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('user_trainings') }}" class="nav-link">
                        التدريبات
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ $r('leaves') }}" class="nav-link">
                        الإجازات
                    </a>
                </li>
            </ul>
        </div>
    </li>

     <li class="nav-item">
          <a class="nav-link" href="{{ $r('profile.my_info') }}">
                    <i class="fe fe-user"></i>معلومات الحساب
          </a>
     </li>

    <li class="nav-item">
        <a class="nav-link" href="javascript:;" onclick="var c = confirm('هل أنت متأكد أنك تريد الخروج من حسابك ؟'); if (c) window.location.href = '<?php print route('logout'); ?>';">
            <i class="fe fe-power"></i> تسجيل الخروج
        </a>
    </li>


</ul>

<!-- Push content down -->
<div class="mt-auto"></div>

<!-- User (md) -->
<div class="navbar-user d-none d-md-flex" id="sidenavUser">

    <!-- Dropup -->
    <div class="dropup text-center">

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
