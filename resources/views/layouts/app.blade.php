<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- isi title yang kita kirim dari views lain -->
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])  
</head>
<body>
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{session('success')}}
            @endif
        </div>
        <!-- isi konten yg kita kirim dari views lain -->
         @yield('content')
    </div>
</body>
</html>