<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App Name - @yield('title')</title>
    <link href="{{ asset('primary.css') }}" rel="stylesheet" />
</head>
<body>
<div style="margin: 0 auto; border: 1px solid #ccc; padding:5px;">
    @yield('content')
</div>
</body>
</html>
