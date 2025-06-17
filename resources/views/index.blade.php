@extends('layouts.app')

@section('content')

{{-- 1. Hero Section dengan Efek Ketik --}}
<header class="hero-section">
    <div class="container px-4 text-center fade-in-section is-visible">
        <h1 class="display-3 fw-bold">
            Wujudkan Impian Finansial <br> dengan <span id="typed-text" class="text-primary"></span>
        </h1>
        <p class="lead my-4 col-md-10 col-lg-8 mx-auto text-white-50">
            Lupakan antrian panjang dan formulir rumit. Buka rekening tabungan impian Anda secara online, hanya dalam beberapa menit.
        </p>
        <a href="{{ route('halaman.form') }}" class="btn btn-primary btn-lg fw-bold px-4 py-3 rounded-pill">
            <i class="bi bi-rocket-launch-fill me-2"></i>Mulai Petualangan Finansial Anda
        </a>
    </div>
</header>

{{-- 2. Keunggulan Section dengan Hover Effect --}}
<section id="keunggulan" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center section-title fade-in-section">
            <h2 class="fw-bolder">Satu Genggaman, Banyak Kemudahan</h2>
            <p class="text-muted">Nikmati fitur-fitur terbaik yang kami rancang khusus untuk Anda.</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-lg-4 fade-in-section">
                <div class="feature-card p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-phone-vibrate-fill"></i>
                    </div>
                    <h4 class="fw-bold">100% Digital</h4>
                    <p class="text-muted">Daftar dari mana saja, kapan saja. Cukup siapkan KTP dan beberapa menit dari waktu Anda.</p>
                </div>
            </div>
            <div class="col-lg-4 fade-in-section">
                <div class="feature-card p-4">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <h4 class="fw-bold">Aman Terjamin</h4>
                    <p class="text-muted">Terdaftar dan diawasi OJK. Dana Anda aman bersama kami dan dijamin oleh LPS.</p>
                </div>
            </div>
            <div class="col-lg-4 fade-in-section">
                <div class="feature-card p-4">
                   <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                       <i class="bi bi-headset"></i>
                   </div>
                    <h4 class="fw-bold">Layanan Terbaik</h4>
                    <p class="text-muted">Tim kami siap membantu Anda dengan layanan pelanggan yang responsif dan solutif.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Produk Section dengan Tampilan Baru --}}
<section id="produk" class="py-5">
    <div class="container py-5">
        <div class="text-center section-title fade-in-section">
            <h2 class="fw-bolder">Produk Sesuai Kebutuhan Anda</h2>
            <p class="text-muted">Apapun tujuan finansial Anda, kami punya solusinya.</p>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-lg-5 col-md-6 fade-in-section">
                <div class="card product-card h-100">
                    <div class="card-body p-5 text-center">
                        <div class="product-icon-wrapper mb-4"><i class="bi bi-backpack2-fill"></i></div>
                        <h3 class="card-title fw-bold">TabunganKu</h3>
                        <p class="card-text my-4 text-muted">Pilihan cerdas untuk pelajar (7-17 tahun) yang ingin belajar menabung sejak dini. Simpel dan bebas biaya administrasi bulanan.</p>
                        <a href="{{ route('halaman.form') }}" class="btn btn-primary fw-bold rounded-pill">Daftar TabunganKu</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 fade-in-section">
                <div class="card product-card h-100">
                     <div class="card-body p-5 text-center">
                        <div class="product-icon-wrapper mb-4"><i class="bi bi-building-fill-check"></i></div>
                        <h3 class="card-title fw-bold">SIMADE</h3>
                        <p class="card-text my-4 text-muted">Solusi tabungan fleksibel untuk perorangan dan badan usaha dengan suku bunga menarik dan kemudahan transaksi.</p>
                        <a href="{{ route('halaman.form') }}" class="btn btn-primary fw-bold rounded-pill">Daftar SIMADE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
{{-- 4. Testimoni Section dengan Slider --}}
<section id="testimoni" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center section-title fade-in-section">
            <h2 class="fw-bolder">Dipercaya oleh Nasabah Kami</h2>
        </div>
        <div class="swiper testimonial-slider fade-in-section">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="testimonial-item text-center px-lg-5">
                        <i class="bi bi-quote fs-1 text-primary"></i>
                        <p class="lead fst-italic my-4">"Prosesnya benar-benar cepat, tidak menyangka bisa buka rekening dari rumah. Sangat membantu saya yang sibuk dan tidak sempat ke bank."</p>
                        <h5 class="fw-bold mb-0">Andi Pratama</h5>
                        <p class="text-muted">Wiraswasta, Sidoarjo</p>
                    </div>
                </div>
                <div class="swiper-slide">
                     <div class="testimonial-item text-center px-lg-5">
                        <i class="bi bi-quote fs-1 text-primary"></i>
                        <p class="lead fst-italic my-4">"Awalnya ragu daftar online, tapi ternyata aman dan mudah. Customer service-nya juga sangat membantu saat saya ada pertanyaan. Recommended!"</p>
                        <h5 class="fw-bold mb-0">Citra Lestari</h5>
                        <p class="text-muted">Mahasiswi, Surabaya</p>
                    </div>
                </div>
                 <div class="swiper-slide">
                     <div class="testimonial-item text-center px-lg-5">
                        <i class="bi bi-quote fs-1 text-primary"></i>
                        <p class="lead fst-italic my-4">"Sebagai pengusaha, fitur SIMADE sangat membantu transaksi bisnis saya. Bunganya kompetitif dan prosesnya tidak berbelit-belit. Sangat puas!"</p>
                        <h5 class="fw-bold mb-0">Budi Santoso</h5>
                        <p class="text-muted">Pemilik UKM, Gresik</p>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination mt-4"></div>
        </div>
    </div>
</section>

{{-- 5. FAQ Section dengan Accordion --}}
<section id="faq" class="py-5">
    <div class="container py-5">
        <div class="text-center section-title fade-in-section">
            <h2 class="fw-bolder">Pertanyaan Umum</h2>
            <p class="text-muted">Masih ragu? Temukan jawaban Anda di sini.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8 fade-in-section">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">Apa saja syarat untuk membuka rekening?</button></h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Anda hanya perlu menyiapkan e-KTP (untuk WNI) atau KITAS/Passport (untuk WNA). Untuk TabunganKu, diperlukan data wali dan kartu identitas anak seperti Kartu Keluarga atau Akta Kelahiran.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">Berapa lama proses pendaftaran hingga rekening aktif?</button></h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Proses verifikasi data biasanya memakan waktu maksimal 1x24 jam kerja. Setelah disetujui dan Anda melakukan setoran awal, rekening akan langsung aktif.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">Apakah data saya aman?</button></h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">Tentu saja. Keamanan data Anda adalah prioritas kami. Kami menggunakan teknologi enkripsi terkini dan terdaftar serta diawasi oleh Otoritas Jasa Keuangan (OJK).</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
{{-- Link CSS untuk SwiperJS Slider --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<style>
    .hero-section {
        min-height: 95vh;
        padding-top: 80px; /* Memberi ruang untuk navbar */
        background: linear-gradient(rgba(22, 28, 45, 0.6), rgba(22, 28, 45, 0.6)), url('https://plus.unsplash.com/premium_photo-1742202420392-7b0a82defbc5?q=80&w=870&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: white
    }
    .feature-card {
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: #fff;
    }
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .feature-icon {
        width: 70px; height: 70px; border-radius: 50%; display: inline-flex;
        align-items: center; justify-content: center; font-size: 2.2rem;
    }
    .product-card {
        border: 1px solid #eee;
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .product-icon-wrapper {
        width: 90px; height: 90px; margin: 0 auto; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
        color: white; font-size: 2.5rem; box-shadow: 0 0 25px rgba(13, 110, 253, 0.4);
    }
    .swiper-pagination-bullet-active {
        background-color: #0d6efd !important;
    }
    .testimonial-item {
        max-width: 700px;
        margin: auto;
    }
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0c63e4;
    }
    .fade-in-section { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease-out, transform 0.8s ease-out; }
    .fade-in-section.is-visible { opacity: 1; transform: translateY(0); }
</style>
@endpush

@push('scripts')
{{-- Library untuk efek ketik --}}
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
{{-- Library untuk slider testimoni --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Efek Navbar Scroll (hanya untuk homepage)
        const navbar = document.querySelector('#mainNavbar');
        if (navbar) {
            const initialNavbarClass = navbar.className;
            const handleScroll = () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('bg-dark', 'shadow');
                } else {
                    navbar.classList.remove('bg-dark', 'shadow');
                }
            };
            window.addEventListener('scroll', handleScroll);
        }

        // Inisialisasi Efek Ketik
        if(document.getElementById('typed-text')) {
            new Typed('#typed-text', {
                strings: ['TabunganKu.', 'SIMADE.', 'Masa Depan Anda.'],
                typeSpeed: 70,
                backSpeed: 40,
                backDelay: 2000,
                startDelay: 500,
                loop: true
            });
        }
        
        // Inisialisasi Slider Testimoni
        if(document.querySelector('.testimonial-slider')) {
            new Swiper('.testimonial-slider', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        }

        // Efek Animasi Fade-in saat di-scroll
        const faders = document.querySelectorAll('.fade-in-section');
        if(faders) {
            const appearOptions = { threshold: 0.1, rootMargin: "0px 0px -50px 0px" };
            const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    appearOnScroll.unobserve(entry.target);
                });
            }, appearOptions);
            faders.forEach(fader => appearOnScroll.observe(fader));
        }
    });
</script>
@endpush