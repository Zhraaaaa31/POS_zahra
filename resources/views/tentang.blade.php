<!-- memanggil file app.blade.php -->
@extends('layouts.app')

<!-- mengirimkan nilai ke title untuk ditampilkan -->
@section('title', 'Tentang toko')

<!-- batas awal isi konten -->
@section('content')


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Card Utama -->
            <div class="card shadow-sm border-0">
                <div class="card-body m-4">

                    <!-- Header Toko -->
                  <section id="content1" class="jumbotron text-center bg-white p-4 rounded-3 shadow-sm mb-4">
                        <img src="{{ asset('asset/fashions.png') }}" 
                             alt="Zahra Fashion" 
                             class="rounded-circle img-thumbnail mb-3 d-block mx-auto" 
                             style="width: 150px; height: 150px; object-fit: cover;" />
                        
                        <h1 class="h3 fw-bold text-dark mb-1">Zahra Fashion</h1>
                        <p class="lead text-primary fw-semibold mb-0">Butik Fashion Wanita &bull; Tasikmalaya</p>
                    </section>
                    <hr class="my-4">

                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="bi bi-info-circle-fill me-2 text-primary"></i>Tentang Kami
                        </h5>
                        <p class="text-secondary lh-lg mb-0">
                            <strong>Zahra Fashion</strong> adalah butik pakaian wanita yang menghadirkan berbagai pilihan
                            busana lengkap mulai dari atasan, bawahan, dress, outerwear, hingga aksesoris dengan kualitas
                            terbaik serta harga yang bersahabat. Kami berkomitmen memberikan pelayanan yang ramah dan
                            produk yang selalu mengikuti perkembangan tren fashion masa kini, baik untuk kebutuhan
                            sehari-hari, kasual, maupun acara spesial.
                        </p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="bi bi-shop me-2 text-primary"></i>Informasi Toko
                                </h6>
                                <ul class="list-unstyled mb-0 text-secondary small lh-lg">
                                    <li><strong>Nama Toko:</strong> Zahra Fashion</li>
                                    <li><strong>Kategori:</strong> Busana & Aksesoris Wanita</li>
                                    <li><strong>Lokasi:</strong> Tasikmalaya, Jawa Barat</li>
                                    <li><strong>Jam Operasional:</strong> 08.00 - 20.00 WIB</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Produk & Layanan -->
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded-3 border">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="bi bi-bag-heart-fill me-2 text-primary"></i>Produk & Layanan
                                </h6>
                                <ul class="list-unstyled mb-0 text-secondary small lh-lg">
                                    <li><i class="bi bi-check-circle me-1 text-primary"></i> Atasan, Bawahan & Dress</li>
                                    <li><i class="bi bi-check-circle me-1 text-primary"></i> Outerwear & Jaket</li>
                                    <li><i class="bi bi-check-circle me-1 text-primary"></i> Aksesoris Fashion</li>
                                    <li><i class="bi bi-check-circle me-1 text-primary"></i> Pemesanan Grosir & Eceran</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-primary bg-opacity-10 rounded-3 mb-4 border border-primary border-opacity-25">
                        <h6 class="fw-bold text-primary mb-2">
                            <i class="bi bi-bullseye me-2"></i>Visi Kami
                        </h6>
                        <p class="text-secondary small mb-0">
                            Menjadi butik fashion wanita pilihan utama masyarakat dengan menghadirkan produk
                            berkualitas, harga terjangkau, dan pelayanan yang memuaskan bagi setiap pelanggan.
                        </p>
                    </div>

                    <!-- Lokasi / Maps -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-3">
                            <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Lokasi Toko
                        </h6>
                        <div class="ratio ratio-16x9 rounded-3 overflow-hidden border shadow-sm" style="max-width: 500px; margin: 0 auto;">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.065579686612!2d108.27430797357256!3d-7.346533072269155!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f59af0d219aeb%3A0x883854edd5c53a9b!2sSDN%20SINDANGRASA!5e0!3m2!1sid!2sid!4v1789392473580!5m2!1sid!2sid"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="strict-origin-when-cross-origin">
                            </iframe>
                        </div>
                    </div>

                    <!-- Kontak & Media Sosial -->
                    <!-- <div class="text-center pt-2">
                        <h6 class="fw-bold text-dark mb-3">Hubungi Kami</h6>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="https://wa.me/6287878090942" target="_blank" class="text-success">
                                <i class="bi bi-whatsapp me-1" style="font-size: 30px;"></i>
                            </a>
                            <a href="mailto:zahrafashion@gmail.com" class="text-danger">
                                <i class="bi bi-envelope me-1" style="font-size: 30px;"></i>
                            </a>
                            <a href="https://instagram.com/zahrafashion" target="_blank" class="text-primary">
                                <i class="bi bi-instagram me-1" style="font-size: 30px;"></i>
                            </a>
                        </div>
                    </div> -->

                </div>

                <!-- Footer Card -->
                <div class="card-footer bg-white text-center py-3 border-0 rounded-bottom-4">
                    <small class="text-muted">&copy; 2026 Zahra Fashion - All Rights Reserved</small>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection