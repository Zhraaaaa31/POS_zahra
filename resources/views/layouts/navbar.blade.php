<style>
  /* Base Style Link Navbar */
  .custom-navbar .nav-link {
    position: relative;
    color: #4a4a4a;
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
    padding-bottom: 6px !important;
    transition: color 0.3s ease;
  }
  
  .custom-navbar .nav-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 3px;               
    bottom: 0;
    left: 50%;
    background-color: #0d6efd; 
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 2px;
  }

  .custom-navbar .nav-link:hover {
    color: #0d6efd;
  }

  .custom-navbar .nav-link:hover::after,
  .custom-navbar .nav-link.active::after {
    width: 100%;               
  }

  .custom-navbar .nav-link.active {
    color: #0d6efd !important;
    font-weight: 700;
  }

  /* Styling Logo (TETAP SEPERTI KODE KAMU) */
  .navbar-logo-img {
    height: 55px; 
    width: auto; 
    object-fit: contain; 
    margin-right: -30px !important; /* Menjaga jarak rapat desktop persis pilihanmu */
    display: block;
  }

  .custom-navbar .navbar-nav {
    align-items: center;
  }

  /* --- PENYESUAIAN KHUSUS TAMPILAN HP / TABLET (RESPONSIF) --- */
  @media (max-width: 991.98px) {
    /* Mencegah logo bertabrakan dengan tombol hamburger di HP */
    .navbar-logo-img {
      height: 42px;
      margin-right: -15px !important;
    }

    /* Merapikan susunan menu saat hamburger di-klik */
    .custom-navbar .navbar-collapse {
      padding-top: 1rem;
      padding-bottom: 0.5rem;
    }

    .custom-navbar .navbar-nav {
      align-items: flex-start !important;
      width: 100%;
      gap: 0.5rem !important;
    }

    .custom-navbar .nav-item {
      width: 100%;
    }

    .custom-navbar .nav-link {
      padding: 0.5rem 0.75rem !important;
      border-radius: 6px;
    }

    /* Menyembunyikan garis bawah di HP & diganti dengan highlight background */
    .custom-navbar .nav-link::after {
      display: none !important;
    }

    .custom-navbar .nav-link.active {
      background-color: rgba(13, 110, 253, 0.08);
    }

    /* Merapikan tombol logout di HP */
    .custom-navbar form {
      width: 100%;
      margin-top: 0.75rem !important;
      padding-top: 0.75rem;
      border-top: 1px solid #dee2e6;
    }

    .custom-navbar form button {
      width: 100%;
      padding: 0.5rem !important;
    }
  }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm custom-navbar px-2 px-sm-0">
  <div class="container">
    
    <!-- Brand & Logo -->
    <a class="navbar-brand text-primary fw-bold fs-4 d-flex align-items-center m-0 p-0" href="{{ route('tentang') }}">
      <img src="{{ asset('asset/fashions.png') }}" alt="Logo" class="navbar-logo-img"> 
      <span class="lh-1">Zahra Fashion</span>
    </a>

    <!-- Tombol Toggler (Hamburger) -->
    <button class="navbar-toggler border-1 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu Navbar -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-auto gap-2 gap-lg-4 mt-3 mt-lg-0 w-100">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold gap-1 gap-lg-3 align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
         @if(Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin')
        <li class="nav-item">
          <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">Pengguna</a>
        </li>
        @endif
          <li class="nav-item">
            <a class="nav-link {{ Request::is('jenis*') ? 'active' : '' }}" href="{{ route('jenis.index') }}">Jenis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('produk*') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('penjualan*') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('laporan*') ? 'active' : '' }}" href="{{ route('laporan') }}">Laporan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('tentang*') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang Toko</a>
          </li>
        </ul>

        <!-- Form Logout -->
        <form class="m-0 ms-lg-2" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold">Logout</button>
        </form>
      </div>
    </div>

  </div>
</nav>