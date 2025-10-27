<nav class="navbar navbar-expand-lg navbar-blur fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="index.php">
            <img src="img/logo.png" alt="Logo" width="40" height="40" class="me-2">
            <span>Politeknik Mitra Karya Mandiri</span>
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Beranda</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="tentang.php">Tentang</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="pendaftaran.php">Pendaftaran</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="kontak.php">Kontak</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Awal: warna solid */
.navbar-blur {
    background-color: rgba(255, 152, 0, 0.95);
    transition: background-color 0.3s ease, backdrop-filter 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

/* Saat discroll: jadi blur transparan */
.navbar-blur.scrolled {
    background-color: rgba(255, 152, 0, 0.4);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

/* Efek teks */
.navbar .nav-link {
    color: white !important;
    transition: 0.3s;
}
.navbar .nav-link:hover {
    color: #000 !important;
    background-color: rgba(255,255,255,0.3);
    border-radius: 5px;
}
</style>

<script>
/* JavaScript agar navbar jadi blur pas discroll ke bawah */
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar-blur');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>
