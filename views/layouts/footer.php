<style>
<?php include '../assets/css/footer.css';
?>
</style>

<footer class="footer">
    <div class="container">
        <div class="row text-center text-md-left align-items-start">

            <div class="col-md-4 mb-4">
                <img src="../assets/images/IEC/logoiec.jpg" alt="Logo" width="250" class="mr-3">
                <p class="mt-3">Nền tảng kết nối sinh viên với doanh nghiệp, việc làm và các sự kiện hướng nghiệp tại
                    HUIT.</p>
                <div class="mt-4 pt-2">
                    <p><i class="fas fa-map-marker-alt mr-2"></i> Số 140 Lê Trọng Tấn, Phường Tây Thạnh, Quận Tân Phú,
                        TP.HCM, Vietnam</p>
                    <p><i class="fas fa-envelope mr-2"></i> hotrosinhvien@hufi.edu.vn</p>
                    <p><i class="fas fa-phone-alt mr-2"></i> 096 362 11 24</p>
                </div>

                <div class="social-links mt-3">
                    <a href="https://www.facebook.com/hotrosinhvienssc.huit" class="facebook" aria-label="Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://www.youtube.com/@DHCongthuong" class="youtube" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="https://www.instagram.com/dh_congthuong/" class="instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>


            <div class="col-md-4 mb-4">
                <h4 class="mb-3">Bản đồ</h4>
                <div class="map-responsive">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.9837761013514!2d106.62617711533487!3d10.806158792293732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be27d8b4f4d%3A0x92dcba2950430867!2zVHLGsOG7nW5nIMSQ4bqhaSBow7NjIEPDtG5nIFRoxrDGoW5nIFRIUEguQ00gKEhVSVQp!5e0!3m2!1svi!2s!4v1720100000000!5m2!1svi!2s"
                        width="100%" height="220" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0" loading="lazy"></iframe>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <h4 class="mb-3">Fanpage</h4>
                <div class="fb-page" data-href="https://www.facebook.com/hotrosinhvienssc.huit" data-tabs="timeline"
                    data-width="" data-height="220" data-small-header="false" data-adapt-container-width="true"
                    data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/hotrosinhvienssc.huit" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/hotrosinhvienssc.huit">HUIT SSC Fanpage</a>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="text-center mt-4 small">
            © <?php echo date("Y"); ?> HUIT IEC. Đã đăng ký bản quyền.
        </div>
    </div>

    <button id="backToTop" title="Lên đầu trang">
        <i class="fas fa-arrow-up"></i>
    </button>

    <div class="floating-contact">
        <button class="contact-button" onclick="openContactModal()">
            <i class="fas fa-comments"></i>
        </button>
        <div class="contact-tooltip">Liên hệ với chúng tôi</div>
    </div>

    <div class="contact-modal" id="contactModal">
        <div class="contact-modal-content">
            <button class="contact-modal-close" onclick="closeContactModal()">
                <i class="fas fa-times"></i>
            </button>
            <h3 class="contact-modal-title fw-bold">Liên Hệ Với Chúng Tôi</h3>
            <div class="contact-modal-item">
                <div class="contact-modal-icon"><i class="fas fa-phone text-primary"></i></div>
                <div class="contact-modal-info">
                    <h4 class="fw-bold">Điện Thoại</h4>
                    <p class="text-muted">
                        <?php echo isset($_SESSION['system']['contact']) ? htmlspecialchars($_SESSION['system']['contact']) : '096 362 11 24'; ?>
                    </p>
                </div>
            </div>
            <div class="contact-modal-item">
                <div class="contact-modal-icon"><i class="fas fa-envelope text-primary"></i></div>
                <div class="contact-modal-info">
                    <h4 class="fw-bold">Email</h4>
                    <p class="text-muted">
                        <?php echo isset($_SESSION['system']['email']) ? htmlspecialchars($_SESSION['system']['email']) : 'hotrosinhvien@hufi.edu.vn'; ?>
                    </p>
                </div>
            </div>
            <div class="contact-modal-item">
                <div class="contact-modal-icon"><i class="fas fa-map-marker-alt text-primary"></i></div>
                <div class="contact-modal-info">
                    <h4 class="fw-bold">Địa Chỉ</h4>
                    <p class="text-muted">140 Lê Trọng Tấn, phường Tây Thạnh, quận Tân Phú, TP.HCM</p>
                </div>
            </div>
            <div class="contact-modal-item">
                <div class="contact-modal-icon"><i class="fas fa-clock text-primary"></i></div>
                <div class="contact-modal-info">
                    <h4 class="fw-bold">Giờ Làm Việc</h4>
                    <p class="text-muted">Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                </div>
            </div>
            <div class="text-center" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                <p style="color: #6c757d; margin-bottom: 15px; font-size: 0.9rem;">Hoặc gửi tin nhắn trực tiếp qua form
                </p>
                <a href="index.php?page=contact" class="contact-form-btn" onclick="closeContactModal()">
                    <i class="fas fa-edit"></i> Liên Hệ Qua Form
                </a>
            </div>
        </div>
    </div>
</footer>


</body>

</html>

<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
    nonce="fbpageload"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const backToTopBtn = document.getElementById("backToTop");
    const contactBtn = document.querySelector(".contact-button");

    window.addEventListener("scroll", function() {
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });

    backToTopBtn.addEventListener("click", function() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    setTimeout(function() {
        contactBtn.classList.add('pulse');
    }, 3000);
});

function openContactModal() {
    document.getElementById('contactModal').classList.add('show');
    document.body.style.overflow = 'hidden';
    setTimeout(function() {
        document.querySelector('.contact-form-btn').classList.add('pulse');
    }, 1000);
}

function closeContactModal() {
    document.getElementById('contactModal').classList.remove('show');
    document.body.style.overflow = 'auto';
    document.querySelector('.contact-form-btn').classList.remove('pulse');
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('contact-modal')) {
        closeContactModal();
    }
});

document.addEventListener('keyup', function(e) {
    if (e.key === 'Escape') {
        closeContactModal();
    }
});
</script>