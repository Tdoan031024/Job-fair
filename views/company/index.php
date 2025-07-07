<?php include '../views/layouts/header.php'; ?>

<head>
    <link rel="stylesheet" href="../assets/css/companies.css">
</head>

<?php
// Đảm bảo các biến filter luôn tồn tại để không lỗi khi render filter
$search = isset($search) ? $search : '';
$linh_vuc_filter = isset($linh_vuc) ? $linh_vuc : '';
$quy_mo_filter = isset($quy_mo) ? $quy_mo : '';
?>

<header class="masthead">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-8 align-self-end mb-4 page-title">
                <h3 class="text-white">Danh Sách Doanh Nghiệp</h3>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>

<div class="container mt-3 pt-2">
    <div class="filter-section">
        <form id="filterForm" method="GET" action="">
            <input type="hidden" name="page" value="companies">
            <input type="hidden" name="p" value="<?php echo $page; ?>">
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
                    <button type="button" class="btn btn-secondary" onclick="resetFilterForm()">Xóa lọc</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        <?php if (!empty($doanh_nghiep)): ?>
            <?php foreach ($doanh_nghiep as $row): ?>
                <div class="col-12 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="card company-list w-100">
                        <div class="d-flex">
                            <div class="logo-container">
                                <?php if(!empty($row['logo'])): ?>
                                    <img src="../Assets/images/companies_logo/<?php echo $row['logo'] ?>" alt="<?php echo $row['ten_cong_ty'] ?>">
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
                                    <p><i class="fa fa-globe"></i> <a href="<?php echo $row['website'] ?>" target="_blank"><?php echo $row['website'] ?></a></p>
                                    <div class="mt-2">
                                        <span class="industry"><?php echo $row['linh_vuc'] ?></span>
                                        <span class="size"><?php echo $row['quy_mo'] ?></span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mt-3">
                                    <a href="index.php?page=view_company&id=<?php echo $row['id'] ?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info">Không tìm thấy doanh nghiệp nào phù hợp.</div>
            </div>
        <?php endif; ?>
    </div>

    <div class="pagination-container mt-4">
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center flex-wrap">
                    <!-- First & Prev -->
                    <li class="page-item<?= $page == 1 ? ' disabled' : '' ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['p' => 1])); ?>">&laquo;&laquo;</a>
                    </li>
                    <li class="page-item<?= $page == 1 ? ' disabled' : '' ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['p' => max(1, $page - 1)])); ?>">&laquo;</a>
                    </li>
                    <!-- Số trang -->
                    <?php
                    $start = max(1, $page - 2);
                    $end = min($total_pages, $page + 2);
                    if ($page <= 3) $end = min(5, $total_pages);
                    if ($page >= $total_pages - 2) $start = max(1, $total_pages - 4);
                    for ($i = $start; $i <= $end; $i++): 
                        if ($i > $total_pages) break;
                    ?>
                        <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['p' => $i])); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <!-- Next & Last -->
                    <li class="page-item<?= $page == $total_pages ? ' disabled' : '' ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['p' => min($total_pages, $page + 1)])); ?>">&raquo;</a>
                    </li>
                    <li class="page-item<?= $page == $total_pages ? ' disabled' : '' ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['p' => $total_pages])); ?>">&raquo;&raquo;</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</div>

<script>
let currentPage = 1;
const perPage = 8;

function resetFilter() {
    $('#search').val('');
    $('#linh_vuc').val('');
    $('#quy_mo').val('');
    currentPage = 1;
    loadCompanies();
}

function bindViewDetail() {
    $('.view-detail').off('click').on('click', function() {
        location.href = "index.php?page=view_company&id=" + $(this).attr('data-id');
    });
}

function renderPagination(totalPages, currentPage) {
    let html = '';
    if (totalPages <= 1) {
        $('#pagination-container').html('');
        return;
    }
    html += `<nav aria-label="Page navigation"><ul class="pagination justify-content-center flex-wrap">`;
    // First & Prev
    html += `<li class="page-item${currentPage === 1 ? ' disabled' : ''}"><a class="page-link" href="#" data-page="1">&laquo;&laquo;</a></li>`;
    html += `<li class="page-item${currentPage === 1 ? ' disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;
    // Số trang
    let start = Math.max(1, currentPage - 2);
    let end = Math.min(totalPages, currentPage + 2);
    if (currentPage <= 3) end = Math.min(5, totalPages);
    if (currentPage >= totalPages - 2) start = Math.max(1, totalPages - 4);
    for (let i = start; i <= end; i++) {
        html += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#" data-page="${i}">${i}</a></li>`;
    }
    // Next & Last
    html += `<li class="page-item${currentPage === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;
    html += `<li class="page-item${currentPage === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" data-page="${totalPages}">&raquo;&raquo;</a></li>`;
    html += `</ul></nav>`;
    $('#pagination-container').html(html);
    // Sự kiện click
    $('#pagination-container .page-link').off('click').on('click', function(e) {
        e.preventDefault();
        let page = parseInt($(this).data('page'));
        if (!isNaN(page) && page !== currentPage && page >= 1) {
            currentPage = page;
            loadCompanies();
        }
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
            quy_mo: quy_mo,
            page: currentPage,
            per_page: perPage
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
                    renderPagination(resp.total_pages, resp.current_page);
                    bindViewDetail();
                } else {
                    $('.company-list-container').html('<div class="alert alert-info">Không tìm thấy doanh nghiệp nào phù hợp.</div>');
                    $('#pagination-container').html('');
                }
            }
        },
        error: function(xhr, status, error) {
            $('.company-list-container').html('<div class="alert alert-danger">Có lỗi xảy ra. Vui lòng thử lại sau.</div>');
            $('#pagination-container').html('');
            console.error(xhr.responseText);
        }
    });
}

function resetFilterForm() {
    window.location = 'index.php?page=companies';
}

$(document).ready(function() {
    $('#filterForm').submit(function(e) {
        e.preventDefault();
        currentPage = 1;
        loadCompanies();
        return false;
    });
    $('#linh_vuc, #quy_mo').change(function() {
        currentPage = 1;
        loadCompanies();
    });
    var searchTimeout;
    $('#search').keyup(function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            currentPage = 1;
            loadCompanies();
        }, 500);
    });
    bindViewDetail();
    loadCompanies(); // Load lần đầu
});
</script>

<?php include '../views/layouts/footer.php'; ?>