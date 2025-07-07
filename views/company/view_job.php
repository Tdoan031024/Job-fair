```php
<?php include '../views/layouts/header.php'; ?>

<style>
body {
    padding-top: 140px !important;
    background-color: #f8f9fa;
}

.view-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.view-header {
    background-color: #e67e22;
    color: white;
    padding: 20px;
    text-align: center;
}

.view-info {
    padding: 20px;
}

.view-info h4 {
    color: #2c3e50;
    font-weight: 600;
}

.view-info p {
    color: #34495e;
    margin-bottom: 10px;
}

.btn-custom {
    background-color: #e67e22;
    color: white;
    border: none;
    padding: 8px 20px;
    border-radius: 20px;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    background-color: #d35400;
    color: white;
}
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card view-card">
                <div class="view-header">
                    <h3>Chi Tiết Việc Làm</h3>
                </div>
                <div class="card-body view-info">
                    <?php if (isset($job['status']) && $job['status'] === 'error'): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($job['message']); ?></div>
                    <?php else: ?>
                    <h4><?php echo htmlspecialchars($job['tieu_de'] ?? 'Chưa cập nhật'); ?></h4>
                    <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($job['mo_ta'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Yêu cầu:</strong> <?php echo htmlspecialchars($job['yeu_cau'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Chuyên ngành:</strong>
                        <?php echo htmlspecialchars($job['chuyen_nganh'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Kinh nghiệm:</strong>
                        <?php echo htmlspecialchars($job['kinh_nghiem'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Địa điểm:</strong> <?php echo htmlspecialchars($job['dia_diem'] ?? 'Chưa cập nhật'); ?>
                    </p>
                    <p><strong>Lương:</strong> <?php echo htmlspecialchars($job['luong'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Hạn nộp:</strong> <?php echo htmlspecialchars($job['han_nop'] ?? 'Chưa cập nhật'); ?></p>
                    <p><strong>Số lượng:</strong> <?php echo htmlspecialchars($job['so_luong'] ?? 'Chưa cập nhật'); ?>
                    </p>
                    <p><strong>Trạng thái:</strong>
                        <?php echo ($job['trang_thai'] ?? 1) == 1 ? 'Đang tuyển' : 'Đã đóng'; ?></p>
                    <p><strong>Ngày tạo:</strong>
                        <?php echo date('d/m/Y', strtotime($job['ngay_tao'] ?? date('Y-m-d'))); ?></p>
                    <?php if ($_SESSION['user_role'] === 'doanh_nghiep'): ?>
                    <div class="mt-4">
                        <a href="index.php?page=edit_job&id=<?php echo $job['id']; ?>" class="btn btn-custom">Chỉnh
                            sửa</a>
                        <a href="index.php?page=delete_job&id=<?php echo $job['id']; ?>" class="btn btn-danger"
                            onclick="return confirm('Bạn có chắc chắn muốn xóa việc làm này?');">Xóa</a>
                    </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <div class="text-center mt-4">
                        <a href="index.php?page=profile" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>
```