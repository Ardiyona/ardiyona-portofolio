<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - MyApp</title>
    
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/app.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" crossorigin href="{{ asset('assets/mazer/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('assets/mazer/static/js/initTheme.js') }}"></script>
    <div id="auth">
        @yield('content')
    </div>
</body>

</html>
