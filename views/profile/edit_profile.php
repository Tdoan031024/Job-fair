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
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card edit-card">
                <div class="edit-header">
                    <h3>Chỉnh Sửa Thông Tin</h3>
                </div>
                <div class="card-body edit-info">
                    <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                    <?php endif; ?>

                    <form action="index.php?page=edit_profile" method="POST" enctype="multipart/form-data">
                        <?php if ($_SESSION['user_role'] === 'sinh_vien'): ?>
                        <div class="form-group mb-3">
                            <label for="ho_ten">Họ và tên</label>
                            <input type="text" class="form-control" id="ho_ten" name="ho_ten"
                                value="<?php echo htmlspecialchars($user_info['ho_ten'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo htmlspecialchars($user_info['email'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="so_dien_thoai">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                value="<?php echo htmlspecialchars($user_info['so_dien_thoai'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="truong_hoc">Trường học</label>
                            <input type="text" class="form-control" id="truong_hoc" name="truong_hoc"
                                value="<?php echo htmlspecialchars($user_info['truong_hoc'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="chuyen_nganh">Chuyên ngành</label>
                            <input type="text" class="form-control" id="chuyen_nganh" name="chuyen_nganh"
                                value="<?php echo htmlspecialchars($user_info['chuyen_nganh'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dia_chi">Địa chỉ</label>
                            <input type="text" class="form-control" id="dia_chi" name="dia_chi"
                                value="<?php echo htmlspecialchars($user_info['dia_chi'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="avatar">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        </div>
                        <div class="form-group mb-3">
                            <label for="cv_pdf">CV (PDF)</label>
                            <input type="file" class="form-control" id="cv_pdf" name="cv_pdf" accept=".pdf">
                        </div>
                        <?php elseif ($_SESSION['user_role'] === 'doanh_nghiep'): ?>
                        <div class="form-group mb-3">
                            <label for="ten_cong_ty">Tên công ty</label>
                            <input type="text" class="form-control" id="ten_cong_ty" name="ten_cong_ty"
                                value="<?php echo htmlspecialchars($user_info['ten_cong_ty'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo htmlspecialchars($user_info['email'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="so_dien_thoai">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                value="<?php echo htmlspecialchars($user_info['so_dien_thoai'] ?? ''); ?>">
                        </div>


                        <div class="form-group mb-3">
                            <label for="dia_chi">Địa chỉ</label>
                            <input type="text" class="form-control" id="dia_chi" name="dia_chi"
                                value="<?php echo htmlspecialchars($user_info['dia_chi'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="website">Website</label>
                            <input type="url" class="form-control" id="website" name="website"
                                value="<?php echo htmlspecialchars($user_info['website'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="quy_mo">Quy mô</label>
                            <input type="text" class="form-control" id="quy_mo" name="quy_mo"
                                value="<?php echo htmlspecialchars($user_info['quy_mo'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="linh_vuc">Lĩnh vực</label>
                            <input type="text" class="form-control" id="linh_vuc" name="linh_vuc"
                                value="<?php echo htmlspecialchars($user_info['linh_vuc'] ?? ''); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label for="avatar">Logo</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                        </div>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-custom">Lưu thay đổi</button>
                            <a href="index.php?page=profile" class="btn btn-secondary ml-2">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>