<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand text-primary" href="#" >
      <b>POS</b>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-auto gap-2 gap-lg-4 mt-3 mt-lg-0">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold gap-2 align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users') }}">Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('produk') ? 'active' : '' }}" href="{{ route('produk.index') }}">Produk</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ Request::is('penjualan') ? 'active' : '' }}" href="{{ route('penjualan.index') }}">Penjualan</a>
        </li>
      </ul>
      <form class="m-0" action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm px-3 fw-bold ">Logout</button>
      </form>
    </div>
  </div>
  </div>
</nav>

