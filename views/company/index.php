<?php include '../views/layouts/header.php'; ?>

<head>
    <link rel="stylesheet" href="../assets/css/companies.css">
</head>


<div class="container mt-3 pt-2">
    <div class="filter-section">
        <form id="filterForm" method="GET" action="index.php?page=companies">
            <div class="row">
                <div class="col-md-4">
                    <div class="filter-group">
                        <label for="search">Tìm kiếm doanh nghiệp</label>
                        <input type="text" id="search" name="search" placeholder="Nhập tên doanh nghiệp..."
                            value="<?php echo htmlspecialchars($search) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter-group">
                        <label for="linh_vuc">Lĩnh vực</label>
                        <select id="linh_vuc" name="linh_vuc">
                            <option value="">Tất cả lĩnh vực</option>
                            <?php while($lv = $linh_vuc_list->fetch_assoc()): ?>
                            <option value="<?php echo $lv['id'] ?>"
                                <?php echo $linh_vuc_filter == $lv['id'] ? 'selected' : '' ?>>
                                <?php echo $lv['ten_linh_vuc'] ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="filter-group">
                        <label for="quy_mo">Quy mô</label>
                        <select id="quy_mo" name="quy_mo">
                            <option value="">Tất cả quy mô</option>
                            <option value="Nhỏ" <?php echo $quy_mo_filter == 'Nhỏ' ? 'selected' : '' ?>>Nhỏ</option>
                            <option value="Vừa" <?php echo $quy_mo_filter == 'Vừa' ? 'selected' : '' ?>>Vừa</option>
                            <option value="Lớn" <?php echo $quy_mo_filter == 'Lớn' ? 'selected' : '' ?>>Lớn</option>
                            <option value="Rất lớn" <?php echo $quy_mo_filter == 'Rất lớn' ? 'selected' : '' ?>>Rất lớn
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary btn-filter">Lọc</button>
                    <button type="button" class="btn btn-secondary" onclick="resetFilter()">Xóa lọc</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row company-list-container">
        <?php if($doanh_nghiep->num_rows > 0): ?>
        <?php while($row = $doanh_nghiep->fetch_assoc()): ?>
        <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
            <div class="card company-list w-100">
                <div class="d-flex">
                    <div class="logo-container">
                        <?php if(!empty($row['logo'])): ?>
                        <img src="../Assets/images/companies_logo/<?php echo $row['logo'] ?>"
                            alt="<?php echo $row['ten_cong_ty'] ?>">
                        <?php else: ?>
                        <img src="assets/uploads/default_company.png" alt="Logo mặc định">
                        <?php endif; ?>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="company-info">
                            <h3><?php echo $row['ten_cong_ty'] ?></h3>
                            <p><i class="fa fa-map-marker"></i> <?php echo $row['dia_chi'] ?></p>
                            <p><i class="fa fa-phone"></i> <?php echo $row['so_dien_thoai'] ?></p>
                            <p><i class="fa fa-envelope"></i> <?php echo $row['email'] ?></p>
                            <p><i class="fa fa-globe"></i> <a href="<?php echo $row['website'] ?>"
                                    target="_blank"><?php echo $row['website'] ?></a></p>
                            <div class="mt-2">
                                <span class="industry"><?php echo $row['ten_linh_vuc'] ?></span>
                                <span class="size"><?php echo $row['quy_mo'] ?></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <button class="btn btn-primary view-detail" data-id="<?php echo $row['id'] ?>">
                                <a href="index.php?page=view_company&id=<?php echo $row['id'] ?>"
                                    class="btn btn-primary">Xem
                                    chi tiết</a>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php else: ?>
        <div class="col-md-12">
            <div class="alert alert-info">Không tìm thấy doanh nghiệp nào phù hợp.</div>
        </div>
        <?php endif; ?>
    </div>

    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">&raquo;</a>
    </div>
</div>

<script>
function resetFilter() {
    $('#search').val('');
    $('#linh_vuc').val('');
    $('#quy_mo').val('');
    loadCompanies();
}

function bindViewDetail() {
    $('.view-detail').off('click').on('click', function() {
        location.href = "index.php?page=view_company&id=" + $(this).attr('data-id');
    });
}

function loadCompanies() {
    var search = $('#search').val();
    var linh_vuc = $('#linh_vuc').val();
    var quy_mo = $('#quy_mo').val();
    $.ajax({
        url: 'admin/ajax.php?action=get_companies',
        type: 'POST',
        data: {
            search: search,
            linh_vuc: linh_vuc,
            quy_mo: quy_mo
        },
        beforeSend: function() {
            $('.company-list-container').html(
                '<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>');
        },
        success: function(resp) {
            if (resp) {
                resp = JSON.parse(resp);
                if (resp.status == 'success') {
                    $('.company-list-container').html(resp.html);
                    bindViewDetail();
                } else {
                    alert(resp.msg);
                }
            }
        },
        error: function(xhr, status, error) {
            alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            console.error(xhr.responseText);
        }
    });
}

$(document).ready(function() {
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        loadCompanies();
        return false;
    });
    $('#linh_vuc, #quy_mo').change(function() {
        loadCompanies();
    });
    var searchTimeout;
    $('#search').keyup(function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            loadCompanies();
        }, 500);
    });
    bindViewDetail();
});
</script>

<?php include '../views/layouts/footer.php'; ?>