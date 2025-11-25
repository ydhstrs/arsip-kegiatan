<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <a href="{{ route('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- Logo Here --}}
            </span>
            <span class="app-brand-text text-2xl menu-text fw-bold ms-2">sipptrantibum</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="align-middle bx bx-chevron-left bx-sm"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">

        {{-- Admin --}}
        <li class="menu-item {{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="#" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>
        
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
            @csrf
        </form>
        

        @role('Administrator')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Admin</span>
            </li>

            <li class=" menu-item {{ request()->is('dashboard/admin/letter*') ? 'active' : '' }}">
                <a href="{{ route('admin.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Surat</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kabid</span>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/kabid/letter*') ? 'active' : '' }}">
                <a href="{{ route('kabid.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Surat</div>
                </a>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/kabid/letter*') ? 'active' : '' }}">
                <a href="{{ route('kabid.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Laporan</div>
                </a>
            </li>

            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Kasi</span>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/kasi/letter*') ? 'active' : '' }}">
                <a href="{{ route('kasi.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Surat</div>
                </a>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/room*') ? 'active' : '' }}">
                <a href="{{ route('kabid.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Laporan</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Staff</span>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/room*') ? 'active' : '' }}">
                <a href="{{ route('staff.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Surat Masuk</div>
                </a>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/room*') ? 'active' : '' }}">
                <a href="{{ route('staff.letter.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Laporan</div>
                </a>
            </li>


            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Management</span>
            </li>
            <li class="menu-item {{ request()->is('log') ? 'active' : '' }}">
                <a href="{{ route('log.index') }}" class="menu-link">
                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M10 18h8v2h-8zm0-5h12v2H10zm0 10h5v2h-5z" />
                            <path fill="currentColor"
                                d="M25 5h-3V4a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v1H7a2 2 0 0 0-2 2v21a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2M12 4h8v4h-8Zm13 24H7V7h3v3h12V7h3Z" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Log Aktivitas</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Pengaturan Sistem</div>
                </a>

                {{-- <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Pengaturan">Pengaturan</div>
                        </a>
                    </li>
                </ul> --}}
                <ul class="menu-sub">
                    <li class=" menu-item {{ request()->is('dashboard/user*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}"class="menu-link">

                            <div data-i18n="Pengaturan">Akun</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole
        @role('Admin')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Admin</span>
        </li>

        <li class=" menu-item {{ request()->is('dashboard/admin/letter*') ? 'active' : '' }}">
            <a href="{{ route('admin.letter.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Surat</div>
            </a>
        </li>
        @endrole
        @role('Kabid')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Kasat</span>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kasat/letter*') ? 'active' : '' }}">
            <a href="{{ route('kasat.letter.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Surat</div>
            </a>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kasat/report*') ? 'active' : '' }}">
            <a href="{{ route('kasat.report.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Laporan</div>
            </a>
        </li>
        @endrole
        @role('Kabid')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Kabid</span>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kabid/letter*') ? 'active' : '' }}">
            <a href="{{ route('kabid.letter.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Surat</div>
            </a>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kabid/report*') ? 'active' : '' }}">
            <a href="{{ route('kabid.report.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Laporan</div>
            </a>
        </li>
        @endrole
        @role('Kasi')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Kasi</span>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kasi/letter*') ? 'active' : '' }}">
            <a href="{{ route('kasi.letter.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Surat</div>
            </a>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/kasi/report*') ? 'active' : '' }}">
            <a href="{{ route('kasi.report.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Laporan</div>
            </a>
        </li>
        @endrole
        @role('Staff')
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Staff</span>
        </li>
        <li class="menu-item {{ request()->is('dashboard/staff/letter*') ? 'active' : '' }}">
            <a href="{{ route('staff.letter.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Surat</div>
            </a>
        </li>
        <li class=" menu-item {{ request()->is('dashboard/staff/report*') ? 'active' : '' }}">
            <a href="{{ route('staff.report.index') }}" class="menu-link">
                <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                        viewBox="0 0 512 512">
                        <path fill="currentColor"
                            d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                        <path fill="currentColor" d="M256 232h32v64h-32z" />
                    </svg></i>

                <div data-i18n="Pengguna">Laporan</div>
            </a>
        </li>
        @endrole
    </ul>
</aside>
