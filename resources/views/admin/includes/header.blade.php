<div class="header">
    <div class="header-left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            @php
                $logoPath = App\Models\Setting::get('logo_header');
            @endphp
            @if($logoPath && Storage::disk('public')->exists($logoPath))
                <img src="{{ asset('storage/' . $logoPath) }}" width="180" height="45" alt="Logo">
            @else
                <img src="{{ asset('assets/img/logo.png') }}" width="35" height="35" alt="Default Logo">
            @endif
        </a>
    </div>
    <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
    <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>

    <ul class="nav user-menu float-right">
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" id="notificationDropdown">
                <i class="fa fa-bell-o"></i>
            </a>
            <div class="dropdown-menu notifications" id="notification-dropdown-menu">
                <div class="topnav-dropdown-header">
                    <span>Notifications</span>
                </div>
                <div class="drop-scroll" id="notification-list-container">
                    <ul class="notification-list" id="notification-list">
                        @forelse($notifications ?? [] as $notification)
                            <li class="notification-message" data-id="{{ $notification->id }}">
                                <a href="{{ route('admin.notification.index') }}">
                                    <div class="media">
                                        <span class="avatar">
                                            {{ $notification->user ? strtoupper(substr($notification->user->name, 0, 1)) : 'N' }}
                                        </span>
                                        <div class="media-body">
                                            <p class="noti-details">
                                                <span class="noti-title">{{ $notification->title }}</span>
                                                <br>
                                                <small>{{ Str::limit($notification->message, 60) }}</small>
                                            </p>
                                            <p class="noti-time">
                                                <span class="notification-time">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <li class="notification-message" id="no-notifications-msg">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="noti-details">No notifications yet.</p>
                                    </div>
                                </div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="{{ route('admin.notification.index') }}">View all Notifications</a>
                </div>
            </div>
        </li>

        <!-- Chat Icon -->
        <li class="nav-item dropdown d-none d-sm-block">
            <a href="{{ route('admin.chats.index') }}" class="hasnotifications nav-link">
                <i class="fa fa-comment-o"></i>
                <span id="chat-count" class="badge badge-pill bg-danger float-right" style="display:none">0</span>
            </a>
        </li>

        <!-- User Dropdown -->
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                <span class="user-img">
                    <img class="rounded-circle" 
                         src="{{ Auth::user()?->image ? asset('uploads/users/' . Auth::user()->image) : asset('assets/img/user.jpg') }}" 
                         width="24" alt="">
                    <span class="status online"></span>
                </span>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
                <a class="dropdown-item" href="{{ route('admin.edit-profile') }}">Edit Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form-desktop').submit();">
                    Logout
                </a>
                <form id="logout-form-desktop" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>

    <!-- Mobile User Menu -->
    <div class="dropdown mobile-user-menu float-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="{{ route('admin.profile') }}">My Profile</a>
            <a class="dropdown-item" href="{{ route('admin.edit-profile') }}">Edit Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                Logout
            </a>
            <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

