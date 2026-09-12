<!-- Sidebar -->
<aside class="sidebar">

    <!-- Logo -->
    <div class="logo">
        <div class="logo-icon">
            <i class="fa-solid fa-paw"></i>
        </div>
        <div>
            <h2>PetCare</h2>
            <span>Pet Management</span>
        </div>
    </div>

    <!-- Menu -->
    <nav class="sidebar-menu">

        @if (Auth::user()->type === 'admin')
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="menu-icon">
                    <i class="fa-regular fa-chart-bar"></i>
                </span>
                <span>Dashboard</span>
            </a>
        @endif

        <a href="{{ route('Pet.index') }}" class="menu-item {{ request()->routeIs('Pet.index') ? 'active' : '' }}">
            <span class="menu-icon">
                <i class="fa-solid fa-paw"></i>
            </span>
            <span>My Pets</span>
        </a>

        <a href="{{ route('adoptions.index') }}"
            class="menu-item {{ request()->routeIs('adoption.*', 'adoptions.*') ? 'active' : '' }}">
            <span class="menu-icon">
                <i class="fa-solid fa-shield-cat"></i>
            </span>
            <span>Adoption</span>
        </a>

        <a href="{{ route('Profile.index') }}" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user"></i>
            </span>
            <span>Profile</span>
        </a>

        {{-- <a href="{{ route('settings.account') }}"
            class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <span class="menu-icon">
                <i class="fa-solid fa-gears"></i>
            </span>
            <span>Settings</span>
        </a> --}}

        <form method="POST" action="{{ route('qr.regenerate') }}" id="sidebarRegenerateQrForm" style="margin: 0;">
            @csrf
            <button type="submit" class="menu-item" style="width: 100%; border: none; background: transparent; text-align: left; cursor: pointer; font-family: inherit; font-size: inherit; color: inherit;" onclick="return confirm('Generate and email a fresh login QR code to {{ Auth::user()->email ?? 'your email' }}?');">
                <span class="menu-icon">
                    <i class="fa-solid fa-qrcode"></i>
                </span>
                <span>Send / Regenerate QR</span>
            </button>
        </form>

    </nav>

    <!-- Add Pet -->
    <div class="sidebar-bottom">
        <a href="{{ route('Pet.create') }}" class="add-pet-btn">
            <span>+</span>
            Add New Pet
        </a>
    </div>

</aside>
