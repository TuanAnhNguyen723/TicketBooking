<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
                            400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
                            800: '#3730a3', 900: '#312e81'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            label.form-label { @apply block text-sm font-medium text-gray-700; }
            .form-input { @apply mt-1 block w-full rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-400 px-4 py-3 text-[15px] leading-6 shadow-sm focus:outline-none focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition; }
            .form-textarea { @apply mt-1 block w-full rounded-xl border border-gray-300 bg-white text-gray-900 placeholder-gray-400 px-4 py-3 text-[15px] leading-6 shadow-sm focus:outline-none focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition min-h-[140px]; }
            .form-select { @apply mt-1 block w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-[15px] leading-6 shadow-sm focus:outline-none focus:ring-4 focus:ring-primary-100 focus:border-primary-500 transition pr-10; }
            .form-hint { @apply text-xs text-gray-500 mt-1; }
            input.form-checkbox { @apply rounded border-gray-300 text-primary-600 focus:ring-primary-500; }
        }
    </style>
    @stack('head')
</head>
<body class="bg-gray-50 font-sans">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="hidden md:flex md:w-64 flex-col border-r border-gray-200 bg-white">
            <div class="h-16 flex items-center px-6 border-b border-gray-200">
                <a href="/" class="text-lg font-semibold text-primary-700">TicketBooking Admin</a>
            </div>
            <nav class="flex-1 p-3 space-y-1">
                <a href="{{ route('admin.events.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.events.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">
                    <span>📅</span><span>Sự kiện</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">
                    <span>🧾</span><span>Đơn hàng</span>
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.tickets.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">
                    <span>🎫</span><span>Vé</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">
                    <span>👤</span><span>Người dùng</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.reviews.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-700 hover:bg-primary-50 hover:text-primary-700' }}">
                    <span>⭐</span><span>Đánh giá</span>
                </a>
            </nav>
            <div class="p-3 text-xs text-gray-500">© {{ date('Y') }} TicketBooking</div>
        </aside>

        <!-- Main -->
        <div class="flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6">
                <div class="flex items-center gap-3">
                    <button class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200">☰</button>
                    <h1 class="text-lg font-semibold text-gray-800">Bảng điều khiển</h1>
                </div>
                <a href="/" class="text-sm text-gray-600 hover:text-primary-700">Về trang người dùng</a>
            </header>

            <main class="p-4 md:p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-800 px-4 py-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-800 px-4 py-3">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>


