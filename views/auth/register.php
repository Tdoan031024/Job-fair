<?php include '../views/layouts/header.php'; ?>

<link rel="stylesheet" href="../assets/css/auth.css">
<style>
body {
    padding-top: 140px !important;
}
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Đăng Ký</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <form method="POST" action="index.php?page=register">
                        <div class="form-group mb-3">
                            <label for="role">Vai trò</label>
                            <select class="form-control" id="role" name="role" required onchange="toggleFields()">
                                <option value="">Chọn vai trò</option>
                                <option value="sinh_vien">Sinh viên</option>
                                <option value="doanh_nghiep">Doanh nghiệp</option>
                            </select>
                        </div>
                        <div id="sinh_vien_fields" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="ho_ten">Họ và tên</label>
                                <input type="text" class="form-control" id="ho_ten" name="ho_ten">
                            </div>
                            <div class="form-group mb-3">
                                <label for="truong_hoc">Trường học</label>
                                <input type="text" class="form-control" id="truong_hoc" name="truong_hoc">
                            </div>
                            <div class="form-group mb-3">
                                <label for="chuyen_nganh">Chuyên ngành</label>
                                <input type="text" class="form-control" id="chuyen_nganh" name="chuyen_nganh">
                            </div>
                        </div>
                        <div id="doanh_nghiep_fields" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="ten_cong_ty">Tên công ty</label>
                                <input type="text" class="form-control" id="ten_cong_ty" name="ten_cong_ty">
                            </div>
                            <div class="form-group mb-3">
                                <label for="linh_vuc_id">Lĩnh vực</label>
                                <select class="form-control" id="linh_vuc_id" name="linh_vuc_id">
                                    <option value="">Chọn lĩnh vực</option>
                                    <?php while ($lv = $linh_vuc_list->fetch_assoc()): ?>
                                    <option value="<?php echo $lv['id']; ?>"><?php echo $lv['ten_linh_vuc']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="quy_mo">Quy mô</label>
                                <select class="form-control" id="quy_mo" name="quy_mo">
                                    <option value="">Chọn quy mô</option>
                                    <option value="Nhỏ">Nhỏ</option>
                                    <option value="Vừa">Vừa</option>
                                    <option value="Lớn">Lớn</option>
                                    <option value="Rất lớn">Rất lớn</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" id="website" name="website">
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="so_dien_thoai">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai">
                        </div>
                        <div class="form-group mb-3">
                            <label for="dia_chi">Địa chỉ</label>
                            <input type="text" class="form-control" id="dia_chi" name="dia_chi">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng Ký</button>
                    </form>
                    <div class="text-center mt-3">
                        <p>Đã có tài khoản? <a href="index.php?page=login">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    var role = document.getElementById('role').value;
    document.getElementById('sinh_vien_fields').style.display = role === 'sinh_vien' ? 'block' : 'none';
    document.getElementById('doanh_nghiep_fields').style.display = role === 'doanh_nghiep' ? 'block' : 'none';
}
</script>

<?php include '../views/layouts/footer.php'; ?>