<?php include '../views/layouts/header.php'; ?>

<head>
    <link rel="stylesheet" href="../assets/css/view_company.css">
</head>

<div class="container mt-5 pt-3">
    <div class="company-detail">
        <div class="company-header">
            <div>
                <?php if (!empty($company['logo'])): ?>
                <img src="../Assets/images/companies_logo/<?php echo htmlspecialchars($company['logo']) ?>"
                    alt="<?php echo htmlspecialchars($company['ten_cong_ty']) ?>" class="company-logo">
                <?php else: ?>
                <img src="assets/uploads/default_company.png" alt="Logo mặc định" class="company-logo">
                <?php endif; ?>
            </div>
            <div class="company-title">
                <h1><?php echo htmlspecialchars($company['ten_cong_ty']) ?></h1>
                <div>
                    <span class="industry"><?php echo htmlspecialchars($company['ten_linh_vuc']) ?></span>
                    <span class="size"><?php echo htmlspecialchars($company['quy_mo']) ?></span>
                </div>
            </div>
        </div>
        <div class="company-info">
            <h3>Thông tin doanh nghiệp</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <i class="fa fa-map-marker"></i> <strong>Địa chỉ:</strong>
                        <?php echo htmlspecialchars($company['dia_chi']) ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-phone"></i> <strong>Điện thoại:</strong>
                        <?php echo htmlspecialchars($company['so_dien_thoai']) ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-envelope"></i> <strong>Email:</strong>
                        <?php echo htmlspecialchars($company['email']) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <i class="fa fa-globe"></i> <strong>Website:</strong>
                        <a href="<?php echo htmlspecialchars($company['website']) ?>"
                            target="_blank"><?php echo htmlspecialchars($company['website']) ?></a>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-calendar"></i> <strong>Ngày tham gia:</strong>
                        <?php echo date('d/m/Y', strtotime($company['ngay_tao'])) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="company-description">
            <h3 class="section-title">Giới thiệu</h3>
            <div class="description-content">
                <?php echo nl2br(htmlspecialchars($company['mo_ta'])) ?>
            </div>
        </div>
        <?php if ($jobs && $jobs->num_rows > 0): ?>
        <div class="company-jobs mt-5">
            <h3 class="section-title">Vị trí đang tuyển dụng</h3>
            <div class="list-group">
                <?php while ($job = $jobs->fetch_assoc()): ?>
                <a href="index.php?page=view_job&id=<?php echo $job['id'] ?>"
                    class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo htmlspecialchars($job['tieu_de']) ?></h5>
                        <small><?php echo date('d/m/Y', strtotime($job['ngay_tao'])) ?></small>
                    </div>
                    <p class="mb-1"><?php echo htmlspecialchars($job['mo_ta']) ?></p>
                    <small><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($job['dia_diem']) ?></small>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="back-btn">
            <a href="index.php?page=companies" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách
            </a>
            <a href="index.php?controller=company&action=contact&id=<?php echo $company['id'] ?>"
                class="btn btn-contact">
                <i class="fa fa-envelope"></i> Liên hệ ứng tuyển
            </a>
        </div>
    </div>
</div>

<?php include '../views/layouts/footer.php'; ?>