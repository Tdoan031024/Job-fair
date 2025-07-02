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
    <title>Quản lý Lĩnh vực</title>
    <style>
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
        .table-responsive, .table {
            width: 100% !important;
        }
        .table {
            margin-bottom: 0;
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
                            <h1 class="h2">Quản lý Lĩnh vực</h1>
                            <button class="btn btn-primary" data-toggle="modal" data-target="#linhvucModal">
                                <i class="fa fa-plus"></i> Thêm Lĩnh vực
                            </button>
                        </div>
                        <div class="table-responsive" style="padding:0;">
                            <table class="table table-hover" id="linhvucTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên lĩnh vực</th>
                                        <th>Mô tả</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $linhvuc = $crud->db->query("SELECT * FROM linh_vuc ORDER BY ten_linh_vuc ASC");
                                    $i = 1;
                                    while($row = $linhvuc->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo htmlspecialchars($row['ten_linh_vuc']); ?></td>
                                        <td><?php echo htmlspecialchars($row['mo_ta']); ?></td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="btn btn-sm btn-primary edit-linhvuc" data-id="<?php echo $row['id'] ?>" title="Sửa">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-linhvuc" data-id="<?php echo $row['id'] ?>" title="Xóa">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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
    <!-- Add/Edit Lĩnh vực Modal -->
    <div class="modal fade" id="linhvucModal" tabindex="-1" role="dialog" aria-labelledby="linhvucModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="linhvucModalLabel">Thêm Lĩnh vực mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="linhvucForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="linhvuc_id">
                        <div class="form-group">
                            <label for="ten_linh_vuc">Tên lĩnh vực *</label>
                            <input type="text" class="form-control" id="ten_linh_vuc" name="ten_linh_vuc" required>
                        </div>
                        <div class="form-group">
                            <label for="mo_ta">Mô tả</label>
                            <textarea class="form-control" id="mo_ta" name="mo_ta" rows="2"></textarea>
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
        $('#linhvucTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Vietnamese.json"
            }
        });
        // Thêm lĩnh vực
        $('.btn-primary[data-target="#linhvucModal"]').click(function() {
            $('#linhvucModalLabel').text('Thêm Lĩnh vực mới');
            $('#linhvucForm')[0].reset();
            $('#linhvuc_id').val('');
        });
        // Sửa lĩnh vực
        $('.edit-linhvuc').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '../admin/ajax.php?action=get_linhvuc',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(resp) {
                    if(resp.status == 'success') {
                        $('#linhvucModalLabel').text('Chỉnh sửa Lĩnh vực');
                        $('#linhvuc_id').val(resp.data.id);
                        $('#ten_linh_vuc').val(resp.data.ten_linh_vuc);
                        $('#mo_ta').val(resp.data.mo_ta);
                        $('#linhvucModal').modal('show');
                    } else {
                        alert(resp.msg);
                    }
                }
            });
        });
        // Lưu lĩnh vực
        $('#linhvucForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '../admin/ajax.php?action=save_linhvuc',
                type: 'POST',
                data: formData,
                success: function(resp) {
                    if(resp == 1) {
                        alert('Lưu thành công');
                        $('#linhvucModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + resp);
                    }
                }
            });
        });
        // Xóa lĩnh vực
        $('.delete-linhvuc').click(function() {
            if(confirm('Bạn có chắc chắn muốn xóa lĩnh vực này?')) {
                var id = $(this).data('id');
                $.ajax({
                    url: '../admin/ajax.php?action=delete_linhvuc',
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
    });
    </script>
</body>
</html>
