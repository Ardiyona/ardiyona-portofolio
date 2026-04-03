<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Mazer Admin Dashboard</title>
    
    <link rel="shortcut icon" href="{{ asset('assets/mazer/compiled/svg/favicon.svg') }}" type="image/svg+xml">
    
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/iconly.css') }}">
    @stack('styles')
</head>

<body>
    <script src="{{ asset('assets/mazer/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('partials.sidebar')
        <div id="main">
            @include('partials.header')
            
            <div class="page-heading">
                <h3>@yield('page-title')</h3>
            </div> 
            <div class="page-content"> 
                @yield('content')
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>{{ date('Y') }} &copy; Admin Dashboard</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="{{ asset('assets/mazer/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('assets/mazer/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/mazer/compiled/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
