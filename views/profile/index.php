<?php 
include '../views/layouts/header.php'; 

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header('Location: index.php?page=login');
    exit;
}

// Xử lý thông báo từ quá trình tải lên
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;

// Biến $user_info được truyền từ ProfileController::index()
?>

<style>
body {
    padding-top: 140px !important;
    background-color: #f8f9fa;
}

.profile-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.profile-header {
    background-color: #e67e22;
    color: white;
    padding: 20px;
    text-align: center;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
    margin-bottom: 15px;
}

.profile-info {
    padding: 20px;
}

.profile-info h4 {
    color: #2c3e50;
    font-weight: 600;
}

.profile-info p {
    color: #34495e;
    margin-bottom: 10px;
}

.profile-info .cv-section {
    margin-top: 20px;
}

.profile-info .cv-container {
    max-width: 100%;
    height: 500px;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: auto;
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

@media (min-width: 768px) {
    .profile-row {
        display: flex;
        justify-content: space-between;
    }

    .profile-left {
        flex: 1;
        padding-right: 20px;
    }

    .profile-right {
        flex: 2;
    }
}
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card profile-card">
                <div class="profile-header">
                    <h3>Thông Tin Cá Nhân</h3>
                </div>
                <div class="card-body profile-info">
                    <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                    <?php endif; ?>
                    <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <?php if (isset($user_info['status']) && $user_info['status'] === 'error'): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($user_info['message']); ?></div>
                    <?php else: ?>
                    <div class="profile-row">
                        <div class="profile-left text-center">
                            <?php if (isset($user_info['avatar']) && $user_info['avatar'] && $_SESSION['user_role'] === 'sinh_vien'): ?>
                            <img src="../Assets/images/profile/<?php echo htmlspecialchars($user_info['avatar']); ?>"
                                alt="Avatar" class="profile-avatar">
                            <?php elseif (isset($user_info['logo']) && $user_info['logo'] && $_SESSION['user_role'] === 'doanh_nghiep'): ?>
                            <img src="../Assets/images/profile/<?php echo htmlspecialchars($user_info['logo']); ?>"
                                alt="Logo" class="profile-avatar">
                            <?php else: ?>
                            <img src="../assets/images/default-avatar.png" alt="Default Avatar" class="profile-avatar">
                            <?php endif; ?>
                            <h4><?php echo htmlspecialchars(isset($user_info['ho_ten']) ? $user_info['ho_ten'] : (isset($user_info['ten_cong_ty']) ? $user_info['ten_cong_ty'] : 'Chưa cập nhật')); ?>
                            </h4>
                            <p><strong>Email:</strong>
                                <?php echo htmlspecialchars($user_info['email'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Số điện thoại:</strong>
                                <?php echo htmlspecialchars($user_info['so_dien_thoai'] ?? 'Chưa cập nhật'); ?></p>
                        </div>
                        <div class="profile-right">
                            <?php if ($_SESSION['user_role'] === 'sinh_vien'): ?>
                            <h4>Thông tin sinh viên</h4>
                            <p><strong>Trường học:</strong>
                                <?php echo htmlspecialchars($user_info['truong_hoc'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Chuyên ngành:</strong>
                                <?php echo htmlspecialchars($user_info['chuyen_nganh'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Địa chỉ:</strong>
                                <?php echo htmlspecialchars($user_info['dia_chi'] ?? 'Chưa cập nhật'); ?></p>
                            <?php elseif ($_SESSION['user_role'] === 'doanh_nghiep'): ?>
                            <h4>Thông tin doanh nghiệp</h4>
                            <p><strong>Địa chỉ:</strong>
                                <?php echo htmlspecialchars($user_info['dia_chi'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Website:</strong>
                                <?php echo htmlspecialchars($user_info['website'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Quy mô:</strong>
                                <?php echo htmlspecialchars($user_info['quy_mo'] ?? 'Chưa cập nhật'); ?></p>
                            <p><strong>Lĩnh vực:</strong>
                                <?php echo htmlspecialchars($user_info['linh_vuc'] ?? 'Không xác định'); ?></p>
                            <?php endif; ?>

                            <!-- Phần CV -->
                            <?php if ($_SESSION['user_role'] === 'sinh_vien'): ?>
                            <div class="cv-section">
                                <h5>CV của bạn</h5>
                                <?php if (isset($user_info['cv_pdf']) && !empty($user_info['cv_pdf'])): ?>
                                <div class="cv-container">
                                    <embed
                                        src="../Assets/images/profile/<?php echo htmlspecialchars($user_info['cv_pdf']); ?>"
                                        type="application/pdf" width="100%" height="100%">
                                </div>
                                <p><a href="../Assets/files/cv/<?php echo htmlspecialchars($user_info['cv_pdf']); ?>"
                                        target="_blank" class="btn btn-custom mt-2">Tải về CV</a></p>
                                <?php else: ?>
                                <p>Chưa có CV.</p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="index.php?page=logout" class="btn btn-danger">Đăng xuất</a>
                        <a href="index.php?page=edit_profile" class="btn btn-custom ml-2">Chỉnh sửa thông tin</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>