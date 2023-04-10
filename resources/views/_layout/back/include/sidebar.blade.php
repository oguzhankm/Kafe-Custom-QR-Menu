<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('panel.index') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Yönetim</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(request()->route()->getName() === 'panel.index') active @endif">
        <a class="nav-link" href="{{ route('panel.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Ana Sayfa</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kafe İşlemleri
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item @if(request()->route()->getName() === 'panel.cafe.index') active @endif">
        <a class="nav-link" href="{{ route('panel.cafe.index') }}">
            <i class="fa fa-home"></i>
            <span>Kafeler</span>
        </a>
    </li>
    <li class="nav-item @if(request()->route()->getName() === 'panel.categories.index') active @endif">
        <a class="nav-link" href="{{ route('panel.categories.index') }}">
            <i class="fa fa-list"></i>
            <span>Kategoriler</span>
        </a>
    </li>
    <li class="nav-item @if(request()->route()->getName() === 'panel.products.index') active @endif">
        <a class="nav-link" href="{{ route('panel.products.index') }}">
            <i class="fa fa-shopping-basket"></i>
            <span>Ürünler</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
