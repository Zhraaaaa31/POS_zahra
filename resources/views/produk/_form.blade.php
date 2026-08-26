@csrf 

<div class="container my-5">
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

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        
        <!-- SECTION 1: FOTO & PREVIEW -->
        <div class="row g-3 mb-4">
            <!-- Foto Saat Ini (Jika Mode Edit) -->
            @if (!empty($produk->foto))
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary small text-uppercase">Foto Saat Ini</label>
                <div class="d-flex align-items-center gap-3 p-2 border rounded-3 bg-light">
                    <img src="{{ asset('storage/' . $produk->foto) }}" alt="Foto Produk" width="100" height="100" class="rounded-3 object-fit-cover border">
                    <div class="small text-muted">
                        <span class="d-block fw-semibold text-dark">File tersimpan</span>
                        Ganti foto di samping jika ingin memperbarui.
                    </div>
                </div>
            </div>
            @endif

            <!-- Input Upload File -->
            <div class="{{ !empty($produk->foto) ? 'col-md-6' : 'col-12' }}">
                <label for="foto" class="form-label fw-semibold">Upload Gambar Produk</label>
                <input type="file" 
                       id="foto"
                       name="foto" 
                       onchange="previewImage(this)" 
                       class="form-control @error('foto') is-invalid @enderror">
                @error('foto')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
                
                <!-- Preview Foto Baru -->
                <div id="preview-container" class="mt-3" style="display: none;">
                    <label class="form-label fw-semibold text-secondary small text-uppercase">Preview Gambar Baru</label>
                    <div>
                        <img id="preview" src="" class="rounded-3 border shadow-sm object-fit-cover" width="100" height="100">
                    </div>
                </div>
            </div>
        </div>

        <hr class="text-muted opacity-25 my-4">

        <!-- SECTION 2: INPUT INFORMASI PRODUK -->
        <div class="row g-3">
            <!-- Nama Produk -->
            <div class="col-12">
                <label for="name" class="form-label fw-semibold">Nama Produk</label>
                <input type="text" 
                       id="name"
                       name="name"
                       placeholder="Masukkan nama produk"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $produk->nama ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Jenis Produk -->
            <div class="col-12">
                <label for="jenis_id" class="form-label fw-semibold">Jenis Produk</label>
                <select id="jenis_id" 
                        name="jenis_id" 
                        class="form-select @error('jenis_id') is-invalid @enderror">
                    <option value="">-- Pilih Jenis --</option>
                    @foreach($jenis as $j)
                        <option value="{{ $j->id }}" 
                            {{ old('jenis_id', $produk->jenis_id ?? '') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jenis }}
                        </option>
                    @endforeach
                </select>
                @error('jenis_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Harga Beli -->
            <div class="col-md-6">
                <label for="purchase_price" class="form-label fw-semibold">Harga Beli</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted">Rp</span>
                    <input type="number" 
                           id="purchase_price"
                           name="purchase_price"
                           placeholder="0"
                           class="form-control @error('purchase_price') is-invalid @enderror"
                           value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
                    @error('purchase_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Harga Jual -->
            <div class="col-md-6">
                <label for="selling_price" class="form-label fw-semibold">Harga Jual</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted">Rp</span>
                    <input type="number" 
                           id="selling_price"
                           name="selling_price"
                           placeholder="0"
                           class="form-control @error('selling_price') is-invalid @enderror"
                           value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
                    @error('selling_price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Stok -->
            <div class="col-12">
                <label for="stock" class="form-label fw-semibold">Jumlah Stok</label>
                <input type="number" 
                       id="stock"
                       name="stock"
                       placeholder="0"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $produk->stok ?? '') }}">
                @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <hr class="text-muted opacity-25 my-4">

        <!-- SECTION 3: TOMBOL AKSI -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
            <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Produk</button>
        </div>

    </div>
</div>
</div>
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const container = document.getElementById('preview-container');
        const file = input.files[0];

        if(file) {
            preview.src = URL.createObjectURL(file);
            if (container) {
                container.style.display = 'block';
            } else {
                preview.style.display = 'block';
            }
        }
    }
</script>