<!-- Navbar -->
<header class="navbar">
    <div class="search-box">
        <span><i class="fa-solid fa-magnifying-glass"></i></span>
        <input type="text" placeholder="Search...">
    </div>
    <div class="navbar-right">
        <button class="nav-icon" aria-label="Notifications">
            <i class="fa-solid fa-bell"></i>
            <span class="notification-dot"></span>
        </button>
        <button class="nav-icon" aria-label="Messages">
            <i class="fa-regular fa-comment-dots"></i>
        </button>

        @auth
            <!-- User Profile Dropdown -->
            <div class="nav-profile-dropdown" id="navProfileDropdown">
                <button type="button" class="nav-profile" id="navProfileBtn" aria-expanded="false" aria-haspopup="true">
                    <div class="profile-avatar">
                        @if (Auth::user()->images && Auth::user()->images->isNotEmpty())
                            <img src="{{ asset('storage/uploads/attachments/user/' . Auth::user()->id . '/' . Auth::user()->images->first()->filename) }}"
                                alt="{{ Auth::user()->name }}"
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="profile-info">
                        <strong>{{ Auth::user()->name }}</strong>
                        @if (Auth::user()->type === 'user')
                            <span>Pet Owner</span>
                        @else
                            <span>Doctor</span>
                        @endif
                    </div>
                    <span class="profile-arrow">⌄</span>
                </button>

                <div class="profile-menu" id="navProfileMenu">
                    <div class="profile-menu-header">
                        <strong>{{ Auth::user()->name }}</strong>
                        <small>{{ Auth::user()->email }}</small>
                    </div>
                    <div class="profile-menu-divider"></div>
                    @if (Route::has('profile.edit'))
                        <a href="{{ route('profile.edit') }}" class="profile-menu-item">
                            <i class="fa-regular fa-user"></i>
                            <span>Profile</span>
                        </a>
                    @endif
                    <div class="profile-menu-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" class="profile-logout-form">
                        @csrf
                        <button type="submit" class="profile-menu-item logout-link">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Direct Logout Form Button in Navbar -->
            <form method="POST" action="{{ route('logout') }}" class="nav-logout-form">
                @csrf
                <button type="submit" class="nav-icon nav-logout-btn" title="Log Out" aria-label="Log Out">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        @else
            <a href="{{ Route::has('login') ? route('login') : '#' }}" class="nav-profile">
                <div class="profile-avatar">
                    <span>?</span>
                </div>
                <div class="profile-info">
                    <strong>Guest</strong>
                    <span>Not logged in</span>
                </div>
            </a>
        @endauth
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('navProfileDropdown');
        const btn = document.getElementById('navProfileBtn');
        const menu = document.getElementById('navProfileMenu');

        if (btn && menu) {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = menu.classList.toggle('show');
                btn.setAttribute('aria-expanded', isOpen);
            });

            document.addEventListener('click', function(e) {
                if (dropdown && !dropdown.contains(e.target)) {
                    menu.classList.remove('show');
                    btn.setAttribute('aria-expanded', 'false');
                }
            });
        }
    });
</script>
