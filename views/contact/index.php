<?php include '../views/layouts/header.php'; ?>
<style>
/* Copy style từ contact.php */
<?php include '../assets/css/contact.css';
?>
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h1 class="text-white font-weight-bold">Liên hệ với chúng tôi</h1>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <div class="contact-container">
        <div class="image-slider">
            <img src="../assets/images/lienhe1.jpg" class="slider-image" alt="Liên hệ 1">
        </div>
        <div class="contact-form">
            <h3 class="text-center mb-4">Kết nối - Chia sẻ - Đồng hành</h3>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="full_name">Họ và tên</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="organization">Tên công ty/doanh nghiệp/trường học</label>
                    <input type="text" class="form-control" id="organization" name="organization" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="contact_method">Phương thức liên hệ (Số điện thoại hoặc Email)</label>
                    <input type="text" class="form-control" id="contact_method" name="contact_method" required>
                </div>
                <div class="form-group">
                    <label for="message">Nội dung liên hệ/góp ý của bạn</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Gửi thông tin</button>
            </form>
        </div>
    </div>
    <div class="contact-info">
        <div class="info-item">
            <i class="fas fa-map-marker-alt"></i>
            <h5>Địa chỉ</h5>
            <p>Tầng trệt nhà B (B105), 140 Lê Trọng Tấn, Tây Thạnh, Tân Phú, TP.HCM</p>
        </div>
        <div class="info-item">
            <i class="fas fa-phone"></i>
            <h5>Điện thoại</h5>
            <p>0963 621 124</p>
        </div>
        <div class="info-item">
            <i class="fas fa-envelope"></i>
            <h5>Email</h5>
            <p>iec@huit.edu.vn</p>
        </div>
        <div class="info-item">
            <i class="fas fa-clock"></i>
            <h5>Giờ làm việc</h5>
            <p>Thứ 2 - Thứ 6: 8:00 - 16:00</p>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const images = ["assets/images/lienhe1.jpg", "assets/images/lienhe2.png", "assets/images/lienhe3.png"];
    let current = 0;

    function changeImage() {
        $('.slider-image').fadeOut(400, function() {
            $(this).attr('src', images[current]).fadeIn(400);
        });
        current = (current + 1) % images.length;
    }
    setInterval(changeImage, 5000);
});
</script>

<?php include '../views/layouts/footer.php'; ?>