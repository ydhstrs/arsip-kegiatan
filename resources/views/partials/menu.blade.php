<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">

        <a href="{{ route('/') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- Logo Here --}}
            </span>
            <span class="app-brand-text text-2xl menu-text fw-bold ms-2">AVour</span>
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

        @role('Administrator')
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Master</span>
            </li>

            <li class=" menu-item {{ request()->is('dashboard/room*') ? 'active' : '' }}">
                <a href="{{ route('room.index') }}" class="menu-link">
                    <i class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M440 424V88h-88V13.005L88 58.522V424H16v32h86.9L352 490.358V120h56v336h88v-32Zm-120 29.642l-200-27.586V85.478L320 51Z" />
                            <path fill="currentColor" d="M256 232h32v64h-32z" />
                        </svg></i>

                    <div data-i18n="Pengguna">Kamar</div>
                </a>
            </li>

            <li class=" menu-item {{ request()->is('dashboard/asset*') ? 'active' : '' }}">
                <a href="{{ route('asset.index') }}" class="menu-link">
                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                            <path fill="currentColor"
                                d="M258 21.89c-.5 0-1.2 0-1.8.12c-4.6.85-10.1 5.1-13.7 14.81c-3.8 9.7-4.6 23.53-1.3 38.34c3.4 14.63 10.4 27.24 18.2 34.94c7.6 7.7 14.5 9.8 19.1 9c4.8-.7 10.1-5.1 13.7-14.7c3.8-9.64 4.8-23.66 1.4-38.35c-3.5-14.8-10.4-27.29-18.2-34.94c-6.6-6.8-12.7-9.22-17.4-9.22M373.4 151.4c-11 .3-24.9 3.2-38.4 8.9c-15.6 6.8-27.6 15.9-34.2 24.5c-6.6 8.3-7.2 14.6-5.1 18.3c2.2 3.7 8.3 7.2 20 7.7c11.7.7 27.5-2.2 43-8.8c15.5-6.7 27.7-15.9 34.3-24.3c6.6-8.3 7.1-14.8 5-18.5c-2.1-3.8-8.3-7.1-20-7.5c-1.6-.3-3-.3-4.6-.3m-136.3 92.9c-6.6.1-12.6.9-18 2.3c-11.8 3-18.6 8.4-20.8 14.9c-2.5 6.5 0 14.3 7.8 22.7c8.2 8.2 21.7 16.1 38.5 20.5c16.7 4.4 32.8 4.3 44.8 1.1c12.1-3.1 18.9-8.6 21.1-15c2.3-6.5 0-14.2-8.1-22.7c-7.9-8.2-21.4-16.1-38.2-20.4c-9.5-2.5-18.8-3.5-27.1-3.4m160.7 58.1L336 331.7c4.2.2 14.7.5 14.7.5l6.6 8.7l54.7-28.5zm-54.5.1l-57.4 27.2c5.5.3 18.5.5 23.7.8l49.8-23.6zm92.6 10.8l-70.5 37.4l14.5 18.7l74.5-44.6zm-278.8 9.1a40.3 40.3 0 0 0-9 1c-71.5 16.5-113.7 17.9-126.2 17.9H18v107.5s11.6-1.7 30.9-1.8c37.3 0 103 6.4 167 43.8c3.4 2.1 10.7 2.9 19.8 2.9c24.3 0 61.2-5.8 69.7-9C391 452.6 494 364.5 494 364.5l-32.5-28.4s-79.8 50.9-89.9 55.8c-91.1 44.7-164.9 16.8-164.9 16.8s119.9 3 158.4-27.3l-22.6-34s-82.8-2.3-112.3-6.2c-15.4-2-48.7-18.8-73.1-18.8" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Aset</div>
                </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Transaski</span>
            </li>
            <li
                class="menu-item {{ request()->is('dashboard/checkin*', 'dashboard/bill*', 'dashboard/checkout*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Income</div>
                </a>
                <ul class="menu-sub">
                    <li class=" menu-item {{ request()->is('dashboard/checkin*') ? 'active' : '' }}">
                        <a href="{{ route('checkin.index') }}" class="menu-link">
                            <div data-i18n="Pengaturan">Check In Penghuni</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('dashboard/bill*') ? 'active' : '' }}">

                        <a href="{{ route('bill.index') }}"class="menu-link">
                            <div data-i18n="Pengaturan">Bill Penghuni</div>
                        </a>
                    </li>
                </ul>
                {{-- <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('dashboard/checkout*') ? 'active' : '' }}">
                        <a href="{{ route('checkout.index') }}"class="menu-link">
                            <div data-i18n="Pengaturan">Checkout Penghuni</div>
                        </a>
                    </li>
                </ul> --}}
            </li>
            <li class="menu-item {{ request()->is('dashboard/buying*', 'dashboard/paying*') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Outcome</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('dashboard/paying*') ? 'active' : '' }}">
                        <a href="{{ route('paying.index') }}"class="menu-link">
                            <div data-i18n="Pengaturan">Pembayaran/Tagihan</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->is('dashboard/buying*') ? 'active' : '' }}">
                        <a href="{{ route('buying.index') }}"class="menu-link">
                            <div data-i18n="Pengaturan">Pembelian</div>
                        </a>
                    </li>
                </ul>

            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Laporan</span>
            </li>
            <li class="menu-item {{ request()->is('dashboard/income') ? 'active' : '' }}">

                <a href="{{ route('income.index') }}" class="menu-link">
                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                            <path fill="none" stroke="currentColor" stroke-linejoin="round"
                                d="M7.563 1.545H2.5v10.91h9V5.364M7.563 1.545L11.5 5.364M7.563 1.545v3.819H11.5m-7 9.136h9v-7M4 7.5h6M4 5h2m-2 5h6" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Uang Masuk</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('dashboard/expense') ? 'active' : '' }}">
                <a href="{{ route('expense.index') }}" class="menu-link">
                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M2.5 1.045a.5.5 0 0 0-.5.5v10.91a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V5.364a.5.5 0 0 0-.152-.36L7.911 1.188a.5.5 0 0 0-.348-.142zm7.766 3.819L8.063 2.727v2.137zM6 5.5H4v-1h2zM10 8H4V7h6zm-6 2.5h6v-1H4z"
                                clip-rule="evenodd" />
                            <path fill="currentColor" d="M13 7.5V14H4.5v1h9a.5.5 0 0 0 .5-.5v-7z" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Uang Keluar</div>
                </a>
            </li>
            <li class="menu-item {{ request()->is('dashboard/profit') ? 'active' : '' }}">

                <a href="{{ route('profit.index') }}" class="menu-link">

                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 32 32">
                            <path fill="currentColor" d="M10 18h8v2h-8zm0-5h12v2H10zm0 10h5v2h-5z" />
                            <path fill="currentColor"
                                d="M25 5h-3V4a2 2 0 0 0-2-2h-8a2 2 0 0 0-2 2v1H7a2 2 0 0 0-2 2v21a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2M12 4h8v4h-8Zm13 24H7V7h3v3h12V7h3Z" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Laba</div>
                </a>
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
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System Management</span>
            </li>
            <li class=" menu-item {{ request()->is('dashboard/roommove*') ? 'active' : '' }}">
                <a href="{{ route('roommove.index') }}" class="menu-link">
                    <i class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 2048 2048">
                            <path fill="currentColor"
                                d="M1792 1120q0 31 9 54t24 44t31 41t31 45t23 58t10 78v480q0 27-10 50t-27 40t-41 28t-50 10H256V0h1408q27 0 50 10t40 27t28 41t10 50v384h-128V128H384v1792h1152v-480q0-45 9-77t24-58t31-46t31-40t23-44t10-55V896h128zm0 320q0-24-4-42t-13-33t-20-29t-27-32q-15 17-26 31t-20 30t-13 33t-5 42v480h128zm256-800v128h-677l162 163l-90 90l-317-317l317-317l90 90l-162 163z" />
                        </svg>
                    </i>

                    <div data-i18n="Pengguna">Pindah Kamar</div>
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
            <li class="menu-item {{ request()->is('users') ? 'open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Pengaturan Sistem">Pengaturan Landing Page</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Pengaturan">Halaman Utama</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="" class="menu-link">
                            <div data-i18n="Pengaturan">Kontak</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endrole
    </ul>
</aside>
