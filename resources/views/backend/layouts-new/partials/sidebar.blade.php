<style>
    .active-title {
        color: #white !important;
    }


    .menu-inner {
        background: #3da601;
    }

    .menu-vertical .menu-item .menu-link {
        color: white
    }

    .menu .app-brand.demo {
        height: 64px;
        margin-top: 12px;
        margin-bottom: 12px;
    }
    html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item.open > .menu-link, .layout-menu-hover.layout-menu-collapsed .bg-menu-theme .menu-inner .menu-item.open > .menu-link, html:not(.layout-menu-collapsed) .bg-menu-theme .menu-inner .menu-item .menu-link:not(.active):hover, .layout-menu-hover.layout-menu-collapsed .bg-menu-theme .menu-inner .menu-item .menu-link:not(.active):hover {
        color: white!important;
        background-color: rgba(67, 89, 113, 0.04);
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
    style="    border-right: 3px solid rgb(114 113 113 / 52%);">
    <div class="app-brand demo ">
        <a href="#" class="app-brand-link">
            <img src="{{ asset('assets/img/logos/logo.png') }}" style="max-width: 35%">
            <span class=" demo fw-bold ms-2" style="color: black">Dashboard</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    @php
        $usr = Auth::guard('admin')->user();
        if ($usr != null) {
            $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        }

    @endphp

    <div class="menu-inner-shadow" style="background: #3da601!Important"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item mb-2">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
     

        <li class="menu-item {{ Request::routeIs('admin/pengeluaran-pakan') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
                <i class="menu-icon tf-icons fa-solid fa-money-bill-1-wave"></i>
                <div data-i18n="Layouts">Pengeluaran</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('admin/pengeluaran-pakan') ? 'active' : '' }}">
                    <a href="{{ route('pengeluaran-pakan') }}" class="menu-link">
                        <div data-i18n="Without menu"
                            style="color : {{ Request::routeIs('admin/pengeluaran-pakan') ? '#3da601' : '' }}">Pakan
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ Request::routeIs('admin/pakan') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-cheese"></i>
                <div data-i18n="Layouts">Management Pakan</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('admin/pakan') || Request::routeIs('admin/inventory') || Request::routeIs('mix-pakan') ? 'active' : '' }}">
                    <a href="{{ route('inventory') }}" class="menu-link">
                        <div data-i18n="Without menu"
                            style="color : {{ Request::routeIs('admin/inventory') ? '#3da601' : '' }}">Inventory
                        </div>
                    </a>
                    <a href="{{ route('mix-pakan') }}" class="menu-link">
                        <div data-i18n="Without menu"
                            style="color : {{ Request::routeIs('mix-pakan') ? '#3da601' : '' }}">Mix Pakan
                        </div>
                    </a>
                    <a href="{{ route('pakan') }}" class="menu-link">
                        <div data-i18n="Without menu"
                            style="color : {{ Request::routeIs('admin/pakan') ? '#3da601' : '' }}">Pakan
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item mb-2">
            <a href="{{ route('supplier') }}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-boxes-packing"></i>
                <div data-i18n="Dashboard">Supplier</div>
            </a>
        </li>
        <li class="menu-item mb-2">
            <a href="{{ route('satuan') }}" class="menu-link">
                <i class="menu-icon tf-icons fa-regular fa-rectangle-list"></i>
                <div data-i18n="Dashboard">Satuan</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('admin/admins') || Request::routeIs('admin/roles') ? 'open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Management Users</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('admin/admins') ? 'active' : '' }}">
                    <a href="{{ route('admin.admins.index') }}" class="menu-link">
                        <div data-i18n="Without menu"
                            style="color : {{ Request::routeIs('admin/admins') ? '#3da601' : '' }}">Users
                        </div>
                    </a>
                </li>

            </ul>
        </li>

    </ul>
</aside>
