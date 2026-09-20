@csrf

<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Grid Bootstrap agar responsif -->
        <div class="col-12 col-md-8 col-lg-6">
            
            <!-- Alert Error -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center mb-1">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <strong class="fw-semibold">Terjadi kesalahan input:</strong>
                    </div>
                    <ul class="mb-0 ps-3 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-lg rounded-4">
                
                <!-- Card Header -->
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                    <h5 class="card-title mb-0 fw-bold">
                        {{ isset($jenis) ? 'Edit Jenis' : 'Tambah Jenis Baru' }}
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Field Nama Jenis -->
                    <div class="mb-4">
                        <label for="nama_jenis" class="form-label fw-semibold">Nama Jenis</label>
                        <input type="text"
                               id="nama_jenis"
                               name="nama_jenis"
                               placeholder="Masukkan nama jenis (misal: Minuman)"
                               class="form-control @error('nama_jenis') is-invalid @enderror"
                               value="{{ old('nama_jenis', $jenis->nama_jenis ?? '') }}">
                        @error('nama_jenis')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <hr class="text-muted my-4">

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('jenis.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Jenis</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>