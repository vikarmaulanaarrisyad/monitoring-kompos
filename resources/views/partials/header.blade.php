<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">{{ config('app.name') }}</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge" id="notificationCount">{{ $notificationCount }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notificationMenu">
                <span class="dropdown-item dropdown-header">{{ $notificationCount }} Notifications</span>
                <div class="dropdown-divider"></div>

                @foreach ($notifications as $notification)
                    <a href="#" class="dropdown-item notification-item" data-id="{{ $notification->id }}">
                        <i class="fas fa-bell mr-2"></i> {{ $notification->data['message'] }}
                        <span
                            class="float-right text-muted text-sm">{{ $notification->created_at->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach

                <a href="#" class="dropdown-item dropdown-footer"
                    onclick="event.preventDefault(); markAllAsRead();">Mark All as Read</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="document.querySelector('#form-logout').submit()">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>

            <form action="{{ route('logout') }}" method="post" id="form-logout">
                @csrf
            </form>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateNotifications() {
            fetch('{{ route('notifications.count') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('notificationCount').textContent = data.count;
                });

            fetch('{{ route('notifications.get') }}')
                .then(response => response.json())
                .then(data => {
                    const notificationMenu = document.getElementById('notificationMenu');
                    notificationMenu.innerHTML = `
                        <span class="dropdown-item dropdown-header">${data.length} Notifikasi</span>
                        <div class="dropdown-divider"></div>
                    `;

                    data.forEach(notification => {
                        const createdAt = new Date(notification.created_at).toLocaleTimeString();
                        notificationMenu.innerHTML += `
                            <a href="#" class="dropdown-item notification-item" data-id="${notification.id}">
                                <i class="fas fa-bell mr-2"></i> ${notification.data.message}
                                <span class="float-right text-muted text-sm">${createdAt}</span>
                            </a>
                            <div class="dropdown-divider"></div>
                        `;
                    });

                    notificationMenu.innerHTML += `
                        <a href="#" class="dropdown-item dropdown-footer" onclick="event.preventDefault(); markAllAsRead();">Mark All as Read</a>
                    `;

                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.addEventListener('click', function() {
                            markAsRead(this.getAttribute('data-id'));
                        });
                    });
                });
        }

        function markAsRead(id) {
            fetch('{{ route('notifications.markAsRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateNotifications();
                    }
                });
        }

        function markAllAsRead1() {
            fetch('{{ route('notifications.markAllAsRead') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateNotifications();
                    }
                });
        }

        setInterval(updateNotifications, 2000);
    });

    function markAllAsRead() {
        fetch('{{ route('notifications.markAllAsRead') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    updateNotifications();
                }
            }).catch(error => {
                console.error('Error marking all as read:', error);
            });
    }
</script>
