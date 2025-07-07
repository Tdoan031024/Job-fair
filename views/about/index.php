<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); // Khởi động session
include '../views/layouts/header.php';
?>
<link rel="stylesheet" href="../assets/css/about.css">

<body class="about-page">
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10">
                    <h1 class="text-uppercase text-white fw-bold">Về Chúng Tôi</h1>
                    <hr class="divider my-4" />
                    <p class="text-white lead mb-4">Khám phá hành trình xây dựng hệ sinh thái khởi nghiệp bền vững</p>
                    <a href="#about-content" class="btn btn-primary btn-lg">Tìm Hiểu Thêm</a>
                </div>
            </div>
        </div>
    </header>

    <section class="banner-section py-5 bg-gradient-primary text-white text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold mb-3">Hãy Tham Gia Cộng Đồng Khởi Nghiệp Của Chúng Tôi!</h2>
                    <p class="lead mb-4">Kết nối, sáng tạo và phát triển cùng các dự án khởi nghiệp sáng tạo.</p>
                    <a href="#link-contact-content" class="btn btn-light btn-lg">Liên Hệ Ngay</a>
                </div>
            </div>
        </div>
    </section>

    <section id="about-content" class="about-content-section py-5">
        <!-- <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="about-content text-muted text-center">
                        <?php echo isset($_SESSION['system']['about_content']) ? html_entity_decode($_SESSION['system']['about_content']) : 'Nội dung giới thiệu mặc định'; ?>
                    </div>
                </div>
            </div>
        </div> -->
    </section>

    <section class="mission-vision-section py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="mission-vision-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="mission-vision-icon"><i class="fas fa-bullseye text-primary"></i></div>
                            <h3 class="mission-vision-title fw-bold">Sứ Mệnh</h3>
                            <p class="mission-vision-text text-muted">
                                Kết nối cộng đồng, tạo điều kiện thuận lợi cho người học và thúc đẩy các hoạt động khởi
                                nghiệp sáng tạo, góp phần xây dựng hệ sinh thái khởi nghiệp bền vững.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-vision-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="mission-vision-icon"><i class="fas fa-eye text-primary"></i></div>
                            <h3 class="mission-vision-title fw-bold">Tầm Nhìn</h3>
                            <p class="mission-vision-text text-muted">
                                Trở thành đơn vị uy tín trong cộng đồng khởi nghiệp quốc gia vào năm 2030, đóng góp giá
                                trị
                                cho xã hội thông qua các hoạt động hỗ trợ khởi nghiệp và đổi mới sáng tạo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Giá Trị Cốt Lõi</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="value-icon"><i class="fas fa-handshake text-primary"></i></div>
                            <h4 class="value-title fw-bold">Kết Nối, Hợp Tác</h4>
                            <p class="value-description text-muted">
                                Liên kết cộng đồng và hợp tác phát triển bền vững, tạo mạng lưới hỗ trợ mạnh mẽ.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="value-icon"><i class="fas fa-rocket text-primary"></i></div>
                            <h4 class="value-title fw-bold">Chủ Động, Sáng Tạo</h4>
                            <p class="value-description text-muted">
                                Đổi mới linh hoạt, phát huy sáng tạo để tạo giá trị mới và giải pháp đột phá.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="value-icon"><i class="fas fa-shield-alt text-primary"></i></div>
                            <h4 class="value-title fw-bold">Cam Kết, Trách Nhiệm</h4>
                            <p class="value-description text-muted">
                                Cung cấp dịch vụ chất lượng, chịu trách nhiệm với Nhà trường và xã hội.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-card card h-100 border-0 shadow-sm animate-card">
                        <div class="card-body text-center p-4">
                            <div class="value-icon"><i class="fas fa-leaf text-primary"></i></div>
                            <h4 class="value-title fw-bold">Phát Triển, Bền Vững</h4>
                            <p class="value-description text-muted">
                                Giải quyết vấn đề kinh tế - xã hội, gắn với bảo vệ môi trường và phát triển bền vững.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-white">Thành Tựu Nổi Bật</h2>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <span class="stat-number display-4 fw-bold text-primary">500+</span>
                        <div class="stat-label text-muted">Sinh Viên Tham Gia</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <span class="stat-number display-4 fw-bold text-primary">50+</span>
                        <div class="stat-label text-muted">Doanh Nghiệp Đối Tác</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <span class="stat-number display-4 fw-bold text-primary">100+</span>
                        <div class="stat-label text-muted">Dự Án Khởi Nghiệp</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-item card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <span class="stat-number display-4 fw-bold text-primary">95%</span>
                        <div class="stat-label text-muted">Tỷ Lệ Thành Công</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="link-contact-content" class="about-content-section py-5">

    </section>

    <section id="contact-section" class="contact-section py-5">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Liên Hệ Với Chúng Tôi</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt text-primary"></i></div>
                        <h4 class="contact-title fw-bold">Địa Chỉ</h4>
                        <p class="contact-info text-muted">140 Lê Trọng Tấn, phường Tây Thạnh, quận Tân Phú, TP.HCM</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <div class="contact-icon"><i class="fas fa-phone text-primary"></i></div>
                        <h4 class="contact-title fw-bold">Điện Thoại</h4>
                        <p class="contact-info text-muted">
                            <?php echo isset($_SESSION['system']['contact']) ? htmlspecialchars($_SESSION['system']['contact']) : '096 362 11 24'; ?>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="contact-card card h-100 border-0 shadow-sm text-center p-4 animate-card">
                        <div class="contact-icon"><i class="fas fa-envelope text-primary"></i></div>
                        <h4 class="contact-title fw-bold">Email</h4>
                        <p class="contact-info text-muted">
                            <?php echo isset($_SESSION['system']['email']) ? htmlspecialchars($_SESSION['system']['email']) : 'hotrosinhvien@hufi.edu.vn'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../views/layouts/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const scrollToTop = document.querySelector('.scroll-to-top');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollToTop.classList.add('show');
            } else {
                scrollToTop.classList.remove('show');
            }
        });

        scrollToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        const contactButton = document.querySelector('.about-page .contact-button');
        const contactModal = document.querySelector('.about-page .contact-modal');
        const closeModal = document.querySelector('.about-page .contact-modal-close');

        contactButton.addEventListener('click', () => {
            contactModal.classList.toggle('show');
            document.body.style.overflow = contactModal.classList.contains('show') ? 'hidden' : 'auto';
        });

        closeModal.addEventListener('click', () => {
            contactModal.classList.remove('show');
            document.body.style.overflow = 'auto';
        });

        // Đóng modal khi click bên ngoài
        contactModal.addEventListener('click', (e) => {
            if (e.target.classList.contains('contact-modal')) {
                contactModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        // Đóng modal khi nhấn phím Escape
        document.addEventListener('keyup', (e) => {
            if (e.key === 'Escape' && contactModal.classList.contains('show')) {
                contactModal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });

        // Animate cards on scroll
        const cards = document.querySelectorAll('.animate-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, {
            threshold: 0.2
        });

        cards.forEach(card => observer.observe(card));
    });
    </script>
</body>