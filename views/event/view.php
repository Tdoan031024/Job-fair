<?php include '../views/layouts/header.php'; ?>
<style>
/* Style riêng cho trang chi tiết sự kiện */
.event-detail img {
    max-width: 100%;
    height: auto;
    margin: 0 auto 20px auto;
    display: block;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.event-detail img {
    width: 100%;
    max-width: 900px;
    aspect-ratio: 16 / 9;
    object-fit: cover;
    display: block;
    margin: 0 auto 20px auto;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}


.event-detail h4 {
    font-size: 28px;
    font-weight: 600;
    color: #333;
}

.event-detail p {
    font-size: 16px;
    color: #555;
    margin-bottom: 10px;
}

.event-detail hr {
    margin: 20px 0;
}

.btn-register,
.btn-back {
    min-width: 180px;
    font-weight: 500;
    padding: 10px 20px;
    border-radius: 8px;
}

.btn-back {
    margin-right: 10px;
}

@media (max-width: 768px) {
    .event-detail {
        padding: 20px;
    }

    .event-detail h4 {
        font-size: 22px;
    }
}
</style>


<div class="container mb-5">
    <div class="event-detail">
        <?php if (!empty($event['banner'])): ?>
        <img src="../Assets/images/<?php echo htmlspecialchars($event['banner']); ?>" alt="Event Banner">
        <?php endif; ?>

        <h4 class="mb-3"><i class="fa fa-bullhorn text-primary me-2"></i><?php echo ucwords($event['event']); ?></h4>

        <p><i class="fa fa-calendar text-danger me-2"></i><strong>Thời gian:</strong>
            <?php echo date("F d, Y h:i A", strtotime($event['schedule'])); ?></p>

        <p><i class="fa fa-map-marker-alt text-success me-2"></i><strong>Địa điểm:</strong>
            <?php echo htmlspecialchars($event['venue']); ?></p>

        <p><i class="fa fa-users text-info me-2"></i><strong>Sức chứa:</strong>
            <?php echo $event['audience_capacity']; ?> người</p>

        <p><i class="fa fa-lock text-warning me-2"></i><strong>Loại sự kiện:</strong>
            <?php echo $event['type'] == 1 ? 'Công khai' : 'Riêng tư'; ?></p>

        <p><i class="fa fa-money-bill-wave text-secondary me-2"></i><strong>Phí tham gia:</strong>
            <?php echo $event['payment_type'] == 1 ? 'Miễn phí' : number_format($event['amount'], 0) . ' VND'; ?></p>

        <hr>
        <h5 class="mb-2"><i class="fa fa-info-circle text-primary me-2"></i>Mô tả sự kiện</h5>
        <div><?php echo html_entity_decode($event['description']); ?></div>
        <hr>

        <div class="d-flex justify-content-end mt-4">
            <a href="index.php?controller=event&action=index" class="btn btn-secondary btn-back">
                <i class="fa fa-arrow-left me-1"></i> Quay lại danh sách
            </a>
            <a href="index.php?controller=event&action=register&id=<?php echo $event['id']; ?>"
                class="btn btn-primary btn-register">
                <i class="fa fa-check-circle me-1"></i> Đăng ký tham gia
            </a>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>