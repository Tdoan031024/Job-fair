<?php
include 'db_connect.php';
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <h2>Quản lý Banner Slides</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Danh sách Banner</h4>
                        <button class="btn btn-primary btn-sm float-right" id="new_banner">
                            <i class="fa fa-plus"></i> Thêm Banner Mới
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="banner-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Hình ảnh</th>
                                    <th class="text-center">Tiêu đề</th>
                                    <th class="text-center">Mô tả</th>
                                    <th class="text-center">Nút</th>
                                    <th class="text-center">Thứ tự</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $banners = $conn->query("SELECT * FROM banner_slides ORDER BY sort_order ASC");
                                while($row = $banners->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="text-center">
                                        <img src="assets/uploads/<?php echo $row['image'] ?>" 
                                             alt="Banner" 
                                             style="max-width: 100px; max-height: 60px; object-fit: cover;">
                                    </td>
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['subtitle'] ?></td>
                                    <td><?php echo $row['button_text'] ?></td>
                                    <td class="text-center"><?php echo $row['sort_order'] ?></td>
                                    <td class="text-center">
                                        <?php if($row['is_active'] == 1): ?>
                                            <span class="badge badge-success">Hoạt động</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Không hoạt động</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm edit_banner" 
                                                    data-id="<?php echo $row['id'] ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm delete_banner" 
                                                    data-id="<?php echo $row['id'] ?>">
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

<!-- Banner Modal -->
<div class="modal fade" id="banner_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm/Sửa Banner</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="banner_form">
                <div class="modal-body">
                    <input type="hidden" name="id" id="banner_id">
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Mô tả</label>
                        <textarea class="form-control" id="subtitle" name="subtitle" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Hình ảnh</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Kích thước khuyến nghị: 1920x800px</small>
                    </div>
                    <div class="form-group">
                        <label for="button_text">Văn bản nút</label>
                        <input type="text" class="form-control" id="button_text" name="button_text">
                    </div>
                    <div class="form-group">
                        <label for="button_link">Liên kết nút</label>
                        <input type="text" class="form-control" id="button_link" name="button_link">
                    </div>
                    <div class="form-group">
                        <label for="sort_order">Thứ tự</label>
                        <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Trạng thái</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
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

<style>
.modal-lg {
    max-width: 800px;
}
</style>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#banner-table').DataTable({
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Vietnamese.json"
        }
    });

    // New Banner
    $('#new_banner').click(function() {
        $('#banner_form')[0].reset();
        $('#banner_id').val('');
        $('#banner_modal').modal('show');
    });

    // Edit Banner
    $('.edit_banner').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: 'ajax.php?action=get_banner',
            type: 'POST',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    $('#banner_id').val(response.data.id);
                    $('#title').val(response.data.title);
                    $('#subtitle').val(response.data.subtitle);
                    $('#button_text').val(response.data.button_text);
                    $('#button_link').val(response.data.button_link);
                    $('#sort_order').val(response.data.sort_order);
                    $('#is_active').val(response.data.is_active);
                    $('#banner_modal').modal('show');
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi tải dữ liệu');
            }
        });
    });

    // Delete Banner
    $('.delete_banner').click(function() {
        var id = $(this).data('id');
        if(confirm('Bạn có chắc chắn muốn xóa banner này?')) {
            $.ajax({
                url: 'ajax.php?action=delete_banner',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    if(response.status == 'success') {
                        alert('Xóa banner thành công');
                        location.reload();
                    } else {
                        alert('Có lỗi xảy ra: ' + response.message);
                    }
                },
                error: function() {
                    alert('Có lỗi xảy ra khi xóa banner');
                }
            });
        }
    });

    // Submit Form
    $('#banner_form').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: 'ajax.php?action=save_banner',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success') {
                    alert('Lưu banner thành công');
                    $('#banner_modal').modal('hide');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi lưu banner');
            }
        });
    });
});
</script> 