<style>
  /* Base Style Link Navbar */
  .custom-navbar .nav-link {
    position: relative;
    color: #4a4a4a;
    padding: 0.4rem 0.5rem !important;
    transition: color 0.3s ease;
  }

  /* Indikator Garis Bawah di Desktop */
  @media (min-width: 992px) {
    .custom-navbar .nav-link {
      padding-bottom: 6px !important;
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

    .custom-navbar .nav-link:hover::after,
    .custom-navbar .nav-link.active::after {
      width: 100%;               
    }
  }

  .custom-navbar .nav-link:hover,
  .custom-navbar .nav-link.active {
    color: #0d6efd !important;
    font-weight: 700;
  }

  /* Logo & Brand Title */
  .navbar-logo-img {
    height: 38px; 
    width: auto; 
    object-fit: contain; 
    display: block;
    margin-right: 6px;
  }

  @media (min-width: 992px) {
    .navbar-logo-img {
      height: 48px;
      margin-right: 10px;
    }
  }

  /* Penyesuaian Khusus Tampilan HP / Tablet */
  @media (max-width: 991.98px) {
    .custom-navbar .navbar-nav {
      align-items: flex-start !important;
      width: 100%;
      padding-top: 0.5rem;
      padding-bottom: 0.25rem;
    }
    .custom-navbar .nav-item {
      width: 100%;
    }
    .custom-navbar .nav-link {
      padding-left: 0.75rem !important;
      padding-right: 0.75rem !important;
      border-radius: 6px;
    }
    .custom-navbar .nav-link.active {
      background-color: rgba(13, 110, 253, 0.08);
    }
  }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm custom-navbar px-2 px-sm-0">
  <div class="container">
    <a class="navbar-brand text-primary fw-bold fs-5 fs-lg-4 d-flex align-items-center m-0 p-0" href="{{ route('tentang') }}">
      <img src="{{ asset('asset/fashions.png') }}" alt="Logo" class="navbar-logo-img"> 
      <span class="lh-1">Zahra Fashion</span>
    </a>
    
    <button class="navbar-toggler border-1 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-auto mt-2 mt-lg-0 w-100">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold gap-1 gap-lg-3 align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          @if(Auth::user()->role->name === 'admin')
          <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users') }}">Pengguna</a>
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
            <a class="nav-link {{ Request::is('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">Tentang Toko</a>
          </li>
        </ul>
        
        <form class="m-0 pt-2 pt-lg-0 ms-lg-2 w-100 w-lg-auto border-top border-lg-0" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn btn-outline-danger btn-sm w-100 w-lg-auto px-3 py-2 py-lg-1 fw-bold">Logout</button>
        </form>

      </div>
    </div>
  </div>
</nav>