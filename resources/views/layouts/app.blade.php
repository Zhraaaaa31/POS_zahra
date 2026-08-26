<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- isi title yang kita kirim dari views lain -->
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])  
</head>
<style>
  body {
    background: linear-gradient(135deg, #eef2f7 0%, #e4eaf1 50%, #dde5ee 100%);
    min-height: 100vh;
  }

  /* teks judul & label */
  .h3.fw-bold,
  h5.text-muted {
    color: #1e3a5f !important;
  }

  h4.fw-bold.text-secondary {
    color: #2c4a6e !important;
  }

  .border-bottom {
    border-color: rgba(30, 58, 95, 0.15) !important;
  }

  .card {
    border-radius: .75rem;
    border: none;
  }

  .card-stat {
    border-left: 4px solid #3b6ea5;
  }

  .icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: .65rem;
    background: #eaf1fa;
    color: #3b6ea5;
  }

  .table thead {
    background: #f4f7fa;
    color: #475569;
  }
</style>
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