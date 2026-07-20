<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kalptaru Hospital</title>

    <link rel="shortcut icon" href="{{ asset('admin/assets/img/favicon.ico') }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('admin/assets/css/font-awesome.min.css') }}"> -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">

    @stack('styles')
</head>

<body>

<div class="main-wrapper">

    @include('admin.includes.header')

    @include('admin.includes.sidebar')

    @yield('content')

</div>

@include('admin.includes.footer')

<script src="{{ asset('admin/assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/jquery.slimscroll.js') }}"></script>

<script src="{{ asset('admin/assets/js/select2.min.js') }}"></script>

<script src="{{ asset('admin/assets/js/Chart.bundle.js') }}"></script>
<script src="{{ asset('admin/assets/js/chart.js') }}"></script>

<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // ============================================================
    //                     CHAT UNREAD COUNT
    // ============================================================
    function updateSidebarChatCount() {
        $.get('{{ route("admin.chats.unread-count") }}', function(data) {
            $('#sidebar-chat-count').text(data.count);
            if (data.count > 0) {
                $('#sidebar-chat-count').show();
            } else {
                $('#sidebar-chat-count').hide();
            }
        });
    }

    function updateChatCount() {
        $.ajax({
            url: "{{ route('admin.chats.unread-count') }}",
            type: "GET",
            success: function(response) {
                if (response.count > 0) {
                    $('#chat-count').text(response.count);
                    $('#chat-count').show();
                } else {
                    $('#chat-count').hide();
                }
            }
        });
    }

    $(document).ready(function() {
        updateSidebarChatCount();
        setInterval(updateSidebarChatCount, 30000);

        updateChatCount();
        setInterval(updateChatCount, 3000);
    });

    @if(env('PUSHER_APP_KEY'))
    const userId = {{ Auth::id() }};
    const pusher = new Pusher('{{ env("PUSHER_APP_KEY") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        encrypted: true,
        authEndpoint: '/broadcasting/auth',
        auth: {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        }
    });

    const channel = pusher.subscribe('private-user.' + userId);

    channel.bind('new-notification', function(data) {
        console.log('🔔 New notification received:', data);
        addNotificationToList(data);
        updateBadgeCount(1);
    });

    function addNotificationToList(data) {
        const noMsg = document.getElementById('no-notifications-msg');
        if (noMsg) noMsg.remove();

        const list = document.getElementById('notification-list');
        if (!list) {
            console.warn('Notification list element not found');
            return;
        }

        const li = document.createElement('li');
        li.className = 'notification-message';
        li.dataset.id = data.id;

        li.innerHTML = `
            <a href="{{ route('admin.notification.index') }}" class="notification-link" data-id="${data.id}">
                <div class="media">
                    <span class="avatar">${data.user_name.charAt(0).toUpperCase()}</span>
                    <div class="media-body">
                        <p class="noti-details">
                            <span class="noti-title">${data.title}</span>
                            <br>
                            <small>${data.message.substring(0, 60)}${data.message.length > 60 ? '...' : ''}</small>
                        </p>
                        <p class="noti-time">
                            <span class="notification-time">${data.created_at}</span>
                        </p>
                    </div>
                </div>
            </a>
        `;

        list.prepend(li);

        li.querySelector('.notification-link').addEventListener('click', function(e) {
            const id = this.dataset.id;
            markAsRead(id);
        });
    }

    function updateBadgeCount(increment = 0) {
        const badge = document.getElementById('notification-badge');
        if (!badge) return;
        let current = parseInt(badge.textContent) || 0;
        current += increment;
        badge.textContent = current;
        if (current > 0) {
            badge.style.display = 'inline';
        } else {
            badge.style.display = 'none';
        }
    }

    function markAsRead(notificationId) {
        $.ajax({
            url: '/admin/notifications/' + notificationId + '/read',
            method: 'POST',
            data: { _token: csrfToken },
            success: function(response) {
                if (response.success) {
                    // Decrease badge count
                    const badge = document.getElementById('notification-badge');
                    let current = parseInt(badge.textContent) || 0;
                    if (current > 0) {
                        current--;
                        badge.textContent = current;
                        if (current === 0) badge.style.display = 'none';
                    }
                }
            },
            error: function(xhr) {
                console.error('Error marking as read:', xhr);
            }
        });
    }

    $('#notificationDropdown').on('click', function() {
    });
    @endif

</script>

@stack('scripts')

</body>
</html>