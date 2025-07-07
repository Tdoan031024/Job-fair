<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');
session_start();
include '../views/layouts/header.php';
?>

<head>
    <link rel="stylesheet" href="../assets/css/home.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<section class="hero-section">
    <div class="hero-slider">
        <?php 
        $slide_count = 0;
        if (isset($banner_slides) && is_object($banner_slides) && $banner_slides->num_rows > 0):
            while ($slide = $banner_slides->fetch_assoc()):
                $slide_count++;
        ?>
        <div class="hero-slide <?php echo $slide_count == 1 ? 'active' : ''; ?>"
            style="background-image: url('../Assets/images/banner/<?php echo htmlspecialchars($slide['image']); ?>');"
            data-slide="<?php echo $slide_count; ?>">
            <div class="container">
                <div class="row hero-content">
                    <div class="col-lg-8 mx-auto">
                        <h1 class="hero-title"><?php echo htmlspecialchars($slide['title'] ?? ''); ?></h1>
                        <p class="hero-subtitle"><?php echo htmlspecialchars($slide['subtitle'] ?? ''); ?></p>
                        <?php if (!empty($slide['button_text'])): ?>
                        <div class="hero-buttons">
                            <a href="<?php echo htmlspecialchars($slide['button_link'] ?? '#'); ?>"
                                class="hero-btn hero-btn-primary">
                                <?php echo htmlspecialchars($slide['button_text']); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            endwhile; 
        else:
        ?>
        <div class="hero-slide active" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="container">
                <div class="row hero-content">
                    <div class="col-lg-8 mx-auto">
                        <h1 class="hero-title">
                            <?php echo isset($_SESSION['system']['name']) ? htmlspecialchars($_SESSION['system']['name']) : 'Ngày Hội Việc Làm'; ?>
                        </h1>
                        <p class="hero-subtitle">Kết nối sinh viên với cơ hội việc làm mơ ước</p>
                        <div class="hero-buttons">
                            <a href="index.php?page=event" class="hero-btn hero-btn-primary">Xem Sự Kiện</a>
                            <a href="index.php?page=companies" class="hero-btn hero-btn-secondary">Tìm Việc Làm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="floating-icons">
        <i class="fas fa-graduation-cap floating-icon"></i>
        <i class="fas fa-briefcase floating-icon"></i>
        <i class="fas fa-users floating-icon"></i>
        <i class="fas fa-rocket floating-icon"></i>
        <i class="fas fa-star floating-icon"></i>
    </div>
    <?php if ($slide_count > 1): ?>
    <button class="slider-nav slider-prev" onclick="changeSlide(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="slider-nav slider-next" onclick="changeSlide(1)">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="slider-controls">
        <?php for ($i = 1; $i <= $slide_count; $i++): ?>
        <div class="slider-dot <?php echo $i == 1 ? 'active' : ''; ?>" onclick="goToSlide(<?php echo $i; ?>)"></div>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</section>

<section class="events-section py-5 bg-light">
    <div class="container">
        <!-- Tiêu đề section -->
        <div class="section-title text-center mb-4">
            <h2 class="display-5 fw-bold text-dark">Sự Kiện Nổi Bật</h2>
            <p class="text-muted mb-5">Khám phá các sự kiện sắp diễn ra và cơ hội kết nối với doanh nghiệp hàng đầu</p>
        </div>

        <!-- Danh sách sự kiện -->
        <div class="row g-4">
            <?php while ($row = $events->fetch_assoc()): ?>
            <?php
                $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
                unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
                $desc = strtr(html_entity_decode($row['description']), $trans);
                $desc = str_replace(array("<li>", "</li>"), array("", ","), $desc);
                ?>
            <div class="col-lg-4 col-md-6">
                <div class="card event-card h-100 border-0 shadow-sm overflow-hidden">
                    <!-- Hình ảnh banner -->
                    <div class="event-banner position-relative">
                        <?php if (!empty($row['banner'])): ?>
                        <img src="../Assets/images/<?php echo htmlspecialchars($row['banner']); ?>"
                            class="card-img-top event-img" alt="<?php echo htmlspecialchars($row['event']); ?>">
                        <?php else: ?>
                        <img src="../Assets/images/default-event.jpg" class="card-img-top event-img"
                            alt="Default Event Image">
                        <?php endif; ?>
                        <div class="event-overlay"></div>
                    </div>
                    <!-- Nội dung card -->
                    <div class="card-body d-flex flex-column p-4">
                        <h3 class="card-title fw-bold mb-3"><?php echo ucwords(htmlspecialchars($row['event'])); ?></h3>
                        <div class="event-meta mb-2">
                            <i class="fa fa-calendar me-2 text-primary"></i>
                            <span><?php echo date("F d, Y h:i A", strtotime($row['schedule'])); ?></span>
                        </div>
                        <p class="card-text text-muted flex-grow-1">
                            <?php echo strip_tags($desc) ?>
                        </p>
                        <a href="index.php?page=view_event&id=<?php echo $row['id'] ?>" class="btn btn-primary">Xem chi
                            tiết</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Nút xem tất cả -->
        <div class="text-center mt-5">
            <a href="index.php?page=event" class="btn btn-outline-primary btn-lg px-4 py-2">
                Xem Tất Cả Sự Kiện
            </a>
        </div>
    </div>
</section>

<section class="companies-section py-5 bg-light">
    <div class="container">
        <!-- Tiêu đề section -->
        <div class="section-title text-center mb-4">
            <h2 class="display-5 fw-bold text-dark">Đối Tác Doanh Nghiệp</h2>
            <p class="text-muted mb-5">Kết nối với các công ty hàng đầu trong nhiều lĩnh vực khác nhau</p>
        </div>

        <!-- Danh sách doanh nghiệp -->
        <div class="row g-4">
            <?php if ($featured_companies->num_rows > 0): ?>
            <?php while ($row = $featured_companies->fetch_assoc()): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card company-card h-100 border-0 shadow-sm overflow-hidden">
                    <!-- Logo doanh nghiệp -->
                    <div class="company-logo position-relative">
                        <?php if (!empty($row['logo'])): ?>
                        <img src="../Assets/images/companies_logo/<?php echo htmlspecialchars($row['logo']); ?>"
                            class="card-img-top company-img" alt="<?php echo htmlspecialchars($row['ten_cong_ty']); ?>">
                        <?php else: ?>
                        <img src="../Assets/images/companies_logo/default_company.png" class="card-img-top company-img"
                            alt="Default Company Logo">
                        <?php endif; ?>
                        <div class="company-overlay"></div>
                    </div>
                    <!-- Nội dung card -->
                    <div class="card-body d-flex flex-column p-4">
                        <h3 class="card-title fw-bold mb-3"><?php echo htmlspecialchars($row['ten_cong_ty']); ?></h3>
                        <div class="company-meta mb-2">
                            <i class="fa fa-map-marker-alt me-2 text-primary"></i>
                            <span><?php echo htmlspecialchars($row['dia_chi']); ?></span>
                        </div>
                        <div class="company-meta mb-2">
                            <i class="fa fa-phone me-2 text-primary"></i>
                            <span><?php echo htmlspecialchars($row['so_dien_thoai']); ?></span>
                        </div>
                        <div class="company-meta mb-2">
                            <i class="fa fa-envelope me-2 text-primary"></i>
                            <span><?php echo htmlspecialchars($row['email']); ?></span>
                        </div>
                        <div class="company-meta mb-3">
                            <i class="fa fa-globe me-2 text-primary"></i>
                            <a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank"
                                class="text-primary"><?php echo htmlspecialchars($row['website']); ?></a>
                        </div>
                        <div class="company-tags mb-3">
                            <span
                                class="badge bg-primary me-2"><?php echo htmlspecialchars($row['ten_linh_vuc']); ?></span>
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($row['quy_mo']); ?></span>
                        </div>
                        <button class="btn btn-primary mt-auto view-detail"
                            data-id="<?php echo htmlspecialchars($row['id']); ?>">
                            <i class="fa fa-info-circle me-2"></i>Xem chi tiết
                        </button>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-info" role="alert">
                    Không tìm thấy doanh nghiệp nào phù hợp.
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Nút xem tất cả -->
        <div class="text-center mt-5">
            <a href="index.php?page=companies" class="btn btn-outline-primary btn-lg px-4 py-2">
                Xem Tất Cả Doanh Nghiệp
            </a>
        </div>
    </div>
</section>

<section class="stats-section py-5 bg-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="stat-box shadow-sm p-4 rounded">
                    <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                    <h3 class="fw-bold mb-1"><?php echo isset($total_events) ? $total_events : '0'; ?></h3>
                    <p class="text-muted">Sự kiện đã tổ chức</p>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <div class="stat-box shadow-sm p-4 rounded">
                    <i class="fas fa-building fa-2x text-success mb-2"></i>
                    <h3 class="fw-bold mb-1"><?php echo isset($total_companies) ? $total_companies : '0'; ?></h3>
                    <p class="text-muted">Doanh nghiệp tham gia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box shadow-sm p-4 rounded">
                    <i class="fas fa-briefcase fa-2x text-warning mb-2"></i>
                    <h3 class="fw-bold mb-1"><?php echo isset($total_jobs) ? $total_jobs : '0'; ?></h3>
                    <p class="text-muted">Việc làm đang tuyển</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Sẵn Sàng Cho Tương Lai?</h2>
        <p class="cta-description">Tham gia ngày hội việc làm để khám phá cơ hội nghề nghiệp mơ ước</p>
        <a href="index.php?page=registration" class="cta-btn">Đăng Ký Ngay</a>
    </div>
</section>

<script>
$(document).ready(function() {
    setTimeout(function() {
        $('.loading').addClass('loaded');
    }, 300);
    $('.read_more').click(function(e) {
        e.stopPropagation();
        var eventId = $(this).data('id');
        location.href = "index.php?page=view_event&id=" + eventId;
    });
    $('.event-card').click(function() {
        var eventId = $(this).data('id');
        location.href = "index.php?page=view_event&id=" + eventId;
    });
    $('.company-card').click(function() {
        var companyId = $(this).data('id');
        location.href = "index.php?page=view_company&id=" + companyId;
    });
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });
    $(window).scroll(function() {
        var scrolled = $(this).scrollTop();
        $('.floating-icon').each(function() {
            var speed = $(this).data('speed') || 0.5;
            var yPos = -(scrolled * speed);
            $(this).css('transform', 'translateY(' + yPos + 'px)');
        });
    });
});

var currentSlide = 1;
var totalSlides = <?php echo isset($slide_count) ? $slide_count : 1; ?>;

function changeSlide(direction) {
    var newSlide = currentSlide + direction;
    if (newSlide < 1) newSlide = totalSlides;
    if (newSlide > totalSlides) newSlide = 1;
    goToSlide(newSlide);
}

function goToSlide(slideNumber) {
    $('.hero-slide').removeClass('active');
    $('.slider-dot').removeClass('active');
    $('.hero-slide[data-slide="' + slideNumber + '"]').addClass('active');
    $('.slider-dot:nth-child(' + slideNumber + ')').addClass('active');
    currentSlide = slideNumber;
}

if (totalSlides > 1) {
    setInterval(function() {
        changeSlide(1);
    }, 5000);
}
</script>

<?php include '../views/layouts/footer.php'; ?>