<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url("dist/icons/bootstrap-icons-1.4.0/bootstrap-icons.min.css") }}" type="text/css">
    <link rel="stylesheet" href="{{ url("dist/css/bootstrap-docs.css") }}" type="text/css">
    <link rel="stylesheet" href="{{ url("dist/icons/font-awesome/css/font-awesome.min.css") }}" type="text/css">
    <link rel="stylesheet" href="{{ url("libs/dataTable/datatables.min.css") }}" type="text/css">
    
    <style>
        /* Fixed sidebar styles */
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .main-content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            overflow-x: hidden; /* Prevent horizontal scrolling */
        }
        
        /* Remove mobile toggle styles */
        .mobile-menu-toggle {
            display: none !important;
        }
    </style>

    @yield('head')

    <!-- Main style file -->
    <link rel="stylesheet" href="{{ url("dist/css/app.min.css") }}" type="text/css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    @include('admin.components.menu')
    <!-- ./  menu -->
    
    <!-- layout-wrapper -->
    <div class="layout-wrapper">
    
    
        <!-- content -->
        <div class="content @yield('contentClassName')">
            @yield('content')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="{{ url("libs/bundle.js") }}"></script>
    <script src="{{ url("dist/js/app.min.js") }}"></script>
    @yield('script')
    @stack('scripts')
</body>
</html>