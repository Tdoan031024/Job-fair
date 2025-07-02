<?php include '../views/layouts/header.php'; ?>
<style>
<?php include '../assets/css/viewcompany.css';
?>
</style>

<div class="container mt-3 pt-2">
    <div class="company-detail">
        <div class="company-header">
            <div>
                <?php if (!empty($company['logo'])): ?>
                <img src="assets/uploads/<?php echo $company['logo'] ?>" alt="<?php echo $company['ten_cong_ty'] ?>"
                    class="company-logo">
                <?php else: ?>
                <img src="assets/uploads/default_company.png" alt="Logo mặc định" class="company-logo">
                <?php endif; ?>
            </div>
            <div class="company-title">
                <h1><?php echo $company['ten_cong_ty'] ?></h1>
                <div>
                    <span class="industry"><?php echo $company['ten_linh_vuc'] ?></span>
                    <span class="size"><?php echo $company['quy_mo'] ?></span>
                </div>
            </div>
        </div>
        <div class="company-info">
            <h3>Thông tin doanh nghiệp</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <i class="fa fa-map-marker"></i> <strong>Địa chỉ:</strong> <?php echo $company['dia_chi'] ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-phone"></i> <strong>Điện thoại:</strong> <?php echo $company['so_dien_thoai'] ?>
                    </div>
                    <div class="info-item">
                        <i class="fa fa-envelope"></i> <strong>Email:</strong> <?php echo $company['email'] ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <i class="fa fa-globe"></i> <strong>Website:</strong>
                        <a href="<?php echo $company['website'] ?>"
                            target="_blank"><?php echo $company['website'] ?></a>
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
                <?php echo nl2br($company['mo_ta']) ?>
            </div>
        </div>
        <?php
        $jobs = $this->conn->query("SELECT * FROM viec_lam WHERE doanh_nghiep_id = {$company['id']} AND trang_thai = 1");
        if ($jobs->num_rows > 0):
        ?>
        <div class="company-jobs mt-5">
            <h3 class="section-title">Vị trí đang tuyển dụng</h3>
            <div class="list-group">
                <?php while ($job = $jobs->fetch_assoc()): ?>
                <a href="index.php?page=view_job&id=<?php echo $job['id'] ?>"
                    class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?php echo $job['tieu_de'] ?></h5>
                        <small><?php echo $job['ngay_tao'] ?></small>
                    </div>
                    <p class="mb-1"><?php echo $job['mo_ta'] ?></p>
                    <small><i class="fa fa-map-marker"></i> <?php echo $job['dia_diem'] ?></small>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="text-center back-btn">
            <a href="index.php?page=companies" class="btn btn-secondary">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>