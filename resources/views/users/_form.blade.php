@csrf

<div class="container my-5">
    <div class="row justify-content-center">
        <!-- Menggunakan sistem Grid Bootstrap agar lebih responsif di HP/Tablet dibanding `w-50` -->
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-4">
                
                <!-- Tambahan Card Header untuk mempertegas fungsi form -->
                <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                    <h5 class="card-title mb-0 fw-bold">
                        {{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}
                    </h5>
                </div>

                <div class="card-body p-4">
                    <!-- Field Nama -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" 
                               id="name"
                               name="name"
                               placeholder="Masukkan nama lengkap"
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name ?? '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror 
                    </div>

                    <!-- Field Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Alamat Email</label>
                        <input type="email" 
                               id="email"
                               name="email"
                               placeholder="nama@example.com"
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email ?? '') }}">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }} 
                        </div>
                        @enderror
                    </div>

                    <!-- Field Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin diubah' : 'Masukkan password' }}"
                               class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Field Role -->
                    <div class="mb-4">
                        <label for="role_id" class="form-label fw-semibold">Role / Peran</label>
                        <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">-- Pilih Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                    @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <hr class="text-muted my-4">

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary px-4">Kembali</a>
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Data</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>