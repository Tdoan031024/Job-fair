<?php include '../views/layouts/header.php'; ?>

<style>
body {
    padding-top: 140px !important;
    background-color: #f8f9fa;
}

.edit-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.edit-header {
    background-color: #e67e22;
    color: white;
    padding: 20px;
    text-align: center;
}

.edit-info {
    padding: 20px;
}

.edit-info h4 {
    color: #2c3e50;
    font-weight: 600;
}

.form-group label {
    color: #34495e;
    font-weight: 500;
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

.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875em;
}
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card edit-card">
                <div class="edit-header">
                    <h3>Thêm Việc Làm Mới</h3>
                </div>
                <div class="card-body edit-info">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <form id="addJobForm" action="index.php?page=add_job" method="POST">
                        <div class="form-group mb-3">
                            <label for="tieu_de">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tieu_de" name="tieu_de" required>
                            <div class="invalid-feedback">Vui lòng nhập tiêu đề.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="mo_ta">Mô tả</label>
                            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="5"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="yeu_cau">Yêu cầu</label>
                            <textarea class="form-control" id="yeu_cau" name="yeu_cau" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="chuyen_nganh">Chuyên ngành</label>
                            <input type="text" class="form-control" id="chuyen_nganh" name="chuyen_nganh">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kinh_nghiem">Kinh nghiệm</label>
                            <input type="text" class="form-control" id="kinh_nghiem" name="kinh_nghiem">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dia_diem">Địa điểm</label>
                            <input type="text" class="form-control" id="dia_diem" name="dia_diem">
                        </div>
                        <div class="form-group mb-3">
                            <label for="luong">Lương</label>
                            <input type="text" class="form-control" id="luong" name="luong">
                        </div>
                        <div class="form-group mb-3">
                            <label for="han_nop">Hạn nộp <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="han_nop" name="han_nop" required>
                            <div class="invalid-feedback">Vui lòng chọn hạn nộp.</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="so_luong">Số lượng <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="so_luong" name="so_luong" min="1" required>
                            <div class="invalid-feedback">Vui lòng nhập số lượng (số nguyên dương).</div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="trang_thai">Trạng thái</label>
                            <select class="form-control" id="trang_thai" name="trang_thai">
                                <option value="1">Đang tuyển</option>
                                <option value="0">Đã đóng</option>
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-custom">Thêm việc làm</button>
                            <a href="index.php?page=profile" class="btn btn-secondary ml-2">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('addJobForm').addEventListener('submit', function(e) {
    let form = this;
    let isValid = true;
    let tieuDe = form.querySelector('#tieu_de');
    let hanNop = form.querySelector('#han_nop');
    let soLuong = form.querySelector('#so_luong');

    // Reset validation
    tieuDe.classList.remove('is-invalid');
    hanNop.classList.remove('is-invalid');
    soLuong.classList.remove('is-invalid');

    if (!tieuDe.value.trim()) {
        tieuDe.classList.add('is-invalid');
        isValid = false;
    }
    if (!hanNop.value) {
        hanNop.classList.add('is-invalid');
        isValid = false;
    }
    if (!soLuong.value || soLuong.value < 1) {
        soLuong.classList.add('is-invalid');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
    }
});
</script>

<?php include '../views/layouts/footer.php'; ?>