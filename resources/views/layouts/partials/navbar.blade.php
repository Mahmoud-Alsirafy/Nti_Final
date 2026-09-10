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
            <a href="#" class="nav-profile">
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
            </a>
        @else
            <a href="{{ route('settings.account') }}" class="nav-profile">
                <div class="profile-avatar">
                    <span>?</span>
                </div>
                <div class="profile-info">
                    <strong>Guest</strong>
                    <span>Not logged in</span>
                </div>
                <span class="profile-arrow">⌄</span>
            </a>
        @endauth
    </div>
</header>
