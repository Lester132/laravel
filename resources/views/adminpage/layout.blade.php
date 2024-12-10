<!DOCTYPE html>
<html lang="en">
<head>
    @include('adminpage.header')
</head>
<body class="sb-nav-fixed">
    @include('adminpage.navbar')
    <main>
        @yield('content') <!-- This is where page-specific content will go -->
    </main>
    @include('adminpage.footer')
    @include('adminpage.scripts')
</body>
</html>
