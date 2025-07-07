<?php include '../views/layouts/header.php'; ?>
<head>
    <link rel="stylesheet" href="../assets/css/view_company.css">
    <style>
        .job-detail { background: #fff; border-radius: 8px; padding: 32px; margin-top: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .job-header { display: flex; align-items: center; margin-bottom: 24px; }
        .job-header img { width: 80px; height: 80px; object-fit: contain; border-radius: 8px; margin-right: 24px; }
        .job-title { font-size: 2rem; font-weight: bold; }
        .job-meta { color: #666; margin-bottom: 8px; }
        .job-actions { margin-top: 24px; }
        .job-actions .btn { margin-right: 12px; }
        .apply-form { display: none; background: #f9f9f9; border-radius: 8px; padding: 24px; margin-top: 24px; }
        .similar-jobs { margin-top: 48px; }
        .similar-jobs .list-group-item { margin-bottom: 8px; }
    </style>
</head>
<div class="container job-detail">
    <div class="job-header">
        <img src="../Assets/images/companies_logo/<?php echo htmlspecialchars($job['logo']) ?>" alt="<?php echo htmlspecialchars($job['ten_cong_ty']) ?>">
        <div>
            <div class="job-title"><?php echo htmlspecialchars($job['tieu_de']) ?></div>
            <div class="job-meta">
                <a href="index.php?page=view_company&id=<?php echo $job['doanh_nghiep_id'] ?>" class="fw-bold">
                    <?php echo htmlspecialchars($job['ten_cong_ty']) ?>
                </a> |
                <span><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($job['ngay_tao'])) ?></span> |
                <span><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($job['dia_diem']) ?></span> |
                <span><i class="fa fa-money"></i> <?php echo htmlspecialchars($job['luong']) ?></span>
            </div>
            <div class="job-meta">
                <span><i class="fa fa-briefcase"></i> <?php echo htmlspecialchars($job['chuyen_nganh']) ?></span> |
                <span><i class="fa fa-users"></i> <?php echo htmlspecialchars($job['quy_mo']) ?></span>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <h4>Mô tả công việc</h4>
        <div><?php echo nl2br(htmlspecialchars($job['mo_ta'])) ?></div>
    </div>
    <div class="mb-4">
        <h4>Yêu cầu</h4>
        <div><?php echo nl2br(htmlspecialchars($job['yeu_cau'])) ?></div>
    </div>
    <div class="mb-4">
        <h4>Phúc lợi</h4>
        <div><?php echo isset($job['phuc_loi']) ? nl2br(htmlspecialchars($job['phuc_loi'])) : '<em>Liên hệ doanh nghiệp để biết thêm chi tiết</em>'; ?></div>
    </div>
    <div class="job-actions">
        <button class="btn btn-primary" id="btn-apply"><i class="fa fa-paper-plane"></i> Ứng tuyển</button>
        <button class="btn btn-outline-secondary" id="btn-save"><i class="fa fa-bookmark"></i> Lưu tin</button>
    </div>
    <form class="apply-form" id="applyForm" enctype="multipart/form-data" method="post" action="index.php?page=apply_job&id=<?php echo $job['id'] ?>">
        <h4>Ứng tuyển vị trí này</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Mã số sinh viên</label>
                <input type="text" name="student_id" class="form-control" value="<?php echo isset($_SESSION['user']['student_id']) ? htmlspecialchars($_SESSION['user']['student_id']) : '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Họ tên</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : '' ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control" value="<?php echo isset($_SESSION['user']['phone']) ? htmlspecialchars($_SESSION['user']['phone']) : '' ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label>Địa chỉ</label>
                <input type="text" name="address" class="form-control" value="<?php echo isset($_SESSION['user']['address']) ? htmlspecialchars($_SESSION['user']['address']) : '' ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label>Chuyên ngành</label>
                <input type="text" name="major" class="form-control" value="<?php echo isset($_SESSION['user']['major']) ? htmlspecialchars($_SESSION['user']['major']) : '' ?>" required>
            </div>
            <div class="col-md-12 mb-3">
                <label>Tải CV (PDF, Word)</label>
                <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx">
                <?php if (isset($_SESSION['user']['cv_file']) && $_SESSION['user']['cv_file']): ?>
                    <div class="mt-2">CV đã tải lên: <a href="<?php echo htmlspecialchars($_SESSION['user']['cv_file']) ?>" target="_blank">Xem CV</a></div>
                <?php endif; ?>
            </div>
            <div class="col-md-12 mb-3">
                <a href="index.php?page=cv_guide" target="_blank">Hướng dẫn viết CV</a>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Gửi ứng tuyển</button>
    </form>
    <?php if ($similar_jobs && $similar_jobs->num_rows > 0): ?>
    <div class="similar-jobs">
        <h4>Việc làm tương tự</h4>
        <div class="list-group">
            <?php while ($sj = $similar_jobs->fetch_assoc()): ?>
            <a href="index.php?page=view_job&id=<?php echo $sj['id'] ?>" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?php echo htmlspecialchars($sj['tieu_de']) ?></h5>
                    <small><?php echo date('d/m/Y', strtotime($sj['ngay_tao'])) ?></small>
                </div>
                <p class="mb-1"><?php echo htmlspecialchars($sj['mo_ta']) ?></p>
                <small><i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($sj['dia_diem']) ?></small>
            </a>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
    document.getElementById('btn-apply').onclick = function() {
        var form = document.getElementById('applyForm');
        form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        form.scrollIntoView({behavior: 'smooth'});
    };
</script>
<?php include '../views/layouts/footer.php'; ?> 