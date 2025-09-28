<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Khu Vui Chơi & Sự Kiện')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
     <style>
         :root {
             /* Modern Color Palette */
             --primary-50: #eff6ff;
             --primary-100: #dbeafe;
             --primary-200: #bfdbfe;
             --primary-300: #93c5fd;
             --primary-400: #60a5fa;
             --primary-500: #3b82f6;
             --primary-600: #2563eb;
             --primary-700: #1d4ed8;
             --primary-800: #1e40af;
             --primary-900: #1e3a8a;
             
             --secondary-50: #fffbeb;
             --secondary-100: #fef3c7;
             --secondary-200: #fde68a;
             --secondary-300: #fcd34d;
             --secondary-400: #fbbf24;
             --secondary-500: #f59e0b;
             --secondary-600: #d97706;
             --secondary-700: #b45309;
             --secondary-800: #92400e;
             --secondary-900: #78350f;
             
             --accent-50: #ecfdf5;
             --accent-100: #d1fae5;
             --accent-200: #a7f3d0;
             --accent-300: #6ee7b7;
             --accent-400: #34d399;
             --accent-500: #10b981;
             --accent-600: #059669;
             --accent-700: #047857;
             --accent-800: #065f46;
             --accent-900: #064e3b;
             
             --gray-50: #f9fafb;
             --gray-100: #f3f4f6;
             --gray-200: #e5e7eb;
             --gray-300: #d1d5db;
             --gray-400: #9ca3af;
             --gray-500: #6b7280;
             --gray-600: #4b5563;
             --gray-700: #374151;
             --gray-800: #1f2937;
             --gray-900: #111827;
             
             /* Semantic Colors */
             --primary: var(--primary-600);
             --primary-dark: var(--primary-700);
             --primary-light: var(--primary-100);
             --secondary: var(--secondary-500);
             --accent: var(--accent-500);
             --success: var(--accent-500);
             --warning: var(--secondary-500);
             --error: #ef4444;
             --info: var(--primary-500);
             
             /* Text Colors */
             --text-primary: var(--gray-900);
             --text-secondary: var(--gray-600);
             --text-muted: var(--gray-500);
             --text-light: var(--gray-400);
             
             /* Background Colors */
             --bg-primary: #ffffff;
             --bg-secondary: var(--gray-50);
             --bg-tertiary: var(--gray-100);
             --bg-dark: var(--gray-900);
             
             /* Spacing */
             --spacing-xs: 0.25rem;
             --spacing-sm: 0.5rem;
             --spacing-md: 1rem;
             --spacing-lg: 1.5rem;
             --spacing-xl: 2rem;
             --spacing-2xl: 3rem;
             --spacing-3xl: 4rem;
             
             /* Border Radius */
             --radius-sm: 0.375rem;
             --radius-md: 0.5rem;
             --radius-lg: 0.75rem;
             --radius-xl: 1rem;
             --radius-2xl: 1.5rem;
             --radius-full: 9999px;
             
             /* Shadows */
             --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
             --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
             --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
             --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
             --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
             --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
             
             /* Transitions */
             --transition-fast: 150ms ease-in-out;
             --transition-normal: 300ms ease-in-out;
             --transition-slow: 500ms ease-in-out;
             
             /* Typography */
             --font-size-xs: 0.75rem;
             --font-size-sm: 0.875rem;
             --font-size-base: 1rem;
             --font-size-lg: 1.125rem;
             --font-size-xl: 1.25rem;
             --font-size-2xl: 1.5rem;
             --font-size-3xl: 1.875rem;
             --font-size-4xl: 2.25rem;
             --font-size-5xl: 3rem;
             
             --font-weight-normal: 400;
             --font-weight-medium: 500;
             --font-weight-semibold: 600;
             --font-weight-bold: 700;
             --font-weight-extrabold: 800;
         }

         /* Global Styles */
         * {
             box-sizing: border-box;
         }

         body {
             font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
             line-height: 1.6;
             color: var(--text-primary);
             background-color: var(--bg-primary);
             scroll-behavior: smooth;
         }

         /* Header Styles */
         .navbar {
             background: rgba(255, 255, 255, 0.95) !important;
             backdrop-filter: blur(20px);
             border-bottom: 1px solid var(--gray-200);
             box-shadow: var(--shadow-sm);
             transition: all var(--transition-normal);
             position: fixed;
             top: 0;
             left: 0;
             right: 0;
             z-index: 1030;
         }

         .navbar-brand {
             font-weight: var(--font-weight-extrabold);
             font-size: var(--font-size-xl);
             background: linear-gradient(135deg, var(--primary), var(--accent));
             -webkit-background-clip: text;
             -webkit-text-fill-color: transparent;
             background-clip: text;
             text-decoration: none;
             transition: all var(--transition-normal);
         }

         .navbar-brand:hover {
             transform: scale(1.05);
         }

         .navbar-nav .nav-link {
             font-weight: var(--font-weight-medium);
             color: var(--text-primary) !important;
             padding: var(--spacing-sm) var(--spacing-md) !important;
             border-radius: var(--radius-lg);
             transition: all var(--transition-fast);
             position: relative;
             margin: 0 var(--spacing-xs);
         }

         .navbar-nav .nav-link:hover {
             color: var(--primary) !important;
             background-color: var(--primary-light);
             transform: translateY(-1px);
         }

         .navbar-nav .nav-link i {
             margin-right: var(--spacing-sm);
             transition: all var(--transition-fast);
         }

         .navbar-nav .nav-link:hover i {
             transform: scale(1.1);
         }

         .badge {
             font-size: var(--font-size-xs);
             font-weight: var(--font-weight-semibold);
             padding: var(--spacing-xs) var(--spacing-sm);
             border-radius: var(--radius-full);
             animation: pulse 2s infinite;
         }

         @keyframes pulse {
             0%, 100% { transform: scale(1); }
             50% { transform: scale(1.05); }
         }

         /* Hero Section */
         .hero-section {
             background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
             color: white;
             padding: var(--spacing-3xl) 0;
             position: relative;
             overflow: hidden;
             margin-top: 76px; /* Account for fixed navbar */
         }

         .hero-section::before {
             content: '';
             position: absolute;
             top: 0;
             left: 0;
             right: 0;
             bottom: 0;
             background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
             opacity: 0.3;
             animation: float 20s ease-in-out infinite;
         }

         @keyframes float {
             0%, 100% { transform: translateY(0px); }
             50% { transform: translateY(-20px); }
         }

         .hero-content {
             position: relative;
             z-index: 2;
         }

         .hero-title {
             font-size: var(--font-size-5xl);
             font-weight: var(--font-weight-extrabold);
             margin-bottom: var(--spacing-lg);
             text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
             animation: slideInUp 1s ease-out;
         }

         .hero-subtitle {
             font-size: var(--font-size-xl);
             margin-bottom: var(--spacing-2xl);
             opacity: 0.95;
             animation: slideInUp 1s ease-out 0.2s both;
         }

         @keyframes slideInUp {
             from {
                 opacity: 0;
                 transform: translateY(30px);
             }
             to {
                 opacity: 1;
                 transform: translateY(0);
             }
         }

         /* Search Box */
         .search-container {
             background: var(--bg-primary);
             border-radius: var(--radius-2xl);
             padding: var(--spacing-xl);
             box-shadow: var(--shadow-xl);
             margin-top: var(--spacing-xl);
             animation: slideInUp 1s ease-out 0.4s both;
             border: 1px solid var(--gray-200);
         }

         .search-input {
             border: 2px solid var(--gray-200);
             border-radius: var(--radius-xl);
             padding: var(--spacing-md) var(--spacing-lg);
             font-size: var(--font-size-lg);
             transition: all var(--transition-normal);
             background: var(--bg-primary);
             color: var(--text-primary);
         }

         .search-input:focus {
             border-color: var(--primary);
             box-shadow: 0 0 0 3px var(--primary-light);
             outline: none;
             transform: translateY(-1px);
         }

         .search-input::placeholder {
             color: var(--text-muted);
         }

         .search-btn {
             background: linear-gradient(135deg, var(--primary), var(--primary-dark));
             border: none;
             border-radius: var(--radius-xl);
             padding: var(--spacing-md) var(--spacing-xl);
             font-weight: var(--font-weight-semibold);
             transition: all var(--transition-normal);
             color: white;
             position: relative;
             overflow: hidden;
         }

         .search-btn::before {
             content: '';
             position: absolute;
             top: 0;
             left: -100%;
             width: 100%;
             height: 100%;
             background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
             transition: left 0.5s;
         }

         .search-btn:hover::before {
             left: 100%;
         }

         .search-btn:hover {
             transform: translateY(-2px);
             box-shadow: var(--shadow-lg);
         }

         .search-btn:active {
             transform: translateY(0);
         }

        /* Card Styles */
        .card {
            border: none;
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-md);
            transition: all var(--transition-normal);
            overflow: hidden;
            background: var(--bg-primary);
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, var(--primary-light), var(--accent-50));
            opacity: 0;
            transition: opacity var(--transition-normal);
            z-index: 1;
        }

        .card:hover::before {
            opacity: 0.05;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .card-body {
            position: relative;
            z-index: 2;
        }

        .event-card {
            height: 100%;
        }

        .event-image {
            height: 240px;
            object-fit: cover;
            transition: transform var(--transition-slow);
            border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        }

        .card:hover .event-image {
            transform: scale(1.08);
        }

        .price-tag {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-600));
            color: white;
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: var(--radius-full);
            font-weight: var(--font-weight-bold);
            font-size: var(--font-size-sm);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .price-tag::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .price-tag:hover::before {
            left: 100%;
        }

        .location-tag {
            background: var(--accent-light);
            color: var(--accent);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--radius-full);
            font-size: var(--font-size-xs);
            font-weight: var(--font-weight-medium);
            border: 1px solid var(--accent-200);
        }

        /* Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
            border-radius: var(--radius-xl);
            padding: var(--spacing-md) var(--spacing-lg);
            font-weight: var(--font-weight-semibold);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary);
            color: var(--primary);
            background: transparent;
            border-radius: var(--radius-xl);
            padding: var(--spacing-md) var(--spacing-lg);
            font-weight: var(--font-weight-semibold);
            transition: all var(--transition-normal);
            position: relative;
            overflow: hidden;
        }

        .btn-outline-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary);
            transition: width var(--transition-normal);
            z-index: -1;
        }

        .btn-outline-primary:hover::before {
            width: 100%;
        }

        .btn-outline-primary:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), var(--secondary-600));
            border: none;
            border-radius: var(--radius-xl);
            padding: var(--spacing-md) var(--spacing-lg);
            font-weight: var(--font-weight-semibold);
            transition: all var(--transition-normal);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--accent), var(--accent-600));
            border: none;
            border-radius: var(--radius-xl);
            padding: var(--spacing-md) var(--spacing-lg);
            font-weight: var(--font-weight-semibold);
            transition: all var(--transition-normal);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
            color: white;
            padding: var(--spacing-3xl) 0 var(--spacing-lg);
            margin-top: var(--spacing-3xl);
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .footer h5 {
            font-weight: var(--font-weight-bold);
            margin-bottom: var(--spacing-lg);
            color: white;
        }

        .footer a {
            color: var(--gray-300);
            text-decoration: none;
            transition: all var(--transition-fast);
            display: inline-block;
        }

        .footer a:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        /* Form Styles */
        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            padding: var(--spacing-md);
            font-size: var(--font-size-base);
            transition: all var(--transition-normal);
            background: var(--bg-primary);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .form-label {
            font-weight: var(--font-weight-medium);
            color: var(--text-primary);
            margin-bottom: var(--spacing-sm);
        }

        /* Alert Styles */
        .alert {
            border: none;
            border-radius: var(--radius-lg);
            padding: var(--spacing-md) var(--spacing-lg);
            font-weight: var(--font-weight-medium);
        }

        .alert-info {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-left: 4px solid var(--primary);
        }

        .alert-success {
            background: var(--accent-light);
            color: var(--accent-dark);
            border-left: 4px solid var(--accent);
        }

        .alert-warning {
            background: var(--secondary-light);
            color: var(--secondary-dark);
            border-left: 4px solid var(--secondary);
        }

        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Ripple Effect */
        .btn {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Scroll Animations */
        .fade-in-up-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .fade-in-up-scroll.animate {
            opacity: 1;
            transform: translateY(0);
        }

        /* Smooth Transitions */
        .card, .btn, .form-control, .form-select {
            transition: transform var(--transition-fast), box-shadow var(--transition-fast);
        }

        /* Hover Effects */
        .card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: var(--shadow-2xl);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* Toast Notification Styles */
        .custom-toast {
            min-width: 300px;
            max-width: 400px;
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-xl);
            animation: slideInRight 0.3s ease-out;
        }
        
        .custom-toast .toast-header {
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            border: none;
            font-weight: var(--font-weight-semibold);
        }
        
        .custom-toast .toast-body {
            padding: var(--spacing-md) var(--spacing-lg);
            font-size: var(--font-size-sm);
            line-height: 1.5;
        }
        
        .toast-container {
            pointer-events: none;
        }
        
        .toast-container .toast {
            pointer-events: auto;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: var(--font-size-3xl);
            }
            
            .hero-subtitle {
                font-size: var(--font-size-lg);
            }
            
            .search-container {
                padding: var(--spacing-lg);
            }
            
            .card {
                margin-bottom: var(--spacing-lg);
            }
            
            .navbar-nav .nav-link {
                padding: var(--spacing-sm) var(--spacing-md) !important;
            }
            
            .custom-toast {
                min-width: 280px;
                max-width: 350px;
            }
            
            .toast-container {
                padding: var(--spacing-md) !important;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: var(--font-size-2xl);
            }
            
            .navbar-brand {
                font-size: var(--font-size-lg);
            }
            
            .btn {
                padding: var(--spacing-sm) var(--spacing-md);
                font-size: var(--font-size-sm);
            }
            
            .search-container {
                padding: var(--spacing-md);
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-ticket-alt me-2"></i>
                TicketBooking
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i>Trang chủ
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart') }}">
                            <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            @if(session('cart'))
                                <span class="badge bg-danger ms-1">{{ count(session('cart')) }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i>Đơn hàng của tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#events">
                            <i class="fas fa-calendar-alt me-1"></i>Sự kiện
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="avatar-sm me-2">
                                    <div class="avatar-initials bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">
                                    <i class="fas fa-shopping-bag me-2"></i>Đơn hàng của tôi
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="hero-title fade-in-up">Khám phá thế giới giải trí</h1>
                <p class="hero-subtitle fade-in-up">Đặt vé dễ dàng cho các sự kiện và khu vui chơi hàng đầu Việt Nam</p>
                
                <!-- Search Box -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="search-container fade-in-up">
                            <form action="{{ route('events.search') }}" method="GET">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <input type="text" 
                                               class="form-control search-input" 
                                               name="q" 
                                               placeholder="Tìm kiếm sự kiện, khu vui chơi..." 
                                               value="{{ request('q') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn search-btn w-100" type="submit">
                                            <i class="fas fa-search me-2"></i>Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container" style="padding-top: 2rem;">

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="d-flex align-items-center">
                        <i class="fas fa-ticket-alt me-2"></i>TicketBooking
                    </h5>
                    <p class="mb-3">Hệ thống đặt vé khu vui chơi và sự kiện hàng đầu Việt Nam. Trải nghiệm giải trí tuyệt vời với giá cả hợp lý.</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Dịch vụ</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Đặt vé sự kiện</a></li>
                        <li><a href="#">Khu vui chơi</a></li>
                        <li><a href="#">Lễ hội</a></li>
                        <li><a href="#">Triển lãm</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6>Hỗ trợ</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Trung tâm trợ giúp</a></li>
                        <li><a href="#">Chính sách hoàn vé</a></li>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <h6>Liên hệ</h6>
                    <div class="contact-info">
                        <p class="mb-2">
                            <i class="fas fa-phone me-2"></i>
                            <a href="tel:19001234">1900 1234</a>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:support@ticketbooking.vn">support@ticketbooking.vn</a>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            123 Đường ABC, Quận 1, TP.HCM
                        </p>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2024 TicketBooking. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        Được phát triển với <i class="fas fa-heart text-danger"></i> tại Việt Nam
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <!-- Toasts will be dynamically inserted here -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Toast Notification System -->
    <script>
        // Toast notification system
        function showToast(message, type = 'success', duration = 2000) {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div id="${toastId}" class="toast custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header ${type === 'success' ? 'bg-success text-white' : type === 'error' ? 'bg-danger text-white' : type === 'warning' ? 'bg-warning text-dark' : 'bg-info text-white'}">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} me-2"></i>
                        <strong class="me-auto">Thông báo</strong>
                        <button type="button" class="btn-close ${type === 'success' || type === 'error' || type === 'info' ? 'btn-close-white' : ''}" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, {
                autohide: true,
                delay: duration
            });
            
            toast.show();
            
            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }
        
        // Auto-show alerts from Laravel session
        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        
        @if(session('warning'))
            showToast('{{ session('warning') }}', 'warning');
        @endif
        
        @if(session('info'))
            showToast('{{ session('info') }}', 'info');
        @endif
    </script>
    
    @yield('scripts')
</body>
</html>
