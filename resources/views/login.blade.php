<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirim nilai ke title untuk di tampilkan -->
@section('title', 'Login POS')

<!-- batas awal isi konten -->
@section('content')
<style>
  /* Animasi muncul saat halaman dimuat */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translate(-50%, -45%);
    }
    to {
      opacity: 1;
      transform: translate(-50%, -50%);
    }
  }

  /* Styling Card Login */
  .login-card {
    width: 22rem;
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    background: #ffffff;
    transition: all 0.3s ease;
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  /* Efek Hover halus pada Card */
  .login-card:hover {
    transform: translate(-50%, -52%);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
  }

  /* Styling Input Form */
  .form-control {
    border-radius: 10px;
    padding: 0.65rem 0.9rem;
    border: 1px solid #e0e0e0;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
  }

  /* Tombol Submit dengan Efek Pop */
  .btn-login {
    border-radius: 10px;
    padding: 0.65rem;
    font-weight: 600;
    transition: all 0.2s ease;
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
  }

  .btn-login:active {
    transform: translateY(0);
  }
</style>

<div class="card login-card p-3 position-absolute top-50 start-50">
  <div class="card-body">
    <div class="text-center mb-4">
      <h4 class="fw-bold text-dark mb-1">Login POS</h4>
    </div>

    <form action="{{ route('auth') }}" method="POST">
      @csrf

      <!-- Email Input -->
      <div class="mb-3 text-start">
        <label for="exampleInputEmail1" class="form-label fw-medium small text-secondary">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="nama@email.com">
        @error('email')
          <div class="invalid-feedback d-block mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Password Input -->
      <div class="mb-4 text-start">
        <label for="exampleInputPassword1" class="form-label fw-medium small text-secondary">Password</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="••••••••">
        @error('password')
          <div class="invalid-feedback d-block mt-1">
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary btn-login w-100">
        Masuk Sekarang
      </button>
    </form>
  </div>
</div>
@endsection