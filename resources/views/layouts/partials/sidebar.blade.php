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

        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-regular fa-chart-bar"></i>
            </span>
            <span>Dashboard</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-paw"></i>
            </span>
            <span>My Pets</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-shield-cat"></i>
            </span>
            <span>Adoption</span>
        </a>

        <a href="#" class="menu-item">
            <span class="menu-icon">
                <i class="fa-solid fa-user"></i>
            </span>
            <span>Profile</span>
        </a>

        <a href="{{ route('User_Profile.index') }}"
            class="menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <span class="menu-icon">
                <i class="fa-solid fa-gears"></i>
            </span>
            <span>Settings</span>
        </a>

        @if (Auth::user()->type === 'user')
            <a href="{{ route('user.qr.regenerate') }}" class="menu-item">
                <span class="menu-icon">
                    <i class="fa-solid fa-qrcode"></i>
                </span>
                <span>Regenerate QR Code</span>
            </a>
        @else
            <a href="{{ route('admin.qr.regenerate') }}" class="menu-item">
                <span class="menu-icon">
                    <i class="fa-solid fa-qrcode"></i>
                </span>
                <span>Regenerate QR Code</span>
            </a>
        @endif

    </nav>

    <!-- Add Pet -->
    <div class="sidebar-bottom">
        <a href="#" class="add-pet-btn">
            <span>+</span>
            Add New Pet
        </a>
    </div>

</aside>
