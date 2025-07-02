<?php
// Đảm bảo session đã được khởi động trước khi sử dụng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Floating Contact Button -->
<div class="floating-contact">
    <button class="contact-button" onclick="openContactModal()">
        <i class="fas fa-comments"></i>
    </button>
    <div class="contact-tooltip">Liên hệ với chúng tôi</div>
</div>

<!-- Contact Modal -->
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
                    <?php echo isset($_SESSION['system']['contact']) ? htmlspecialchars($_SESSION['system']['contact']) : 'Số liên hệ mặc định'; ?>
                </p>
            </div>
        </div>
        <div class="contact-modal-item">
            <div class="contact-modal-icon"><i class="fas fa-envelope text-primary"></i></div>
            <div class="contact-modal-info">
                <h4 class="fw-bold">Email</h4>
                <p class="text-muted">
                    <?php echo isset($_SESSION['system']['email']) ? htmlspecialchars($_SESSION['system']['email']) : 'email@default.com'; ?>
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
    </div>
</div>

<script>
function openContactModal() {
    document.getElementById('contactModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeContactModal() {
    document.getElementById('contactModal').classList.remove('show');
    document.body.style.overflow = 'auto';
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
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