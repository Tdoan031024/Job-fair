<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include './admin_class.php';
$crud = new Action();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.php'; ?>
    <title>Quản lý Việc làm</title>
    <style>
        .company-logo-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 80px;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 0.95em;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 1px 4px rgba(44,62,80,0.08);
            margin: 0 auto;
            text-align: center;
        }
        .status-1 {
            background: linear-gradient(90deg,rgb(16, 145, 59) 0%, #008000 100%);
            color: #fff;
            border: none;
        }
        .status-0 {
            background: linear-gradient(90deg, #ff5858 0%, #f09819 100%);
            color: #fff;
            border: none;
        }
        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        .action-btns .btn, .action-btns .btn-group .btn {
            border-radius: 20px !important;
            min-width: 36px;
            min-height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            font-size: 1rem;
            transition: box-shadow 0.15s, background 0.15s;
        }
        .action-btns .btn:hover, .action-btns .btn-group .btn:hover {
            box-shadow: 0 2px 8px rgba(44,62,80,0.10);
            background: #e9ecef;
        }
        .action-btns .btn-group {
            margin-left: 0.25rem;
        }
        @media (max-width: 575.98px) {
            .action-btns {
                flex-direction: column;
                gap: 0.25rem;
                align-items: stretch;
            }
            .action-btns .btn-group {
                margin-left: 0;
            }
            .action-btns .btn, .action-btns .btn-group .btn {
                width: 100%;
                min-width: unset;
                justify-content: flex-start;
            }
        }
    </style>
    <style>
        @media (max-width: 991.98px) {
            main[role="main"] {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }
        }
        .container-fluid, .row.no-gutters {
            margin: 0 !important;
            padding: 0 !important;
        }
        .card {
            margin-bottom: 16px;
        }
        @media (max-width: 575.98px) {
            .card {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container-fluid mt-3 pt-2" style="min-height:100vh;">
        <div class="row">
            <div class="col-12">
                <div class="card mb-0 border-0 w-100">
                    <div class="card-body p-0">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-2 border-bottom">
                            <h1 class="h2">Quản lý Việc làm</h1>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#jobModal">
                                <i class="fa fa-plus"></i> Thêm Việc làm
                            </button>
                        </div>
                        <!-- Filter Section -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <form id="filterForm">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="search">Tìm kiếm</label>
                                                <input type="text" class="form-control" id="search" placeholder="Tiêu đề việc làm, công ty...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="trang_thai">Trạng thái</label>
                                                <select class="form-control" id="trang_thai">
                                                    <option value="">Tất cả</option>
                                                    <option value="1">Đang tuyển</option>
                                                    <option value="0">Đã đóng</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-primary mt-4" id="filterBtn">Lọc</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Job Table -->
                        <div class="table-responsive" style="padding:0;">
                            <table class="table table-hover" id="jobTable">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Công ty</th>
                                        <th>Tiêu đề</th>
                                        <th>Chuyên ngành</th>
                                        <th>Kinh nghiệm</th>
                                        <th>Địa điểm</th>
                                        <th>Lương</th>
                                        <th>Hạn nộp</th>
                                        <th>Số lượng</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $jobs = $crud->db->query("SELECT v.*, d.ten_cong_ty, d.logo FROM viec_lam v JOIN doanh_nghiep d ON v.doanh_nghiep_id = d.id ORDER BY v.ngay_tao DESC");
                                    while($row = $jobs->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <?php if(!empty($row['logo'])): ?>
                                                <img src="../admin/assets/uploads/<?php echo $row['logo'] ?>" class="company-logo-thumb">
                                            <?php else: ?>
                                                <img src="../admin/assets/uploads/default_company.png" class="company-logo-thumb">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['ten_cong_ty'] ?></td>
                                        <td><?php echo $row['tieu_de'] ?></td>
                                        <td><?php echo $row['chuyen_nganh'] ?></td>
                                        <td><?php echo $row['kinh_nghiem'] ?></td>
                                        <td><?php echo $row['dia_diem'] ?></td>
                                        <td><?php echo $row['luong'] ?></td>
                                        <td><?php echo $row['han_nop'] ?></td>
                                        <td><?php echo $row['so_luong'] ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $row['trang_thai'] ?>">
                                                <?php echo $row['trang_thai'] == 1 ? 'Đang tuyển' : 'Đã đóng'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="btn btn-sm btn-primary edit-job" data-id="<?php echo $row['id'] ?>" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-job" data-id="<?php echo $row['id'] ?>" title="Xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Trạng thái
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item update-status" href="#" data-id="<?php echo $row['id'] ?>" data-status="1">Đang tuyển</a>
                                                        <a class="dropdown-item update-status" href="#" data-id="<?php echo $row['id'] ?>" data-status="0">Đã đóng</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add/Edit Job Modal -->
    <div class="modal fade" id="jobModal" tabindex="-1" role="dialog" aria-labelledby="jobModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="jobModalLabel">Thêm Việc làm mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="jobForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="job_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="doanh_nghiep_id">Doanh nghiệp *</label>
                                    <select class="form-control" id="doanh_nghiep_id" name="doanh_nghiep_id" required>
                                        <option value="">Chọn doanh nghiệp</option>
                                        <?php 
                                        $companies = $crud->db->query("SELECT id, ten_cong_ty FROM doanh_nghiep WHERE trang_thai=1 ORDER BY ten_cong_ty ASC");
                                        while($c = $companies->fetch_assoc()): ?>
                                            <option value="<?php echo $c['id'] ?>"><?php echo $c['ten_cong_ty'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tieu_de">Tiêu đề *</label>
                                    <input type="text" class="form-control" id="tieu_de" name="tieu_de" required>
                                </div>
                                <div class="form-group">
                                    <label for="chuyen_nganh">Chuyên ngành *</label>
                                    <input type="text" class="form-control" id="chuyen_nganh" name="chuyen_nganh" required>
                                </div>
                                <div class="form-group">
                                    <label for="kinh_nghiem">Kinh nghiệm *</label>
                                    <input type="text" class="form-control" id="kinh_nghiem" name="kinh_nghiem" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dia_diem">Địa điểm *</label>
                                    <input type="text" class="form-control" id="dia_diem" name="dia_diem" required>
                                </div>
                                <div class="form-group">
                                    <label for="luong">Lương</label>
                                    <input type="text" class="form-control" id="luong" name="luong">
                                </div>
                                <div class="form-group">
                                    <label for="han_nop">Hạn nộp *</label>
                                    <input type="date" class="form-control" id="han_nop" name="han_nop" required>
                                </div>
                                <div class="form-group">
                                    <label for="so_luong">Số lượng *</label>
                                    <input type="number" class="form-control" id="so_luong" name="so_luong" min="1" required>
                                </div>
                                <div class="form-group">
                                    <label for="trang_thai">Trạng thái *</label>
                                    <select class="form-control" id="trang_thai" name="trang_thai" required>
                                        <option value="1">Đang tuyển</option>
                                        <option value="0">Đã đóng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô tả</label>
                            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="yeu_cau">Yêu cầu</label>
                            <textarea class="form-control" id="yeu_cau" name="yeu_cau" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        // DataTable
        $('#jobTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
            }
        });
        // Filter
        $('#filterBtn').click(function() {
            var search = $('#search').val().toLowerCase();
            var trang_thai = $('#trang_thai').val();
            $('#jobTable tbody tr').each(function() {
                var row = $(this);
                var title = row.find('td:eq(2)').text().toLowerCase();
                var company = row.find('td:eq(1)').text().toLowerCase();
                var status = row.find('td:eq(9) span').attr('class').split(' ')[1].replace('status-', '');
                var match = (search === '' || title.includes(search) || company.includes(search)) && (trang_thai === '' || status === trang_thai);
                row.toggle(match);
            });
        });
        // Thêm việc làm
        $('.btn-primary[data-target="#jobModal"]').click(function() {
            $('#jobModalLabel').text('Thêm Việc làm mới');
            $('#jobForm')[0].reset();
            $('#job_id').val('');
        });
        // Sửa việc làm
        $('.edit-job').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '../admin/ajax.php?action=get_job',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        $('#jobModalLabel').text('Chỉnh sửa Việc làm');
                        $('#job_id').val(resp.data.id);
                        $('#doanh_nghiep_id').val(resp.data.doanh_nghiep_id);
                        $('#tieu_de').val(resp.data.tieu_de);
                        $('#chuyen_nganh').val(resp.data.chuyen_nganh);
                        $('#kinh_nghiem').val(resp.data.kinh_nghiem);
                        $('#dia_diem').val(resp.data.dia_diem);
                        $('#luong').val(resp.data.luong);
                        $('#han_nop').val(resp.data.han_nop);
                        $('#so_luong').val(resp.data.so_luong);
                        $('#trang_thai').val(resp.data.trang_thai);
                        $('#mo_ta').val(resp.data.mo_ta);
                        $('#yeu_cau').val(resp.data.yeu_cau);
                        $('#jobModal').modal('show');
                    } else {
                        alert(resp.msg);
                    }
                }
            });
        });
        // Lưu việc làm
        $('#jobForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '../admin/ajax.php?action=save_job',
                type: 'POST',
                data: formData,
                success: function(resp) {
                    if(resp == 1) {
                        alert('Lưu thành công');
                        $('#jobModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + resp);
                    }
                }
            });
        });
        // Xóa việc làm
        $('.delete-job').click(function() {
            if(confirm('Bạn có chắc chắn muốn xóa việc làm này?')) {
                var id = $(this).data('id');
                $.ajax({
                    url: '../admin/ajax.php?action=delete_job',
                    type: 'POST',
                    data: {id: id},
                    success: function(resp) {
                        if(resp == 1) {
                            alert('Xóa thành công');
                            location.reload();
                        } else {
                            alert('Có lỗi xảy ra: ' + resp);
                        }
                    }
                });
            }
        });
        // Đổi trạng thái
        $('.update-status').off('click').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var status = $(this).data('status');
            $.ajax({
                url: '../admin/ajax.php?action=save_job',
                type: 'POST',
                data: {id: id, trang_thai: status},
                success: function(resp) {
                    if(resp == 1) {
                        alert('Cập nhật trạng thái thành công');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + resp);
                    }
                }
            });
        });
        // Dropdown menu xử lý giống business.php
        $(document).on('click', '.dropdown-toggle', function(e) {
            e.stopPropagation();
            var $parent = $(this).parent();
            // Đóng các dropdown khác
            $('.dropdown-menu').not($parent.find('.dropdown-menu')).removeClass('show');
            $parent.find('.dropdown-menu').toggleClass('show');
        });
        // Đóng dropdown khi click ngoài
        $(document).on('click', function(e) {
            if(!$(e.target).closest('.btn-group').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });
    });
    </script>
</body>
</html>
