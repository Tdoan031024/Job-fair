<?php include '../views/layouts/header.php'; ?>
<style>
.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.btn-primary {
    background: #2c3e50;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-primary:hover {
    background: #1a252f;
}
</style>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h1 class="text-white font-weight-bold">Đặt Lịch Sự Kiện</h1>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <div class="contact-form"
        style="max-width: 600px; margin: 0 auto; padding: 2rem; background: #f8f9fa; border-radius: 10px;">
        <h3 class="text-center mb-4">Form Đặt Lịch</h3>
        <form method="POST" action="index.php?page=registration_submit">
            <?php if (isset($event_id) && $event_id): ?>
            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
            <?php endif; ?>
            <?php if (isset($venue_id) && $venue_id): ?>
            <input type="hidden" name="venue_id" value="<?php echo $venue_id; ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="full_name">Họ và tên</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="contact">Liên hệ #</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label for="time_slot">Khoảng thời gian</label>
                <input type="text" class="form-control datepicker" id="time_slot" name="time_slot" required>
            </div>
            <div class="form-group">
                <label for="event_schedule">Lịch trình sự kiện mong muốn</label>
                <textarea class="form-control" id="event_schedule" name="event_schedule" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Gửi Đặt Lịch</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.datepicker').datetimepicker({
        format: 'Y-m-d H:i'
    });
});
</script>

<?php include 'views/layouts/footer.php'; ?>