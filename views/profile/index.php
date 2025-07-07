<?php 
include '../views/layouts/header.php'; 

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
    header('Location: index.php?page=login');
    exit;
}

$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
$success = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;

?>
<link rel="stylesheet" href="../assets/css/profile.css">

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
                                        src="../Assets/files/cv/<?php echo htmlspecialchars($user_info['cv_pdf']); ?>"
                                        type="application/pdf" width="100%" height="100%">
                                </div>
                                <p><a href="../Assets/files/cv/<?php echo htmlspecialchars($user_info['cv_pdf']); ?>"
                                        target="_blank" class="btn btn-custom mt-2">Tải về CV</a></p>
                                <?php else: ?>
                                <p>Chưa có CV.</p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Phần công việc -->
                            <?php if ($_SESSION['user_role'] === 'doanh_nghiep' && $jobs && $jobs->num_rows > 0): ?>
                            <div class="company-jobs mt-5">
                                <h3 class="section-title">Vị trí đang tuyển dụng</h3>
                                <a href="index.php?page=add_job" class="btn btn-custom mb-3">Thêm việc làm mới</a>
                                <div class="list-group">
                                    <?php while ($job = $jobs->fetch_assoc()): ?>
                                    <div class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">
                                                <?php echo htmlspecialchars($job['tieu_de'] ?? 'Chưa cập nhật'); ?></h5>
                                            <small><?php echo date('d/m/Y', strtotime($job['ngay_tao'] ?? date('Y-m-d'))); ?></small>
                                        </div>
                                        <p class="mb-1">
                                            <?php echo htmlspecialchars($job['mo_ta'] ?? 'Chưa cập nhật'); ?></p>
                                        <small><i class="fa fa-map-marker"></i>
                                            <?php echo htmlspecialchars($job['vi_tri'] ?? 'Chưa cập nhật'); ?></small>
                                        <div class="mt-2">
                                            <a href="index.php?page=view_job&id=<?php echo $job['id']; ?>"
                                                class="btn btn-custom btn-sm">Xem chi tiết</a>
                                            <a href="index.php?page=edit_job&id=<?php echo $job['id']; ?>"
                                                class="btn btn-custom btn-sm">Chỉnh sửa</a>
                                            <a href="index.php?page=delete_job&id=<?php echo $job['id']; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa việc làm này?');">Xóa</a>
                                        </div>
                                    </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                            <?php elseif ($_SESSION['user_role'] === 'doanh_nghiep'): ?>
                            <div class="company-jobs mt-5">
                                <h3 class="section-title">Vị trí đang tuyển dụng</h3>
                                <p>Chưa có việc làm nào. <a href="index.php?page=add_job"
                                        class="btn btn-custom btn-sm">Thêm việc làm mới</a></p>
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