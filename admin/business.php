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
    <title>Quản lý Doanh Nghiệp</title>
    <style>
        .company-logo-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
        }
        .status-0 { background-color: #ffc107; color: #000; } /* Chờ duyệt */
        .status-1 { background-color: #28a745; color: #fff; } /* Đã duyệt */
        .status-2 { background-color: #dc3545; color: #fff; } /* Từ chối */
        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
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
        }
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
    <style>
        .table-responsive, .table {
            width: 100% !important;
        }
        .table {
            margin-bottom: 0;
        }
        @media (max-width: 991.98px) {
            .table-responsive {
                padding-left: 0;
                padding-right: 0;
            }
        }
        .card.w-100 {
            box-shadow: 0 2px 12px rgba(44,62,80,0.08);
            border-radius: 12px;
            background: #fff;
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
                            <h1 class="h2">Quản lý Doanh Nghiệp</h1>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#companyModal">
                                <i class="fa fa-plus"></i> Thêm Doanh Nghiệp
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
                                                <input type="text" class="form-control" id="search" placeholder="Tên doanh nghiệp...">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="linh_vuc">Lĩnh vực</label>
                                                <select class="form-control" id="linh_vuc">
                                                    <option value="">Tất cả</option>
                                                    <?php 
                                                    $linh_vuc = $crud->db->query("SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC");
                                                    while($row = $linh_vuc->fetch_assoc()): ?>
                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['ten_linh_vuc'] ?></option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="trang_thai">Trạng thái</label>
                                                <select class="form-control" id="trang_thai">
                                                    <option value="">Tất cả</option>
                                                    <option value="0">Chờ duyệt</option>
                                                    <option value="1">Đã duyệt</option>
                                                    <option value="2">Từ chối</option>
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

                        <!-- Company Table -->
                        <div class="table-responsive" style="padding:0;">
                            <table class="table table-hover" id="companyTable">
                                <thead>
                                    <tr>
                                        <th>Logo</th>
                                        <th>Tên Doanh Nghiệp</th>
                                        <th>Lĩnh vực</th>
                                        <th>Quy mô</th>
                                        <th>Điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $companies = $crud->db->query("SELECT d.*, l.ten_linh_vuc 
                                                                   FROM doanh_nghiep d 
                                                                   LEFT JOIN linh_vuc l ON d.linh_vuc_id = l.id 
                                                                   ORDER BY d.ngay_tao DESC");
                                    while($row = $companies->fetch_assoc()): ?>
                                    <tr>
                                        <td>
                                            <?php if(!empty($row['logo'])): ?>
                                                <img src="../admin/assets/uploads/<?php echo $row['logo'] ?>" class="company-logo-thumb">
                                            <?php else: ?>
                                                <img src="../admin/assets/uploads/default_company.png" class="company-logo-thumb">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['ten_cong_ty'] ?></td>
                                        <td><?php echo $row['ten_linh_vuc'] ?></td>
                                        <td><?php echo $row['quy_mo'] ?></td>
                                        <td><?php echo $row['so_dien_thoai'] ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $row['trang_thai'] ?>">
                                                <?php 
                                                switch($row['trang_thai']){
                                                    case 0: echo 'Chờ duyệt'; break;
                                                    case 1: echo 'Đã duyệt'; break;
                                                    case 2: echo 'Từ chối'; break;
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="btn btn-sm btn-primary edit-company" data-id="<?php echo $row['id'] ?>" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-company" data-id="<?php echo $row['id'] ?>" title="Xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Duyệt
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item update-status" href="#" data-id="<?php echo $row['id'] ?>" data-status="0">Chờ duyệt</a>
                                                        <a class="dropdown-item update-status" href="#" data-id="<?php echo $row['id'] ?>" data-status="1">Duyệt</a>
                                                        <a class="dropdown-item update-status" href="#" data-id="<?php echo $row['id'] ?>" data-status="2">Từ chối</a>
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

    <!-- Add/Edit Company Modal -->
    <div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyModalLabel">Thêm Doanh Nghiệp Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="companyForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="company_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ten_cong_ty">Tên Doanh Nghiệp *</label>
                                    <input type="text" class="form-control" id="ten_cong_ty" name="ten_cong_ty" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="so_dien_thoai">Số điện thoại *</label>
                                    <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="url" class="form-control" id="website" name="website">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="linh_vuc_id">Lĩnh vực *</label>
                                    <select class="form-control" id="linh_vuc_id" name="linh_vuc_id" required>
                                        <option value="">Chọn lĩnh vực</option>
                                        <?php 
                                        $linh_vuc = $crud->db->query("SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC");
                                        while($row = $linh_vuc->fetch_assoc()): ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['ten_linh_vuc'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quy_mo">Quy mô *</label>
                                    <select class="form-control" id="quy_mo" name="quy_mo" required>
                                        <option value="">Chọn quy mô</option>
                                        <option value="Nhỏ">Nhỏ</option>
                                        <option value="Vừa">Vừa</option>
                                        <option value="Lớn">Lớn</option>
                                        <option value="Rất lớn">Rất lớn</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="trang_thai">Trạng thái *</label>
                                    <select class="form-control" id="trang_thai" name="trang_thai" required>
                                        <option value="0">Chờ duyệt</option>
                                        <option value="1">Đã duyệt</option>
                                        <option value="2">Từ chối</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" class="form-control-file" id="logo" name="logo">
                                    <small class="form-text text-muted">Kích thước tối đa: 2MB</small>
                                    <div id="logoPreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="dia_chi">Địa chỉ *</label>
                                    <textarea class="form-control" id="dia_chi" name="dia_chi" rows="2" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="mo_ta">Mô tả</label>
                                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3"></textarea>
                                </div>
                            </div>
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
        // Initialize DataTable
        $('#companyTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
            }
        });

        // Filter companies
        $('#filterBtn').click(function() {
            var search = $('#search').val().toLowerCase();
            var linh_vuc = $('#linh_vuc').val();
            var trang_thai = $('#trang_thai').val();
            
            $('#companyTable tbody tr').each(function() {
                var row = $(this);
                var name = row.find('td:eq(1)').text().toLowerCase();
                var field = row.find('td:eq(2)').text();
                var status = row.find('td:eq(5) span').attr('class').split(' ')[1].replace('status-', '');
                
                var nameMatch = search === '' || name.includes(search);
                var fieldMatch = linh_vuc === '' || field === $('#linh_vuc option[value="'+linh_vuc+'"]').text();
                var statusMatch = trang_thai === '' || status === trang_thai;
                
                if (nameMatch && fieldMatch && statusMatch) {
                    row.show();
                } else {
                    row.hide();
                }
            });
        });

        // Khi nhấn nút Thêm Doanh Nghiệp
        $('.btn-primary[data-target=\"#companyModal\"]').click(function() {
            $('#companyModalLabel').text('Thêm Doanh Nghiệp Mới');
            $('#companyForm')[0].reset();
            $('#logoPreview').html('');
            $('#company_id').val('');
        });

        // Khi nhấn nút chỉnh sửa
        $('.edit-company').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '../admin/ajax.php?action=get_company',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        $('#companyModalLabel').text('Chỉnh sửa Doanh Nghiệp');
                        $('#company_id').val(resp.data.id);
                        $('#ten_cong_ty').val(resp.data.ten_cong_ty);
                        $('#email').val(resp.data.email);
                        $('#so_dien_thoai').val(resp.data.so_dien_thoai);
                        $('#website').val(resp.data.website);
                        $('#linh_vuc_id').val(resp.data.linh_vuc_id);
                        $('#quy_mo').val(resp.data.quy_mo);
                        $('#trang_thai').val(resp.data.trang_thai);
                        $('#dia_chi').val(resp.data.dia_chi);
                        $('#mo_ta').val(resp.data.mo_ta);
                        if(resp.data.logo) {
                            $('#logoPreview').html('<img src=\"../admin/assets/uploads/'+resp.data.logo+'\" class=\"img-thumbnail\" style=\"max-height: 100px;\">');
                        } else {
                            $('#logoPreview').html('');
                        }
                        $('#companyModal').modal('show');
                    } else {
                        alert(resp.msg);
                    }
                }
            });
        });

        // Save company
        $('#companyForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                url: '../admin/ajax.php?action=save_company',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(resp) {
                    if(resp == 1) {
                        alert('Lưu thành công');
                        $('#companyModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + resp);
                    }
                }
            });
        });

        // Delete company
        $('.delete-company').click(function() {
            if(confirm('Bạn có chắc chắn muốn xóa doanh nghiệp này?')) {
                var id = $(this).data('id');
                $.ajax({
                    url: '../admin/ajax.php?action=delete_company',
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

        // Update status
        $('.update-status').off('click').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var status = $(this).data('status');
            $.ajax({
                url: '../admin/ajax.php?action=update_company_status',
                type: 'POST',
                data: {id: id, status: status},
                success: function(resp) {
                    if(resp == 1) {
                        alert('Cập nhật trạng thái thành công');
                        location.reload();
                    } else {
                        var msg = 'Có lỗi xảy ra';
                        try {
                            var json = JSON.parse(resp);
                            if(json.error) msg += ': ' + json.error;
                        } catch(e) {}
                        alert(msg);
                    }
                },
                error: function(xhr) {
                    alert('Lỗi kết nối server!');
                }
            });
        });

        // Preview logo before upload
        $('#logo').change(function() {
            var file = this.files[0];
            if(file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#logoPreview').html('<img src="'+e.target.result+'" class="img-thumbnail" style="max-height: 100px;">');
                }
                reader.readAsDataURL(file);
            }
        });

        // Đảm bảo dropdown hoạt động đúng với Bootstrap
        // Nếu dùng Bootstrap 4+, không cần JS riêng cho dropdown-toggle, chỉ cần markup đúng
        // Nhưng để chắc chắn, thêm đoạn sau để tránh xung đột hoặc lỗi khi có nhiều bảng động:
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