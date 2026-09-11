@php
    $user = Auth::user();
    $unreadCount = $user ? $user->unreadNotifications->count() : 0;
    $notifications = $user ? $user->notifications()->latest()->take(6)->get() : collect();
@endphp

<div class="nav-notification-container" id="navNotificationContainer" style="position: relative; display: inline-block;">
    <!-- Notification Bell Button -->
    <button type="button" class="nav-icon notification-bell-btn" id="navNotificationBtn" aria-expanded="false" aria-haspopup="true" title="Notifications" style="position: relative; cursor: pointer; background: transparent; border: none;">
        <i class="fa-solid fa-bell"></i>
        @if ($unreadCount > 0)
            <span class="notification-badge" id="notifBadge">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification Dropdown Panel -->
    <div class="notification-dropdown" id="navNotificationMenu">
        <div class="notif-drop-header">
            <div class="notif-drop-title">
                <h3>Notifications</h3>
                <span class="notif-unread-count" id="notifUnreadCountBadge">
                    {{ $unreadCount }} new
                </span>
            </div>
            @if ($unreadCount > 0)
                <button type="button" class="notif-mark-all" id="notifMarkAllBtn" onclick="markAllNotificationsRead(event)">
                    <i class="fa-solid fa-check-double"></i> Mark all read
                </button>
            @endif
        </div>

        <!-- Notification List -->
        <div class="notif-drop-list" id="notifDropList">
            @forelse ($notifications as $notification)
                @php
                    $data = $notification->data;
                    $type = $data['type'] ?? 'reminder';
                    $isUnread = $notification->unread();
                @endphp
                <div class="notif-item {{ $isUnread ? 'is-unread' : '' }}" id="notif-item-{{ $notification->id }}" onclick="handleNotificationClick('{{ $notification->id }}', '{{ $data['action_url'] ?? '' }}')">
                    <div class="notif-icon-circle {{ $type }}">
                        @if ($type === 'urgent')
                            <i class="fa-solid fa-syringe"></i>
                        @elseif ($type === 'appointment')
                            <i class="fa-regular fa-calendar-check"></i>
                        @else
                            <i class="fa-solid fa-paw"></i>
                        @endif
                    </div>
                    <div class="notif-text-content">
                        <div class="notif-text-top">
                            <strong class="notif-item-title">{{ $data['title'] ?? 'Notification' }}</strong>
                            <small class="notif-item-time">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="notif-item-msg">{{ $data['message'] ?? '' }}</p>
                        @if (!empty($data['action_url']))
                            <a href="{{ $data['action_url'] }}" class="notif-action-btn" onclick="event.stopPropagation(); handleNotificationClick('{{ $notification->id }}', '{{ $data['action_url'] }}')">
                                {{ $data['action_text'] ?? 'View' }} &rarr;
                            </a>
                        @endif
                    </div>
                    @if ($isUnread)
                        <span class="notif-unread-dot" title="Unread"></span>
                    @endif
                </div>
            @empty
                <div class="notif-empty-state">
                    <div class="notif-empty-icon">
                        <i class="fa-regular fa-bell-slash"></i>
                    </div>
                    <strong>No notifications yet</strong>
                    <p>When you or your pets have updates, they will show up here.</p>
                </div>
            @endforelse
        </div>

        <!-- Quick Test Button to Send Notification via DB & Email -->
        <div class="notif-drop-footer">
            <form action="{{ route('notifications.send_test') }}" method="POST" style="margin: 0; width: 100%;">
                @csrf
                <button type="submit" class="notif-send-test-btn" title="Send a test notification to database and email">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Send Test Notification (Email &amp; DB)</span>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
/* Notification Dropdown Styles */
.notification-bell-btn {
    position: relative;
}

.notification-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #e11d48;
    color: #ffffff;
    font-size: 10px;
    font-weight: 700;
    line-height: 1;
    min-width: 17px;
    height: 17px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    border: 2px solid #ffffff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.notification-dropdown {
    position: absolute;
    top: calc(100% + 12px);
    right: -60px;
    width: 360px;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 14px 35px rgba(0, 0, 0, 0.12), 0 3px 10px rgba(0, 0, 0, 0.04);
    border: 1px solid #e5e9e4;
    display: none;
    z-index: 1050;
    overflow: hidden;
    animation: notifFadeIn 0.18s ease-out;
}

@keyframes notifFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.notification-dropdown.show {
    display: block;
}

.notif-drop-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    background: #fafbf9;
    border-bottom: 1px solid #eef1ec;
}

.notif-drop-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.notif-drop-title h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1f2b23;
}

.notif-unread-count {
    background: #e8f5e9;
    color: #2f7d47;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
}

.notif-mark-all {
    background: none;
    border: none;
    color: #2f7d47;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 4px;
    transition: color 0.15s ease;
}

.notif-mark-all:hover {
    color: #1b5e20;
    text-decoration: underline;
}

.notif-drop-list {
    max-height: 380px;
    overflow-y: auto;
}

.notif-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-bottom: 1px solid #f1f3ef;
    cursor: pointer;
    transition: background 0.15s ease;
    position: relative;
}

.notif-item:hover {
    background: #f8faf8;
}

.notif-item.is-unread {
    background: #f0fdf4;
}

.notif-item.is-unread:hover {
    background: #e7faec;
}

.notif-icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
    margin-top: 2px;
}

.notif-icon-circle.urgent {
    background: #fee2e2;
    color: #b91c1c;
}

.notif-icon-circle.appointment {
    background: #e0f2fe;
    color: #0369a1;
}

.notif-icon-circle.reminder,
.notif-icon-circle.info {
    background: #e8f5e9;
    color: #2f7d47;
}

.notif-text-content {
    flex: 1;
    min-width: 0;
}

.notif-text-top {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 8px;
    margin-bottom: 3px;
}

.notif-item-title {
    font-size: 13.5px;
    color: #1f2b23;
    font-weight: 600;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.notif-item-time {
    font-size: 11px;
    color: #8b988f;
    flex-shrink: 0;
}

.notif-item-msg {
    margin: 0;
    font-size: 12.5px;
    color: #55655b;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.notif-action-btn {
    display: inline-block;
    margin-top: 6px;
    font-size: 11.5px;
    font-weight: 700;
    color: #2f7d47;
    text-decoration: none;
}

.notif-action-btn:hover {
    text-decoration: underline;
}

.notif-unread-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2f7d47;
    flex-shrink: 0;
    margin-top: 6px;
}

.notif-empty-state {
    padding: 35px 20px;
    text-align: center;
    color: #7b887f;
}

.notif-empty-icon {
    font-size: 32px;
    color: #cbd5e1;
    margin-bottom: 10px;
}

.notif-empty-state strong {
    display: block;
    font-size: 14px;
    color: #334155;
    margin-bottom: 4px;
}

.notif-empty-state p {
    margin: 0;
    font-size: 12px;
    color: #94a3b8;
}

.notif-drop-footer {
    padding: 10px 14px;
    background: #fafbf9;
    border-top: 1px solid #eef1ec;
}

.notif-send-test-btn {
    width: 100%;
    padding: 8px 12px;
    background: #ffffff;
    border: 1px dashed #2f7d47;
    color: #2f7d47;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: all 0.15s ease;
}

.notif-send-test-btn:hover {
    background: #f0fdf4;
    border-style: solid;
}

@media (max-width: 500px) {
    .notification-dropdown {
        right: -100px;
        width: 320px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const notifBtn = document.getElementById('navNotificationBtn');
    const notifMenu = document.getElementById('navNotificationMenu');
    const container = document.getElementById('navNotificationContainer');

    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            // Close profile dropdown if open
            const profileMenu = document.getElementById('navProfileMenu');
            if (profileMenu) profileMenu.classList.remove('show');

            const isOpen = notifMenu.classList.toggle('show');
            notifBtn.setAttribute('aria-expanded', isOpen);
        });

        document.addEventListener('click', function (e) {
            if (container && !container.contains(e.target)) {
                notifMenu.classList.remove('show');
                notifBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }
});

function markAllNotificationsRead(e) {
    if (e) e.stopPropagation();

    fetch('{{ route("notifications.mark_all_read") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const badge = document.getElementById('notifBadge');
            if (badge) badge.style.display = 'none';

            const unreadCountBadge = document.getElementById('notifUnreadCountBadge');
            if (unreadCountBadge) unreadCountBadge.textContent = '0 new';

            const markAllBtn = document.getElementById('notifMarkAllBtn');
            if (markAllBtn) markAllBtn.style.display = 'none';

            document.querySelectorAll('.notif-item.is-unread').forEach(item => {
                item.classList.remove('is-unread');
                const dot = item.querySelector('.notif-unread-dot');
                if (dot) dot.remove();
            });
        }
    })
    .catch(err => console.error(err));
}

function handleNotificationClick(id, url) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => {
        const item = document.getElementById(`notif-item-${id}`);
        if (item) {
            item.classList.remove('is-unread');
            const dot = item.querySelector('.notif-unread-dot');
            if (dot) dot.remove();
        }
        if (url && url !== '#' && url !== '') {
            window.location.href = url;
        }
    })
    .catch(err => {
        console.error(err);
        if (url && url !== '#' && url !== '') {
            window.location.href = url;
        }
    });
}
</script>
