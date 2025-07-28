@extends('layouts.app')

@section('title', 'PISAH - Beranda Edukasi Pemilahan Sampah')

@section('styles')
<style>
    /* CSS for header */
    .gradient {
        width: 100%;
        height: 100vh;
        background: linear-gradient(to bottom, #00a86b 0%, #006400 100%);
        display: flex;
        align-items: center;
        padding: 0 5%;
        box-sizing: border-box;
        position: relative;
        overflow: hidden;
    }

    .content {
        color: white;
        max-width: 50%;
        z-index: 2;
    }

    h1 {
        font-size: 2.5em;
        margin-bottom: 10px;
    }

    p {
        margin-bottom: 20px;
    }

    .join-button {
        background-color: green;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
    }
    .join-button:hover {
        background-color: darkgreen;
    }

    .recycle-bin {
        position: absolute;
        right: 10%;
        top: 50%;
        transform: translateY(-50%);
        width: 30%;
        z-index: 2;
    }

    .leaf {
        position: absolute;
        width: 50px;
        height: 50px;
        background-image: url('https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/home/leaf.png');
        background-size: contain;
        background-repeat: no-repeat;
        z-index: 1;
    }

    /* CSS for statistik section */
    #statistik {
        background: linear-gradient(to bottom, #006400 0%, #00a86b 100%);
        color: white;
    }

    .stat-card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
        background-color: #ffffff;
        border-radius: 10px;
        color: #006400;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 1.1rem;
    }


    /* CSS FOR PADUAN */
    #panduan .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    #panduan .card-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    #panduan .card-text {
        color: #555;
    }

    #panduan .list-unstyled li {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    #panduan .list-unstyled i {
        margin-right: 0.5rem;
    }

    /* CSS FOR IMPACT SECTION */
    .impact-section {
        background-color: #f8f9fa;
    }

    .impact-card {
        background-color: #ffffff;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    .impact-card:hover {
        transform: translateY(-10px);
    }

    .impact-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .impact-title {
        font-weight: bold;
        font-size: 1.25rem;
    }

    .impact-text {
        color: #555;
        font-size: 1rem;
        line-height: 1.5;
    }




    /* Other general styles */
    .navbar {
        position: relative;
        z-index: 1000; /* Ensures the navbar stays on top */
    }

    .feature-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #00ff9d;
    }

    .info-section {
        background-color: #f1f1f1;
        padding: 40px 0;
    }

    .btn-primary,
    .btn-outline-light {
        border-radius: 50px;
        font-weight: bold;
        font-size: 1.1rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover,
    .btn-outline-light:hover {
        background-color: #28a745;
        color: #fff;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .btn-outline-light {
        border: 2px solid #ffffff;
    }

    html {
        scroll-behavior: smooth;
    }

    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
        overflow-x: hidden;
    }

    .extra-content {
        background-color: #f4f4f4;
        padding: 50px 5%;
        text-align: center;
    }

    .extra-content h2 {
        margin-bottom: 20px;
        font-size: 2em;
        color: #333;
    }

    .extra-content p {
        font-size: 1.2em;
        color: #555;
        max-width: 600px;
        margin: 0 auto;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card {
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-title {
        font-weight: bold;
    }

    .btn {
        border-radius: 25px;
        padding: 10px 20px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c3nvL8PxbFOTCmqB4K70/Md5TH6wLMPQFbXyLI2X8Iov4sy9mqNijVjQMnX/LItXD0xFBZExbhiVInUyzBYYKg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnH1zQZKn/Nh6O7HAnmOTwo3mfxz2H8O5VvhSK7VEnYbX+zjHTWYGd3PybVbaw0nJmTz5rvMw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.0.7/countUp.min.js"></script>
@endsection

@section('content')

<header class="jumbotron" id="beranda">
    <div class="gradient" id="parallax-container" style="background: #114B5F;">
        <div class="content">
            <h1>Selamatkan Bumi<br>Kelola sampah kita</h1>
            <p>Bersama-sama, kita dapat menciptakan perubahan positif untuk lingkungan. Mari belajar memilah sampah dan berkontribusi pada masa depan yang lebih hijau!</p>
            <button onclick="window.location.href='{{ route('login') }}'" class="join-button">Gabung</button>
        </div>
        <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/home/model.png" alt="Recycle Bin" class="recycle-bin">
       
        <!-- Leaves around the header -->
        <div class="leaf" style="top: 10%; left: 5%;"></div>
        <div class="leaf" style="top: 20%; right: 10%; transform: rotate(45deg);"></div>
        <div class="leaf" style="top: 30%; left: 15%; transform: rotate(-30deg);"></div>
        <div class="leaf" style="bottom: 20%; right: 20%; transform: rotate(15deg);"></div>
        <div class="leaf" style="bottom: 10%; left: 10%; transform: rotate(-60deg);"></div>
        <div class="leaf" style="bottom: 5%; right: 5%; transform: rotate(30deg);"></div>
        <div class="leaf" style="top: 40%; left: 20%; transform: rotate(-45deg);"></div>
        <div class="leaf" style="top: 50%; right: 15%; transform: rotate(60deg);"></div>
        <div class="leaf" style="top: 60%; left: 10%; transform: rotate(-15deg);"></div>
        <div class="leaf" style="bottom: 30%; right: 5%; transform: rotate(45deg);"></div>
        <div class="leaf" style="bottom: 15%; left: 15%; transform: rotate(-30deg);"></div>
    </div>
</header>


<section id="statistik" class="py-5" style="background: #1A946F">
    <div class="container">
        <h2 class="text-center mb-5">Dampak Pemilahan Sampah</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <h3 id="reduced-waste" class="card-title text-primary">30%</h3>
                        <p class="card-text">Pengurangan Sampah ke TPA</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <h3 id="increased-recycling" class="card-title text-success">50%</h3>
                        <p class="card-text">Peningkatan Daur Ulang</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card stat-card text-center">
                    <div class="card-body">
                        <h3 id="community-involved" class="card-title text-info">1000+</h3>
                        <p class="card-text">Komunitas Terlibat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




<section id="panduan" class="py-5 info-section" style="background: #88D398">
    <div class="container">
        <h2 class="text-center mb-5">Panduan Pemilahan Sampah</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon text-success mb-3">
                            <i class="fas fa-seedling fa-3x"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Sampah Organik</h5>
                        <p class="card-text">Sisa makanan, daun, dan bahan yang dapat terurai secara alami. Dapat diolah menjadi kompos.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-success mr-2"></i>Sisa makanan</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i>Daun dan ranting</li>
                            <li><i class="fas fa-check-circle text-success mr-2"></i>Kulit buah</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon text-primary mb-3">
                            <i class="fas fa-recycle fa-3x"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Sampah Anorganik</h5>
                        <p class="card-text">Plastik, kertas, logam, dan bahan yang sulit terurai secara alami. Bisa didaur ulang.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-primary mr-2"></i>Botol plastik</li>
                            <li><i class="fas fa-check-circle text-primary mr-2"></i>Kardus dan kertas</li>
                            <li><i class="fas fa-check-circle text-primary mr-2"></i>Kaleng aluminium</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow">
                    <div class="card-body text-center">
                        <div class="feature-icon text-danger mb-3">
                            <i class="fas fa-biohazard fa-3x"></i>
                        </div>
                        <h5 class="card-title font-weight-bold">Sampah B3</h5>
                        <p class="card-text">Bahan berbahaya dan beracun yang memerlukan penanganan khusus.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle text-danger mr-2"></i>Baterai bekas</li>
                            <li><i class="fas fa-check-circle text-danger mr-2"></i>Lampu neon</li>
                            <li><i class="fas fa-check-circle text-danger mr-2"></i>Limbah elektronik</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="dampak" class="py-5 impact-section bg-light" style="background: #F3E8D2 !important">
    <div class="container">
        <h2 class="text-center mb-5">Dampak Pengelolaan Sampah yang Baik</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="impact-card p-4 h-100 border-0 shadow-sm">
                    <div class="impact-icon text-success mb-3">
                        <i class="fas fa-leaf fa-3x"></i>
                    </div>
                    <h5 class="impact-title font-weight-bold">Lingkungan Lebih Bersih</h5>
                    <p class="impact-text">Pengelolaan sampah yang baik menjaga kebersihan lingkungan, mengurangi polusi, dan meningkatkan kualitas hidup.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="impact-card p-4 h-100 border-0 shadow-sm">
                    <div class="impact-icon text-primary mb-3">
                        <i class="fas fa-hand-holding-usd fa-3x"></i>
                    </div>
                    <h5 class="impact-title font-weight-bold">Peningkatan Ekonomi</h5>
                    <p class="impact-text">Daur ulang dan pengelolaan sampah dapat menciptakan lapangan kerja dan membuka peluang bisnis baru.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="impact-card p-4 h-100 border-0 shadow-sm">
                    <div class="impact-icon text-danger mb-3">
                        <i class="fas fa-heartbeat fa-3x"></i>
                    </div>
                    <h5 class="impact-title font-weight-bold">Kesehatan Masyarakat</h5>
                    <p class="impact-text">Mengurangi sampah mengurangi risiko penyakit yang disebabkan oleh lingkungan yang tercemar.</p>
                </div>
            </div>
        </div>
    </div>
</section>




<section id="tentang" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="https://raw.githubusercontent.com/ritaruthc/WasteWise/main/public/images/logo.png" alt="Tentang Kami" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <h2 class="mb-4">Tentang Kami</h2>
                <p class="lead">Kami adalah komunitas yang berdedikasi untuk mendidik dan menginspirasi masyarakat tentang pentingnya pemilahan sampah dan pengelolaan limbah yang bertanggung jawab.</p>
                <p>Melalui edukasi, aksi nyata, dan kolaborasi dengan berbagai pihak, kami berupaya menciptakan lingkungan yang lebih bersih, sehat, dan berkelanjutan. Bergabunglah dengan kami dalam perjalanan menuju Indonesia bebas sampah!</p>
            </div>
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var reducedWaste = new CountUp('reduced-waste', 30);
        var increasedRecycling = new CountUp('increased-recycling', 50);
        var communityInvolved = new CountUp('community-involved', 1000);

        if (!reducedWaste.error) {
            reducedWaste.start();
            increasedRecycling.start();
            communityInvolved.start();
        } else {
            console.error(reducedWaste.error);
        }
    });
</script>
@endsection
